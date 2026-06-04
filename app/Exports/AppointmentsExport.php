<?php

namespace App\Exports;

use App\Models\Appointment;
use Carbon\Carbon;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Illuminate\Support\Facades\Response;

class AppointmentsExport
{
    public function __construct(
        private ?string $dateFrom = null,
        private ?string $dateTo = null,
        private ?string $status = null,
        private ?int $barberId = null,
    ) {}

    public function export(): \Symfony\Component\HttpFoundation\Response
    {
        $query = Appointment::with(['customer.user', 'barber.user', 'service']);

        if ($this->dateFrom) {
            $query->whereDate('start_time', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('start_time', '<=', $this->dateTo);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->barberId) {
            $query->where('barber_id', $this->barberId);
        }

        $appointments = $query->orderBy('start_time')->get();

        $fileName = 'citas-' . Carbon::now()->format('YmdHis') . '.xlsx';
        $path = storage_path('app/temp/' . $fileName);

        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $writer = new Writer();
        $writer->openToFile($path);

        $headerStyle = (new Style())->setFontBold();

        $writer->addRow(Row::fromValues([
            'ID', 'Cliente', 'Email', 'Teléfono', 'Barbero',
            'Servicio', 'Fecha', 'Hora Inicio', 'Hora Fin',
            'Estado', 'Precio', 'Notas', 'Creado',
        ], $headerStyle));

        foreach ($appointments as $a) {
            $writer->addRow(Row::fromValues([
                $a->id,
                $a->customer?->user?->name ?? 'N/A',
                $a->customer?->user?->email ?? 'N/A',
                $a->customer?->user?->phone ?? 'N/A',
                $a->barber?->user?->name ?? 'N/A',
                $a->service?->name ?? 'N/A',
                $a->start_time->format('d/m/Y'),
                $a->start_time->format('H:i'),
                $a->end_time->format('H:i'),
                $a->status,
                $a->total_price,
                $a->notes ?? '',
                $a->created_at->format('d/m/Y H:i'),
            ]));
        }

        $writer->close();

        return Response::download($path, $fileName)->deleteFileAfterSend();
    }
}
