<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegularUserController extends Controller
{
    public function index() //This is the main page
    {
        return view('UserPage');
    }
}
