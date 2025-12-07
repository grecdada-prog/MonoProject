<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityLogsExport;

class ActivityController extends Controller
{
    /**
     * Liste des activités du gérant et ses vendeurs
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // IDs du gérant + ses vendeurs
        $userIds = [$user->id];
        $userIds = array_merge($userIds, $user->sellers()->pluck('id')->toArray());

        $query = ActivityLog::whereIn('user_id', $userIds)
            ->with('user')
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', 'LIKE', '%' . $request->action . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);

        // Liste des vendeurs pour le filtre
        $sellers = $user->sellers()->get();

        return view('gerant.activity.index', compact('logs', 'sellers'));
    }

    /**
     * Export PDF
     */
    public function exportPdf(Request $request)
    {
        $user = auth()->user();
        $userIds = [$user->id];
        $userIds = array_merge($userIds, $user->sellers()->pluck('id')->toArray());

        $logs = ActivityLog::whereIn('user_id', $userIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(500)
            ->get();

        $pdf = Pdf::loadView('gerant.activity.pdf', compact('logs', 'user'));

        return $pdf->download('historique-activite-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Excel
     */
    public function exportExcel(Request $request)
    {
        $user = auth()->user();
        $userIds = [$user->id];
        $userIds = array_merge($userIds, $user->sellers()->pluck('id')->toArray());

        return Excel::download(
            new ActivityLogsExport($userIds),
            'historique-activite-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
