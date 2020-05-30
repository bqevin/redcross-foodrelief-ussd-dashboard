<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\MetaData;
use App\ServiceRequest;
use App\USSDService;
use Carbon\Carbon;
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
    public function home()
    {
        $totalFeedback = Feedback::all()->count();
        $totalServiceRequests = ServiceRequest::all()->count();
        $totalInteraction = MetaData::all()->count();
        $totalIssues = $totalFeedback + $totalServiceRequests;

        return view('sbadmin.home', [
            'feedback' => $totalFeedback,
            'serviceRequests' => $totalServiceRequests,
            'interaction' => $totalInteraction,
            'issues' => $totalIssues
        ]);
    }

    /**
     * Show the feedback.
     *
     * @return Renderable
     */
    public function todayFeedback()
    {
        $todayFeedback = Feedback::whereDate('created_at', '>=', Carbon::today()->toDateTimeString())->get();

        return view('sbadmin.today-feedback', ['feedback' => $todayFeedback]);
    }

    public function feedback()
    {
        return view('sbadmin.all-feedback', ['feedback' =>Feedback::all()]);
    }

    public function todayServiceRequest()
    {
        $todayServiceRequest = ServiceRequest::whereDate('created_at', '>=', Carbon::today()->toDateTimeString())->get();

        return view('sbadmin.today-service-request', ['serviceRequests' => $todayServiceRequest]);
    }

    public function serviceRequest()
    {
        return view('sbadmin.all-service-request', ['serviceRequests' => ServiceRequest::all()]);
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
