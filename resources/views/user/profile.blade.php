@extends('layouts.user')
@section('breadcrumn')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    @livewire('user.profile-user')
@endsection

