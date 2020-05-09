<?php

namespace App\Http\Controllers;

use App\Complain;
use App\Request;
use Illuminate\Contracts\Support\Renderable;

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
     * @return Renderable
     */
    public function complains()
    {
        return view('complains', ['complains' => Complain::all()]);
    }

    public function requests()
    {
        return view('requests', ['requests' => Request::all()]);
    }
}
