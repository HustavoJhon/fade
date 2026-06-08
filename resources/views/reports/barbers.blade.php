<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Barbero</title>
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
    <h1>Reporte de Barbero</h1>
    <p class="subtitle">Período: {{ $dateFrom }} al {{ $dateTo }}</p>

    <div class="section-title">Rendimiento por Barbero</div>
    <table>
        <thead><tr><th>Barbero</th><th style="text-align:right">Total Citas</th><th style="text-align:right">Completadas</th><th style="text-align:right">Canceladas</th><th style="text-align:right">Ingresos</th><th style="text-align:right">Promedio</th></tr></thead>
        <tbody>
            @foreach($barbers as $b)
            <tr>
                <td>{{ $b->name }}</td>
                <td style="text-align:right">{{ $b->total_appointments }}</td>
                <td style="text-align:right">{{ $b->completed }}</td>
                <td style="text-align:right">{{ $b->cancelled }}</td>
                <td style="text-align:right">S/ {{ number_format($b->revenue, 2) }}</td>
                <td style="text-align:right">{{ $b->avg_rating ? number_format($b->avg_rating, 1) : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>