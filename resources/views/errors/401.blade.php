@extends('errors::layout')

@section('title', 'Unauthorized')
@section('image')
    <img src="{{ asset('images/others/401.png') }}" class="img-fluid">
@endsection
@section('message', 'Bạn không có quyền thực hiện yêu cầu này.')