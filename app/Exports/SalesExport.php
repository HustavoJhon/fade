<?php

namespace App\Exports;

use App\Models\Income;
use Carbon\Carbon;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Illuminate\Support\Facades\Response;

class SalesExport
{
    public function __construct(
        private ?string $dateFrom = null,
        private ?string $dateTo = null,
        private ?string $category = null,
    ) {}

    public function export(): \Symfony\Component\HttpFoundation\Response
    {
        $query = Income::with('recordedBy');

        if ($this->dateFrom) {
            $query->whereDate('recorded_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('recorded_at', '<=', $this->dateTo);
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        $incomes = $query->orderBy('recorded_at')->get();

        $fileName = 'ventas-' . Carbon::now()->format('YmdHis') . '.xlsx';
        $path = storage_path('app/temp/' . $fileName);

        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $writer = new Writer();
        $writer->openToFile($path);

        $headerStyle = (new Style())->setFontBold();

        $writer->addRow(Row::fromValues([
            'ID', 'Fecha', 'Descripción', 'Categoría', 'Monto',
            'Método de Pago', 'Registrado Por',
        ], $headerStyle));

        foreach ($incomes as $income) {
            $writer->addRow(Row::fromValues([
                $income->id,
                $income->recorded_at->format('d/m/Y H:i'),
                $income->description,
                $income->category,
                $income->amount,
                $income->payment_method ?? 'N/A',
                $income->recordedBy?->name ?? 'N/A',
            ]));
        }

        $writer->close();

        return Response::download($path, $fileName)->deleteFileAfterSend();
    }
}
