<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historique d'Activité - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #DC2626;
        }
        .header h1 {
            color: #DC2626;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .meta {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f3f4f6;
            border-radius: 5px;
        }
        .meta strong {
            color: #DC2626;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead {
            background-color: #DC2626;
            color: white;
        }
        table th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        table tbody tr:hover {
            background-color: #f9fafb;
        }
        .action {
            font-weight: bold;
            color: #DC2626;
        }
        .description {
            color: #666;
            font-size: 11px;
        }
        .user-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .user-gerant {
            background-color: #FED7AA;
            color: #C2410C;
        }
        .user-vendeur {
            background-color: #BFDBFE;
            color: #1E40AF;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
        .date-cell {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Historique d'Activité</h1>
        <p>Journal des actions effectuées</p>
    </div>

    <div class="meta">
        <p><strong>Gérant:</strong> {{ $user->name }}</p>
        <p><strong>Date d'export:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
        <p><strong>Nombre d'entrées:</strong> {{ $logs->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Date</th>
                <th style="width: 20%;">Utilisateur</th>
                <th style="width: 20%;">Action</th>
                <th style="width: 35%;">Description</th>
                <th style="width: 10%;">IP</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr>
                <td class="date-cell">
                    {{ $log->created_at->format('d/m/Y H:i') }}
                </td>
                <td>
                    {{ $log->user->name }}
                    @if($log->user->hasRole('gerant'))
                        <span class="user-badge user-gerant">Gérant</span>
                    @else
                        <span class="user-badge user-vendeur">Vendeur</span>
                    @endif
                </td>
                <td class="action">{{ $log->action }}</td>
                <td class="description">{{ $log->description ?? '-' }}</td>
                <td style="font-size: 10px;">{{ $log->ip_address ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px; color: #999;">
                    Aucune activité enregistrée
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>SmartStock - Système de Gestion de Stock</p>
        <p>Document généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
