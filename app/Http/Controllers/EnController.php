<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class EnController extends Controller
{
    public function get(){
        return 'en get';
    }
    public function post(){
        return 'en post';
    }
}
