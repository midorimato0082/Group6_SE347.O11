@extends('errors::layout')

@section('title', 'Forbidden')
@section('image')
    <img src="{{ asset('images/others/403.png') }}" class="img-fluid">
@endsection
@section('message', 'Bạn không có quyền truy cập trang này.')