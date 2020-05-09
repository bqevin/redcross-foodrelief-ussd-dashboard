<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\ServiceRequest;
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
    public function feedback()
    {
        return view('feedback', ['feedbacks' => Feedback::all()]);
    }

    public function serviceRequest()
    {
        return view('service-request', ['serviceRequests' => ServiceRequest::all()]);
    }
}
