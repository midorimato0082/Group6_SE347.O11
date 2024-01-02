@extends('errors::layout')

@section('title', 'Not Found')
@section('image')
    <img src="{{ asset('images/others/404.png') }}" class="img-fluid" alt="Review Travel Group 6 SE347.O11 - Lỗi 404">
@endsection
@section('message', 'Không tồn tại trang này.')
@section('sub-message', 'Bạn vui lòng kiểm tra lại đường dẫn.')
