@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Icon Plus registrations') }}</h1>
    @livewire('admin.icon-plus-registrations-table')
@endsection
