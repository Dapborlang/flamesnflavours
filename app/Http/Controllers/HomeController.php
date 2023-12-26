<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(isset(auth()->user()->role->role->role) && auth()->user()->role->role->role==="Admin")
        {
            return view('dashboard.admin');
        }

        if(isset(auth()->user()->role->role->role) && auth()->user()->role->role->role==="Kitchen")
        {
            return view('dashboard.kitchen');
        }

        if(isset(auth()->user()->role->role->role) && auth()->user()->role->role->role==="Reception")
        {
            return view('dashboard.reception');
        }

        if(isset(auth()->user()->role->role->role) && auth()->user()->role->role->role==="Menu")
        {
            return view('dashboard.menu');
        }

        return view('home');
    }
}
