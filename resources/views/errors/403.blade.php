@extends('errors::layout')

@section('title', 'Forbidden')
@section('image')
    <img src="{{ asset('images/others/403.png') }}" class="img-fluid" alt="Review Travel Group 6 SE347.O11 - Lỗi 403">
@endsection
@section('message', 'Bạn không có quyền truy cập trang này.')