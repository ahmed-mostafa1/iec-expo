@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Dashboard') }}</h1>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl bg-white border border-gray-200 p-4">
            <div class="text-xs text-gray-500">{{ __('Total sponsors') }}</div>
            <div class="mt-2 text-2xl font-semibold text-gray-900">{{ $totalSponsors }}</div>
        </div>

        <div class="rounded-xl bg-white border border-gray-200 p-4">
            <div class="text-xs text-gray-500">{{ __('Total visitors') }}</div>
            <div class="mt-2 text-2xl font-semibold text-gray-900">{{ $totalVisitors }}</div>
        </div>

        <div class="rounded-xl bg-white border border-gray-200 p-4">
            <div class="text-xs text-gray-500">{{ __('Today sponsors') }}</div>
            <div class="mt-2 text-2xl font-semibold text-gray-900">{{ $todaySponsors }}</div>
        </div>

        <div class="rounded-xl bg-white border border-gray-200 p-4">
            <div class="text-xs text-gray-500">{{ __('Today visitors') }}</div>
            <div class="mt-2 text-2xl font-semibold text-gray-900">{{ $todayVisitors }}</div>
        </div>
    </div>
@endsection