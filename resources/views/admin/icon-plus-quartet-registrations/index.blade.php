@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Icon Plus Quartet registrations') }}</h1>
    @livewire('admin.icon-plus-quartet-registrations-table')
@endsection
