<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function index(){

        return view('pages.penalty.index');
    }
}
