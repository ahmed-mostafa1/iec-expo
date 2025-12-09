@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Visitor registrations') }}</h1>
    @livewire('admin.visitor-registrations-table')
@endsection
