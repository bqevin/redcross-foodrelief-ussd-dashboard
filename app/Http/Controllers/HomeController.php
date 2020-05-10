<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\ServiceRequest;
use App\USSDService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var USSDService
     */
    private $ussdService;

    /**
     * Create a new controller instance.
     *
     * @param USSDService $ussdService
     */
    public function __construct(USSDService $ussdService)
    {
        $this->ussdService = $ussdService;
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

    public function ussdRequest(Request $request)
    {
        //TODO: Validation
        $sessionId = $request->get('sessionId');
        $serviceCode = $request->get('serviceCode');
        $phoneNumber = $request->get('phoneNumber');
        $text = $request->get('text');

        return $this->ussdService->processText($sessionId, $serviceCode, $phoneNumber, $text);
    }
}
