<?php

namespace App\Http\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Reports extends Component
{
    public string $dateFrom;
    public string $dateTo;
    public string $reportType = 'sales';
    public ?string $barberId = null;

    public function mount(): void
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = Carbon::now()->format('Y-m-d');
    }

    public function salesReport(): array
    {
        $incomes = Income::whereBetween('recorded_at', [$this->dateFrom, $this->dateTo . ' 23:59:59'])
            ->with('recordedBy')
            ->orderBy('recorded_at')
            ->get();

        $total = $incomes->sum('amount');
        $byCategory = $incomes->groupBy('category')->map(fn($items) => $items->sum('amount'));
        $byPaymentMethod = $incomes->groupBy('payment_method')->map(fn($items) => $items->sum('amount'));

        return compact('incomes', 'total', 'byCategory', 'byPaymentMethod');
    }

    public function appointmentsReport(): array
    {
        $query = Appointment::whereBetween('start_time', [$this->dateFrom, $this->dateTo . ' 23:59:59'])
            ->with(['customer.user', 'barber.user', 'service']);

        if ($this->barberId) {
            $query->where('barber_id', $this->barberId);
        }

        $appointments = $query->orderBy('start_time')->get();

        $total = $appointments->count();
        $byStatus = $appointments->groupBy('status')->map(fn($items) => $items->count());
        $byBarber = $appointments->groupBy('barber.user.name')->map(fn($items) => $items->count());
        $byService = $appointments->groupBy('service.name')->map(fn($items) => $items->count());
        $revenue = $appointments->whereIn('status', ['completed', 'confirmed'])->sum('total_price');

        return compact('appointments', 'total', 'byStatus', 'byBarber', 'byService', 'revenue');
    }

    public function customersReport(): array
    {
        $customers = Customer::with(['user', 'appointments' => function ($q) {
            $q->whereBetween('start_time', [$this->dateFrom, $this->dateTo . ' 23:59:59']);
        }])->get()->map(function ($c) {
            return (object) [
                'name' => $c->user->name,
                'email' => $c->user->email,
                'phone' => $c->user->phone,
                'total_visits' => $c->appointments->count(),
                'total_spent' => $c->appointments->sum('total_price'),
                'last_visit' => $c->appointments->max('start_time'),
            ];
        });

        $newCustomers = Customer::whereBetween('created_at', [$this->dateFrom, $this->dateTo . ' 23:59:59'])->count();
        $activeCustomers = $customers->where('total_visits', '>', 0)->count();

        return compact('customers', 'newCustomers', 'activeCustomers');
    }

    public function barbersReport(): array
    {
        $barbers = Barber::with('user')->get()->map(function ($b) {
            $appointments = Appointment::where('barber_id', $b->id)
                ->whereBetween('start_time', [$this->dateFrom, $this->dateTo . ' 23:59:59'])
                ->get();

            return (object) [
                'name' => $b->user->name,
                'total_appointments' => $appointments->count(),
                'completed' => $appointments->where('status', 'completed')->count(),
                'cancelled' => $appointments->where('status', 'cancelled')->count(),
                'revenue' => $appointments->sum('total_price'),
                'avg_rating' => $b->reviews()->avg('rating'),
            ];
        });

        return compact('barbers');
    }

    public function financeReport(): array
    {
        $incomes = Income::whereBetween('recorded_at', [$this->dateFrom, $this->dateTo . ' 23:59:59'])->sum('amount');
        $expenses = Expense::whereBetween('recorded_at', [$this->dateFrom, $this->dateTo . ' 23:59:59'])->sum('amount');

        $incomesByCategory = Income::whereBetween('recorded_at', [$this->dateFrom, $this->dateTo . ' 23:59:59'])
            ->get()->groupBy('category')->map(fn($items) => $items->sum('amount'));

        $expensesByCategory = Expense::whereBetween('recorded_at', [$this->dateFrom, $this->dateTo . ' 23:59:59'])
            ->get()->groupBy('category')->map(fn($items) => $items->sum('amount'));

        $balance = $incomes - $expenses;

        return compact('incomes', 'expenses', 'incomesByCategory', 'expensesByCategory', 'balance');
    }

    public function generatePDF(string $type)
    {
        $this->reportType = $type;

        $data = match ($type) {
            'sales' => $this->salesReport(),
            'appointments' => $this->appointmentsReport(),
            'customers' => $this->customersReport(),
            'barbers' => $this->barbersReport(),
            'finance' => $this->financeReport(),
            default => [],
        };

        $data['dateFrom'] = $this->dateFrom;
        $data['dateTo'] = $this->dateTo;
        $data['type'] = $type;

        $pdf = Pdf::loadView('reports.' . $type, $data);
        $filename = 'reporte-' . $type . '-' . $this->dateFrom . '-al-' . $this->dateTo . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public function generateExcel(string $type)
    {
        $this->reportType = $type;

        $fileName = 'reporte-' . $type . '-' . $this->dateFrom . '-al-' . $this->dateTo . '.xlsx';
        $path = storage_path('app/temp/' . $fileName);

        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $writer = new Writer();
        $writer->openToFile($path);

        $headerStyle = (new Style())->setFontBold();

        $headers = match ($type) {
            'sales' => ['Fecha', 'Descripción', 'Categoría', 'Monto', 'Método de Pago', 'Registrado Por'],
            'appointments' => ['Fecha', 'Cliente', 'Barbero', 'Servicio', 'Estado', 'Monto'],
            'customers' => ['Nombre', 'Email', 'Teléfono', 'Visitas', 'Total Gastado', 'Última Visita'],
            'barbers' => ['Barbero', 'Citas Totales', 'Completadas', 'Canceladas', 'Ingresos', 'Calificación Promedio'],
            'finance' => ['Tipo', 'Descripción', 'Categoría', 'Monto', 'Fecha'],
            default => [],
        };

        $writer->addRow(Row::fromValues($headers, $headerStyle));

        $data = match ($type) {
            'sales' => ($this->salesReport())['incomes']->map(fn($i) => [
                $i->recorded_at->format('Y-m-d H:i'),
                $i->description,
                $i->category,
                $i->amount,
                $i->payment_method ?? 'N/A',
                $i->recordedBy?->name ?? 'N/A',
            ]),
            'appointments' => ($this->appointmentsReport())['appointments']->map(fn($a) => [
                $a->start_time->format('Y-m-d H:i'),
                $a->customer?->user?->name ?? 'N/A',
                $a->barber?->user?->name ?? 'N/A',
                $a->service?->name ?? 'N/A',
                $a->status,
                $a->total_price,
            ]),
            'customers' => ($this->customersReport())['customers']->map(fn($c) => [
                $c->name,
                $c->email,
                $c->phone ?? 'N/A',
                $c->total_visits,
                $c->total_spent,
                $c->last_visit ? Carbon::parse($c->last_visit)->format('Y-m-d') : 'N/A',
            ]),
            'barbers' => ($this->barbersReport())['barbers']->map(fn($b) => [
                $b->name,
                $b->total_appointments,
                $b->completed,
                $b->cancelled,
                $b->revenue,
                $b->avg_rating ? number_format($b->avg_rating, 1) : 'N/A',
            ]),
            'finance' => function () {
                $data = [];
                $incomes = Income::whereBetween('recorded_at', [$this->dateFrom, $this->dateTo . ' 23:59:59'])->get();
                $expenses = Expense::whereBetween('recorded_at', [$this->dateFrom, $this->dateTo . ' 23:59:59'])->get();

                foreach ($incomes as $i) {
                    $data[] = ['Ingreso', $i->description, $i->category, $i->amount, $i->recorded_at->format('Y-m-d')];
                }
                foreach ($expenses as $e) {
                    $data[] = ['Gasto', $e->description, $e->category, $e->amount, $e->recorded_at->format('Y-m-d')];
                }

                return collect($data)->sortBy(4)->values();
            },
            default => collect(),
        };

        if ($data instanceof \Closure) {
            $data = $data();
        }

        foreach ($data as $row) {
            $writer->addRow(Row::fromValues($row));
        }

        $writer->close();

        return response()->streamDownload(function () use ($path) {
            echo file_get_contents($path);
            @unlink($path);
        }, $fileName);
    }

    public function render()
    {
        $reportData = match ($this->reportType) {
            'sales' => $this->salesReport(),
            'appointments' => $this->appointmentsReport(),
            'customers' => $this->customersReport(),
            'barbers' => $this->barbersReport(),
            'finance' => $this->financeReport(),
            default => [],
        };

        return view('livewire.admin.reports', [
            'reportData' => $reportData,
            'barbers' => Barber::with('user')->where('is_active', true)->get(),
        ]);
    }
}
