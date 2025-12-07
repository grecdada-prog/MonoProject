@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Notifications</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<h2 class="text-xl font-semibold mb-3">Non lues</h2>

@if ($unread->isEmpty())
    <p class="text-gray-500 mb-6">Aucune notification non lue.</p>
@else
    @foreach ($unread as $notification)
        <div class="bg-white p-4 shadow rounded-lg mb-3 border-l-4 border-smartred">
            <p class="font-semibold">{{ $notification->data['subject'] }}</p>
            <p class="text-gray-600">{{ $notification->data['message'] }}</p>

            <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="mt-2">
                @csrf
                <button class="text-blue-600 hover:underline">Marquer comme lue</button>
            </form>
        </div>
    @endforeach
@endif

<hr class="my-6">

<h2 class="text-xl font-semibold mb-3">Toutes les notifications</h2>

@foreach ($all as $notification)
    <div class="bg-white p-4 shadow rounded-lg mb-3">
        <p class="font-semibold">{{ $notification->data['subject'] }}</p>
        <p class="text-gray-600">{{ $notification->data['message'] }}</p>
        <p class="text-gray-400 text-sm">{{ $notification->created_at }}</p>
    </div>
@endforeach

<form method="POST" action="{{ route('notifications.readall') }}" class="mt-4">
    @csrf
    <button class="px-4 py-2 bg-smartblack text-white rounded">Tout marquer comme lu</button>
</form>

@endsection
