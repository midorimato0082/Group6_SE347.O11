<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Region;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function viewAll(){

        $all_location = Location::orderBy('id','DESC')->paginate(3);

        return view('admin.all-locations', compact('all_location'))->with('title', 'Danh sách địa điểm');
    }

    public function viewAdd(){
        $regions = Region::all();
        return view('admin.add-location', compact('regions'))->with('title', 'Thêm địa điểm');
    }

    public function viewEdit($id){
        $regions = Region::all();
        $location = Location::where('id', $id)->firstOrFail();
        return view('admin.edit-location', compact('regions', 'location'))->with('title', 'Cập nhật địa điểm');
    }

        // Các function thao tác với database
        public function update($id, Request $request)
        {

        }

        public function delete()
        {
            
        }

        public function save(Request $request)
        {

        }
}
