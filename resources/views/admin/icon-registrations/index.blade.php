@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Icon registrations') }}</h1>
    @livewire('admin.icon-registrations-table')
@endsection
