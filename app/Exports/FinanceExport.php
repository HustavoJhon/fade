<?php

namespace App\Exports;

use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Illuminate\Support\Facades\Response;

class FinanceExport
{
    public function __construct(
        private ?string $dateFrom = null,
        private ?string $dateTo = null,
        private ?string $category = null,
    ) {}

    public function export(): \Symfony\Component\HttpFoundation\Response
    {
        $fileName = 'finanzas-' . Carbon::now()->format('YmdHis') . '.xlsx';
        $path = storage_path('app/temp/' . $fileName);

        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $writer = new Writer();
        $writer->openToFile($path);

        $headerStyle = (new Style())->setFontBold();

        $incomesQuery = Income::query();
        $expensesQuery = Expense::query();

        if ($this->dateFrom) {
            $incomesQuery->whereDate('recorded_at', '>=', $this->dateFrom);
            $expensesQuery->whereDate('recorded_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $incomesQuery->whereDate('recorded_at', '<=', $this->dateTo);
            $expensesQuery->whereDate('recorded_at', '<=', $this->dateTo);
        }

        if ($this->category) {
            $incomesQuery->where('category', $this->category);
            $expensesQuery->where('category', $this->category);
        }

        // Sheet 1: Ingresos
        $writer->addRow(Row::fromValues(['INGRESOS'], $headerStyle));
        $writer->addRow(Row::fromValues([
            'ID', 'Fecha', 'Descripción', 'Categoría', 'Monto', 'Método de Pago',
        ], $headerStyle));

        $incomes = $incomesQuery->orderBy('recorded_at')->get();
        $totalIncome = 0;

        foreach ($incomes as $income) {
            $writer->addRow(Row::fromValues([
                $income->id,
                $income->recorded_at->format('d/m/Y H:i'),
                $income->description,
                $income->category,
                $income->amount,
                $income->payment_method ?? 'N/A',
            ]));
            $totalIncome += $income->amount;
        }

        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues(['Total Ingresos', '', '', '', $totalIncome], $headerStyle));
        $writer->addRow(Row::fromValues([]));

        // Sheet 2: Gastos
        $writer->addRow(Row::fromValues(['GASTOS'], $headerStyle));
        $writer->addRow(Row::fromValues([
            'ID', 'Fecha', 'Descripción', 'Categoría', 'Monto', 'Método de Pago',
        ], $headerStyle));

        $expenses = $expensesQuery->orderBy('recorded_at')->get();
        $totalExpense = 0;

        foreach ($expenses as $expense) {
            $writer->addRow(Row::fromValues([
                $expense->id,
                $expense->recorded_at->format('d/m/Y H:i'),
                $expense->description,
                $expense->category,
                $expense->amount,
                $expense->payment_method ?? 'N/A',
            ]));
            $totalExpense += $expense->amount;
        }

        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues(['Total Gastos', '', '', '', $totalExpense], $headerStyle));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues(['Balance', '', '', '', $totalIncome - $totalExpense], $headerStyle));

        $writer->close();

        return Response::download($path, $fileName)->deleteFileAfterSend();
    }
}
