<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivityLogsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userIds;

    public function __construct(array $userIds = [])
    {
        $this->userIds = $userIds;
    }

    public function collection()
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');

        if (!empty($this->userIds)) {
            $query->whereIn('user_id', $this->userIds);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Heure',
            'Utilisateur',
            'Email',
            'Rôle',
            'Action',
            'Description',
            'Adresse IP',
        ];
    }

    public function map($log): array
    {
        $role = 'N/A';
        if ($log->user) {
            if ($log->user->hasRole('super-admin')) {
                $role = 'Super Admin';
            } elseif ($log->user->hasRole('gerant')) {
                $role = 'Gérant';
            } elseif ($log->user->hasRole('vendeur')) {
                $role = 'Vendeur';
            }
        }

        return [
            $log->created_at->format('d/m/Y'),
            $log->created_at->format('H:i:s'),
            $log->user->name ?? 'Utilisateur supprimé',
            $log->user->email ?? '-',
            $role,
            $log->action,
            $log->description ?? '-',
            $log->ip_address ?? '-',
        ];
    }
}
