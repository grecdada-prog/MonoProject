<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Exports\ActivityLogsExport;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('superadmin.activity.index', [
            'logs' => ActivityLog::with('user')
                ->orderByDesc('created_at')
                ->paginate(50),
        ]);
    }

    public function exportPdf()
    {
        $logs = ActivityLog::with('user')->orderByDesc('created_at')->get();

        $pdf = Pdf::loadView('superadmin.activity.export-pdf', compact('logs'));

        return $pdf->download('activity_logs.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ActivityLogsExport, 'activity_logs.xlsx');
    }
}
