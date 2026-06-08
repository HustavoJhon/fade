<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Clientes</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 20px; margin: 0 0 4px; }
        .subtitle { color: #6b7280; font-size: 11px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th { background: #111827; color: #fff; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        .summary { display: flex; gap: 16px; margin-bottom: 20px; }
        .summary-card { flex: 1; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; text-align: center; }
        .summary-card .value { font-size: 18px; font-weight: bold; color: #059669; }
        .summary-card .label { font-size: 10px; color: #6b7280; text-transform: uppercase; }
        .section-title { font-size: 13px; font-weight: bold; margin: 20px 0 8px; color: #111827; }
    </style>
</head>
<body>
    <h1>Reporte de Clientes</h1>
    <p class="subtitle">Período: {{ $dateFrom }} al {{ $dateTo }}</p>

    <div class="summary">
        <div class="summary-card">
            <div class="value">{{ $customers->count() }}</div>
            <div class="label">Total Clientes</div>
        </div>
        <div class="summary-card">
            <div class="value">{{ $newCustomers }}</div>
            <div class="label">Nuevos</div>
        </div>
        <div class="summary-card">
            <div class="value">{{ $activeCustomers }}</div>
            <div class="label">Activos</div>
        </div>
    </div>

    <div class="section-title">Clientes</div>
    <table>
        <thead><tr><th>Nombre</th><th>Email</th><th>Teléfono</th><th style="text-align:right">Visitas</th><th style="text-align:right">Gasto Total</th><th>Última Visita</th></tr></thead>
        <tbody>
            @foreach($customers as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->email }}</td>
                <td>{{ $c->phone ?? '-' }}</td>
                <td style="text-align:right">{{ $c->total_visits }}</td>
                <td style="text-align:right">S/ {{ number_format($c->total_spent, 2) }}</td>
                <td>{{ $c->last_visit ? \Carbon\Carbon::parse($c->last_visit)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>