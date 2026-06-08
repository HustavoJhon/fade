<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
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
        .summary-card .value { font-size: 18px; font-weight: bold; color: #059669; }
        .summary-card .label { font-size: 10px; color: #6b7280; text-transform: uppercase; }
        .section-title { font-size: 13px; font-weight: bold; margin: 20px 0 8px; color: #111827; }
    </style>
</head>
<body>
    <h1>Reporte de Ventas</h1>
    <p class="subtitle">Período: {{ $dateFrom }} al {{ $dateTo }}</p>

    <div class="summary">
        <div class="summary-card">
            <div class="value">S/ {{ number_format($total, 2) }}</div>
            <div class="label">Total</div>
        </div>
        <div class="summary-card">
            <div class="value">{{ $incomes->count() }}</div>
            <div class="label">Transacciones</div>
        </div>
    </div>

    <div class="section-title">Por Categoría</div>
    <table>
        <thead><tr><th>Categoría</th><th style="text-align:right">Total</th></tr></thead>
        <tbody>
            @foreach($byCategory as $cat => $amount)
            <tr><td>{{ ucfirst($cat) }}</td><td style="text-align:right">S/ {{ number_format($amount, 2) }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Por Método de Pago</div>
    <table>
        <thead><tr><th>Método</th><th style="text-align:right">Total</th></tr></thead>
        <tbody>
            @foreach($byPaymentMethod as $method => $amount)
            <tr><td>{{ ucfirst(str_replace('_', ' ', $method)) }}</td><td style="text-align:right">S/ {{ number_format($amount, 2) }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Detalle de Ingresos</div>
    <table>
        <thead><tr><th>Fecha</th><th>Descripción</th><th>Categoría</th><th>Registrado por</th><th style="text-align:right">Monto</th></tr></thead>
        <tbody>
            @foreach($incomes as $income)
            <tr>
                <td>{{ $income->recorded_at->format('d/m/Y') }}</td>
                <td>{{ $income->description }}</td>
                <td>{{ ucfirst($income->category) }}</td>
                <td>{{ $income->recordedBy?->name ?? '-' }}</td>
                <td style="text-align:right">S/ {{ number_format($income->amount, 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row"><td colspan="4">Total</td><td style="text-align:right">S/ {{ number_format($total, 2) }}</td></tr>
        </tbody>
    </table>
</body>
</html>