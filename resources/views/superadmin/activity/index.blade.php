@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Historique / Audit</h1>

<div class="mb-4 flex gap-4">
    <a href="{{ route('superadmin.activity.export.pdf') }}"
       class="px-4 py-2 bg-smartblack text-white rounded">Export PDF</a>

    <a href="{{ route('superadmin.activity.export.excel') }}"
       class="px-4 py-2 bg-smartred text-white rounded">Export Excel</a>
</div>

<table class="w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 text-left">Date</th>
            <th class="p-2 text-left">Utilisateur</th>
            <th class="p-2 text-left">Action</th>
            <th class="p-2 text-left">Description</th>
            <th class="p-2 text-left">IP</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
            <tr class="border-t">
                <td class="p-2">{{ $log->created_at }}</td>
                <td class="p-2">{{ $log->user?->email ?? 'SYSTEM' }}</td>
                <td class="p-2">{{ $log->action }}</td>
                <td class="p-2">{{ $log->description }}</td>
                <td class="p-2">{{ $log->ip_address }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $logs->links() }}
</div>

@endsection
