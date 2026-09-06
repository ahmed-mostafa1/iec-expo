@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Check-ins') }}</h1>
    @livewire('admin.check-ins-table')
@endsection
