@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Sponsor registrations') }}</h1>
    @livewire('admin.sponsor-registrations-table')
@endsection
