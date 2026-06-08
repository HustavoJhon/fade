<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Citas</title>
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
    <h1>Reporte de Citas</h1>
    <p class="subtitle">Período: {{ $dateFrom }} al {{ $dateTo }}</p>

    <div class="summary">
        <div class="summary-card">
            <div class="value">{{ $total }}</div>
            <div class="label">Total Citas</div>
        </div>
        <div class="summary-card">
            <div class="value">S/ {{ number_format($revenue, 2) }}</div>
            <div class="label">Ingresos</div>
        </div>
    </div>

    <div class="section-title">Por Estado</div>
    <table>
        <thead><tr><th>Estado</th><th style="text-align:right">Cantidad</th></tr></thead>
        <tbody>
            @foreach($byStatus as $status => $count)
            <tr><td>{{ ucfirst($status) }}</td><td style="text-align:right">{{ $count }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Por Barbero</div>
    <table>
        <thead><tr><th>Barbero</th><th style="text-align:right">Citas</th></tr></thead>
        <tbody>
            @foreach($byBarber as $barber => $count)
            <tr><td>{{ $barber }}</td><td style="text-align:right">{{ $count }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Por Servicio</div>
    <table>
        <thead><tr><th>Servicio</th><th style="text-align:right">Cantidad</th></tr></thead>
        <tbody>
            @foreach($byService as $service => $count)
            <tr><td>{{ $service }}</td><td style="text-align:right">{{ $count }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Detalle de Citas</div>
    <table>
        <thead><tr><th>Fecha</th><th>Cliente</th><th>Barbero</th><th>Servicio</th><th>Estado</th><th style="text-align:right">Total</th></tr></thead>
        <tbody>
            @foreach($appointments as $a)
            <tr>
                <td>{{ $a->start_time->format('d/m/Y H:i') }}</td>
                <td>{{ $a->customer?->user?->name ?? '-' }}</td>
                <td>{{ $a->barber?->user?->name ?? '-' }}</td>
                <td>{{ $a->service?->name ?? '-' }}</td>
                <td>{{ ucfirst($a->status) }}</td>
                <td style="text-align:right">S/ {{ number_format($a->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>