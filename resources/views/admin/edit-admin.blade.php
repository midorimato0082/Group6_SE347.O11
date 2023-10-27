@extends('layouts.admin')

@section('content')
    @livewire('edit-admin', ['id' => $id])
@endsection
