<?php

namespace Sites\granitecms_dev\theme\controllers;

use App\Http\Controllers\Controller;
// use Auth;
use Illuminate\Http\Request;

class CustomController extends Controller
{
    public function index(Request $request)
    {

        // $user = Auth::loginUsingId(1, true);
        return view('granitecms_dev.theme.views.home');
    }
}
