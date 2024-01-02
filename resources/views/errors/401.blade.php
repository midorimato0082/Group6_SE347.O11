@extends('errors::layout')

@section('title', 'Unauthorized')
@section('image')
    <img src="{{ asset('images/others/401.png') }}" class="img-fluid" alt="Việt Nam Review Travel 401">
@endsection
@section('message', 'Bạn không có quyền thực hiện yêu cầu này.')