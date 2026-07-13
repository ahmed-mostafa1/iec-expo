@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Icon Quartet registrations') }}</h1>
    @livewire('admin.icon-quartet-registrations-table')
@endsection
