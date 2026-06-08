<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Financiero</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 20px; margin: 0 0 4px; }
        .subtitle { color: #6b7280; font-size: 11px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th { background: #111827; color: #fff; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        .total-row td { font-weight: bold; border-top: 2px solid #111827; }
        .summary { display: flex; gap: 16px; margin-bottom: 20px; }
        .summary-card { flex: 1; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; text-align: center; }
        .summary-card .value { font-size: 18px; font-weight: bold; }
        .summary-card .label { font-size: 10px; color: #6b7280; text-transform: uppercase; }
        .section-title { font-size: 13px; font-weight: bold; margin: 20px 0 8px; color: #111827; }
        .positive { color: #059669; }
        .negative { color: #dc2626; }
    </style>
</head>
<body>
    <h1>Reporte Financiero</h1>
    <p class="subtitle">Período: {{ $dateFrom }} al {{ $dateTo }}</p>

    <div class="summary">
        <div class="summary-card">
            <div class="value positive">S/ {{ number_format($incomes, 2) }}</div>
            <div class="label">Ingresos</div>
        </div>
        <div class="summary-card">
            <div class="value negative">S/ {{ number_format($expenses, 2) }}</div>
            <div class="label">Gastos</div>
        </div>
        <div class="summary-card">
            <div class="value {{ $balance >= 0 ? 'positive' : 'negative' }}">S/ {{ number_format($balance, 2) }}</div>
            <div class="label">Balance</div>
        </div>
    </div>

    <div class="section-title">Ingresos por Categoría</div>
    <table>
        <thead><tr><th>Categoría</th><th style="text-align:right">Monto</th></tr></thead>
        <tbody>
            @foreach($incomesByCategory as $cat => $amount)
            <tr><td>{{ ucfirst($cat) }}</td><td style="text-align:right">S/ {{ number_format($amount, 2) }}</td></tr>
            @endforeach
            <tr class="total-row"><td>Total Ingresos</td><td style="text-align:right">S/ {{ number_format($incomes, 2) }}</td></tr>
        </tbody>
    </table>

    <div class="section-title">Gastos por Categoría</div>
    <table>
        <thead><tr><th>Categoría</th><th style="text-align:right">Monto</th></tr></thead>
        <tbody>
            @foreach($expensesByCategory as $cat => $amount)
            <tr><td>{{ ucfirst($cat) }}</td><td style="text-align:right">S/ {{ number_format($amount, 2) }}</td></tr>
            @endforeach
            <tr class="total-row"><td>Total Gastos</td><td style="text-align:right">S/ {{ number_format($expenses, 2) }}</td></tr>
        </tbody>
    </table>

    <div class="section-title">Resumen</div>
    <table>
        <tr><td>Ingresos</td><td style="text-align:right">S/ {{ number_format($incomes, 2) }}</td></tr>
        <tr><td>Gastos</td><td style="text-align:right">S/ {{ number_format($expenses, 2) }}</td></tr>
        <tr class="total-row"><td>Balance {{ $balance >= 0 ? 'Positivo' : 'Negativo' }}</td><td style="text-align:right">S/ {{ number_format($balance, 2) }}</td></tr>
    </table>
</body>
</html>