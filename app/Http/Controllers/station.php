<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class station extends Controller
{
    public function index($id)
    {
        return view('station', ['id' => $id]);
    }
}
