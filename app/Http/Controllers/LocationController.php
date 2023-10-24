<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function viewAll(){

        $all_location = Location::orderBy('id','DESC')->paginate(3);

        return view('admin.all_location', compact('all_location'))->with('title', 'Danh sách địa điểm');
    }

    public function viewAdd(){
        return view('admin.add_location')->with('title', 'Thêm địa điểm');
    }

    public function viewEdit(){
        return view('admin.edit_location')->with('title', 'Cập nhật địa điểm');
    }
}
