<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photos;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $allPhoto = Photos::all()->where('isActive', '0')->count();
        $newPhoto = Photos::all()->where('isActive', '0')->count();
        $data = [
            'allPhoto' => $allPhoto,
            'newPhoto' => $newPhoto
        ];

        return view('admin.home.index', $data);
    }
}
