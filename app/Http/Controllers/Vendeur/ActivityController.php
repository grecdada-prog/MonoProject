<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityLogsExport;

class ActivityController extends Controller
{
    /**
     * Liste des activités du vendeur
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = ActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Filtres
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

        return view('vendeur.activity.index', compact('logs'));
    }

    /**
     * Export PDF
     */
    public function exportPdf()
    {
        $user = auth()->user();

        $logs = ActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(500)
            ->get();

        $pdf = Pdf::loadView('vendeur.activity.pdf', compact('logs', 'user'));

        return $pdf->download('mon-historique-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Excel
     */
    public function exportExcel()
    {
        $user = auth()->user();

        return Excel::download(
            new ActivityLogsExport([$user->id]),
            'mon-historique-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
