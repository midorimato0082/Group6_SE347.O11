<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function viewError($code)
    {
        return view('layouts.error')->with('title', $code)->with('message', $this->showMessage($code));;
    }

    private function showMessage($code)
    {
        switch ($code) {
            case 401:
                return 'Bạn không có quyền truy cập trang này.';
            case 404:
                return 'Không tồn tại trang này.';
            default:
                return 'Something went wrong.';
        }
    }
}
