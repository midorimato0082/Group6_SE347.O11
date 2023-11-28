@extends('errors::layout')

@section('title', 'Not Found')
@section('image')
    <img src="{{ asset('images/others/404.png') }}" class="img-fluid">
@endsection
@section('message', 'Không tồn tại trang này.')
@section('sub-message', 'Bạn vui lòng kiểm tra lại đường dẫn.')
