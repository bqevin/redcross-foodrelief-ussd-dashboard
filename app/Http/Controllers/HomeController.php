<?php

namespace App\Http\Controllers;

use App\ATSession;
use App\Feedback;
use App\MetaData;
use App\ServiceRequest;
use App\USSDService;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
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
        $metadata = MetaData::all();
        $totalIssues = $totalFeedback + $totalServiceRequests;
        $english = $metadata->filter(function ($meta) {
            $extra = json_decode($meta->extra);
            if ($extra->language) {
                return $extra->language == '1';
            }
        });

        $swahili = $metadata->filter(function ($meta) {
            $extra = json_decode($meta->extra);
            if ($extra->language) {
                return $extra->language == '2';
            }
        });

        return view('sbadmin.home', [
            'feedback' => $totalFeedback,
            'serviceRequests' => $totalServiceRequests,
            'interactions' => $metadata->count(),
            'english' => $english->count(),
            'swahili' => $swahili->count(),
            'issues' => $totalIssues,
            'jan_sessions' => $this->getTrafficForMonthOf(1)->count(),
            'feb_sessions' => $this->getTrafficForMonthOf(2)->count(),
            'mar_sessions' => $this->getTrafficForMonthOf(3)->count(),
            'apr_sessions' => $this->getTrafficForMonthOf(4)->count(),
            'may_sessions' => $this->getTrafficForMonthOf(5)->count(),
            'jun_sessions' => $this->getTrafficForMonthOf(6)->count(),
            'jul_sessions' => $this->getTrafficForMonthOf(7)->count(),
            'aug_sessions' => $this->getTrafficForMonthOf(8)->count(),
            'sep_sessions' => $this->getTrafficForMonthOf(9)->count(),
            'oct_sessions' => $this->getTrafficForMonthOf(10)->count(),
            'nov_sessions' => $this->getTrafficForMonthOf(11)->count(),
            'dec_sessions' => $this->getTrafficForMonthOf(12)->count(),
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
        return view('sbadmin.all-feedback', ['feedback' => Feedback::all()]);
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

    private function getTrafficForMonthOf(int $monthInt): ?Builder
    {
        return ATSession::whereMonth('created_at', $monthInt);
    }
}
