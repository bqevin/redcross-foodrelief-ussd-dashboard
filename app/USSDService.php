<?php

namespace App;

use Carbon\Carbon;

class USSDService
{
    public function processText(
        $sessionId,
        $serviceCode,
        $phoneNumber,
        $text
    ) {
        $recoveries = 'calculating...';
        $cases = 'calculating...';
        $deaths = 'calculating...';
        $lastUpdated = Carbon::today()->toDateTimeString();
        $response = '';
        $ussdStringArray = explode("*", $text);

        //Persist sessions for analytics
        $this->saveOrUpdateSession($sessionId, $serviceCode, $phoneNumber, $ussdStringArray);

        //TODO: REFACTOR!
        if ($text == "1*2*2" || $text == "2*2*2" || $text == "1*1*7" || $text == "1*1*98*7" || $text == "2*1*7" || $text == "2*1*98*7") {
            $stats = $this->getLatestStats();
            $cases = $stats->cases;
            $deaths = $stats->deaths;
            $recoveries = $stats->recoveries;
            $lastUpdated = $stats->creation;
        }

        // Get ussd menu level number from the gateway
        $steps = count($ussdStringArray);
        if ($text == "") {
            $response = $this->launchText();
        } elseif ($text == "1") {
            $response = $this->welcomeTextEnglish();
        } elseif ($text == "2") {
            $response = $this->welcomeTextSwahili();
        } elseif ($text == "1*1") {
            $response = $this->oldTownServicesEnglish();
        } elseif ($text == "1*2") {
            $response = $this->notOldTownEnglish();
        } elseif ($text == "2*2") {
            $response = $this->notOldTownSwahili();
        } elseif ($text == "2*1") {
            $response = $this->oldTownServicesSwahili();
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 1) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 2) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 3) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 4) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 98 && $ussdStringArray[3] == 5) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 98 && $ussdStringArray[3] == 6) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 1) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 2) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 3) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 4) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 98 && $ussdStringArray[3] == 5) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 98 && $ussdStringArray[3] == 6) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } // General Feedback/Complains questions Starts here
        elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 2 && $ussdStringArray[2] == 1) {
            $response = $this->loopFeedbackQuestionsEnglish($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 2 && $ussdStringArray[2] == 1) {
            $response = $this->loopFeedbackQuestionsSwahili($ussdStringArray, $steps, $sessionId, $serviceCode, $phoneNumber);
        } elseif ($text == "1*2*2") {
            //TODO: REFACTOR!
            $this->saveGuestMetaData($sessionId, $serviceCode, $phoneNumber, $ussdStringArray);
            $response = "END Kenya ({$lastUpdated})\n\nCases : {$cases}\n Recoveries : {$recoveries}\n Deaths : {$deaths} \n\n Thank you for your feedback. Stay Safe.";
        } elseif ($text == "2*2*2") {
            //TODO: REFACTOR!
            $this->saveGuestMetaData($sessionId, $serviceCode, $phoneNumber, $ussdStringArray);
            $response = "END Kenya ({$lastUpdated})\n\nCases : {$cases}\n Recoveries : {$recoveries}\n Deaths : {$deaths} \n\nAhsante. Kwaheri!";
        } else if ($text == "1*1*7" || $text == "1*1*98*7") {
            //TODO: REFACTOR!
            $this->saveGuestMetaData($sessionId, $serviceCode, $phoneNumber, $ussdStringArray);
            $response = "END Kenya ({$lastUpdated})\n\nCases : {$cases}\n Recoveries : {$recoveries}\n Deaths : {$deaths} \n\nThank you for checking out our hotline. Stay Safe.";
        } else if ($text == "2*1*7" || $text == "2*1*98*7") {
            //TODO: REFACTOR!
            $this->saveGuestMetaData($sessionId, $serviceCode, $phoneNumber, $ussdStringArray);
            $response = "END Kenya ({$lastUpdated})\n\nCases : {$cases}\n Recoveries : {$recoveries}\n Deaths : {$deaths} \n\nAhsante kwa kufika kwa huduma zetu za hotline. Kwaheri!";
        }

        return $response;
    }

    private function loopServiceQuestionsSwahili($textArray, $stepsCount, $sessionId = null, $serviceCode = null, $phoneNumber = null)
    {
        $response = '';
        //TODO: REFACTOR!
        if ($textArray[2] == 98) {
            if ($stepsCount == 4) {
                $response = "CON Tafadhali eleza ombi lako kwa undani zaidi.";
            }

            if ($stepsCount == 5) {
                $response = "CON Tupe nambari ya simu tunaweza kuwasiliana na wewe hapa";
            }

            if ($stepsCount == 6) {
                $response = "CON Katika nyumba yenu muko wangapi?";
            }

            if ($stepsCount == 7) {
                $response = "CON Tunaweza kuifikia vipi nyumba yako? Tafadhali tupe ramani, rangi ya mlango wako. Nambari ya chumba chako.";
            }

            if ($stepsCount == 8) {
                $response = "CON Ni nani mzee wa nyumba kumi mtaani kwenu?";
            }

            // end of questions
            if ($stepsCount > 8) {
                $serviceRequest = $this->saveServiceRequest($textArray, $this->saveGeoLocationServiceRequest($textArray));
                $this->saveServiceRequestMetadata($serviceRequest, $sessionId, $serviceCode, $phoneNumber, $textArray);
                $response = "END Ahsante kwa ombi yako, muhudumu wetu ataishughulikia kwa upesi iwezekwanavyo";
            }

            return $response;
        }

        if ($stepsCount == 3) {
            $response = "CON Tafadhali eleza ombi lako kwa undani zaidi.";
        }

        if ($stepsCount == 4) {
            $response = "CON Tupe nambari ya simu tunaweza kuwasiliana na wewe hapa";
        }

        if ($stepsCount == 5) {
            $response = "CON Katika nyumba yenu muko wangapi?";
        }

        if ($stepsCount == 6) {
            $response = "CON Tunaweza kuifikia vipi nyumba yako? Tafadhali tupe ramani, rangi ya mlango wako. Nambari ya chumba chako.";
        }

        if ($stepsCount == 7) {
            $response = "CON Ni nani mzee wa nyumba kumi mtaani kwenu?";
        }

        // end of questions
        if ($stepsCount > 7) {
            $serviceRequest = $this->saveServiceRequest($textArray, $this->saveGeoLocationServiceRequest($textArray));
            $this->saveServiceRequestMetadata($serviceRequest, $sessionId, $serviceCode, $phoneNumber, $textArray);
            $response = "END Ahsante kwa ombi yako, muhudumu wetu ataishughulikia kwa upesi iwezekwanavyo";
        }

        return $response;
    }

    private function loopServiceQuestionsEnglish($textArray, $stepsCount, $sessionId = null, $serviceCode = null, $phoneNumber = null)
    {
        $response = '';
        //TODO: REFACTOR!
        if ($textArray[2] == 98) {
            if ($stepsCount == 4) {
                $response = "CON Please tell us about your request in details";
            }

            if ($stepsCount == 5) {
                $response = "CON Please reply with your phone number, in order for us to contact you.";
            }

            if ($stepsCount == 6) {
                $response = "CON How many are you in your household?";
            }

            if ($stepsCount == 7) {
                $response = "CON How can we access your residence? Please share exact details including door number, color if there is one.";
            }

            if ($stepsCount == 8) {
                $response = "CON Who is your village elder?";
            }

            // end of questions
            if ($stepsCount > 8) {
                $serviceRequest = $this->saveServiceRequest($textArray, $this->saveGeoLocationServiceRequest($textArray));
                $this->saveServiceRequestMetadata($serviceRequest, $sessionId, $serviceCode, $phoneNumber, $textArray);
                $response = "END Thank you for your request, a service agent will get back to you as soon as possible";
            }

            return $response;
        }

        if ($stepsCount == 3) {
            $response = "CON Please tell us about your request in details";
        }

        if ($stepsCount == 4) {
            $response = "CON Please reply with your phone number, in order for us to contact you.";
        }

        if ($stepsCount == 5) {
            $response = "CON How many are you in your household?";
        }

        if ($stepsCount == 6) {
            $response = "CON How can we access your residence? Please share exact details including door number, color if there is one.";
        }

        if ($stepsCount == 7) {
            $response = "CON Who is your village elder?";
        }

        // end of questions
        if ($stepsCount > 7) {
            $serviceRequest = $this->saveServiceRequest($textArray, $this->saveGeoLocationServiceRequest($textArray));
            $this->saveServiceRequestMetadata($serviceRequest, $sessionId, $serviceCode, $phoneNumber, $textArray);
            $response = "END Thank you for your request, a service agent will get back to you as soon as possible";
        }

        return $response;
    }

    private function loopFeedbackQuestionsSwahili($textArray, $stepsCount, $sessionId = null, $serviceCode = null, $phoneNumber = null)
    {
        $response = '';

        if ($stepsCount == 3) {
            $response = "CON Maoni, lawama au pendekezo lako ni yepi?";
        }

        if ($stepsCount == 4) {
            $response = "CON Kisa kimetokea lini?";
        }

        if ($stepsCount == 5) {
            $response = "CON Mzee wa mtaa wako ni nani?";
        }

        if ($stepsCount == 6) {
            $response = "CON Elezea jinsi tutafika kwako. Tupe mwelekezo wa ramani, rangi ya nyumba na namba ya chumba kama kunayo";
        }

        if ($stepsCount == 7) {
            $response = "CON Jina la kata yako?";
        }
        if ($stepsCount == 8) {
            $response = "CON Unatoka eneo bunge gani?";
        }


        // end of questions
        if ($stepsCount > 8) {
            $feedback = $this->saveFeedback($textArray, $this->saveGeoLocationFeedback($textArray));
            $this->saveFeedbackMetadata($feedback, $sessionId, $serviceCode, $phoneNumber, $textArray); // Save Feedback metadata
            $response = "END Ahsante kwa kuripoti hilo tukio. Itashughulikwa kwa haraka iwezekenavyo!";
        }

        return $response;
    }

    private function loopFeedbackQuestionsEnglish($textArray, $stepsCount, $sessionId = null, $serviceCode = null, $phoneNumber = null)
    {
        $response = '';

        if ($stepsCount == 3) {
            $response = "CON What is your suggestion/ complain/ report?";
        }

        if ($stepsCount == 4) {
            $response = "CON When did this happen?";
        }

        if ($stepsCount == 5) {
            $response = "CON What is the name of your village elder?";
        }

        if ($stepsCount == 6) {
            $response = "CON Where do you stay? Please be detailed as possible";
        }

        if ($stepsCount == 7) {
            $response = "CON What is the name of your ward?";
        }
        if ($stepsCount == 8) {
            $response = "CON What is the name of your constituency?";
        }


        // end of questions
        if ($stepsCount > 8) {
            $feedback = $this->saveFeedback($textArray, $this->saveGeoLocationFeedback($textArray));
            $this->saveFeedbackMetadata($feedback, $sessionId, $serviceCode, $phoneNumber, $textArray); // save Metadata
            $response = "END Thank you for the report. This will be acted upon by respective people as soon as possible!";
        }

        return $response;
    }

    private function welcomeTextSwahili()
    {
        $response = "CON Wewe ni mkaazi wa Old Town?. \n\n";
        $response .= "1. Ndio \n";
        $response .= "2. La";

        return $response;
    }

    private function welcomeTextEnglish()
    {
        $response = "CON Are you an Old Town resident?. \n\n";
        $response .= "1. Yes \n";
        $response .= "2. No";

        return $response;
    }

    private function launchText()
    {
        $response = "CON Welcome to Mombasa County Relief Services.\nWe are here to Serve you.\n\n Pick a language (Chagua lugha) \n\n";
        $response .= "1. English \n";
        $response .= "2. Swahili";

        return $response;
    }

    private function oldTownServicesSwahili()
    {
        $response = "CON Ni huduma gani unahitaji kutoka kwa Kaunti ya Mombasa?  \n";
        $response .= "1. Kupimwa Corona\n";
        $response .= "2. Kuripoti Mshukiwa wa Corona\n";
        $response .= "3. Usadizi Wa Matibabu\n";
        $response .= "4. Msaada Wa Chakula\n";
        $response .= "5. Uzoaji Wa Takataka\n";
        $response .= "6. Dharura Nyengine\n";
        $response .= "7. Hakuna";

        return $response;
    }

    private function oldTownServicesEnglish()
    {
        $response = "CON What service do you require from Mombasa County?\n";
        $response .= "1. Get tested for COVID-19\n";
        $response .= "2. Report a suspected COVID-19 case\n";
        $response .= "3. Healthcare assistance\n";
        $response .= "4. Relief food assistance\n";
        $response .= "5. Garbage collection\n";
        $response .= "6. Other emergency\n";
        $response .= "7. Nothing";

        return $response;
    }


    private function notOldTownEnglish()
    {
        $response = "CON Do you have any feedback or suggestion regarding relief food distribution in Mombasa County?\n";
        $response .= "1. Yes\n";
        $response .= "2. No";

        return $response;
    }

    private function notOldTownSwahili()
    {
        $response = "CON Una maoni yoyote kuhusu ugavi wa chakula cha msaada kutoka kwa Kaunti ya Mombasa?\n";
        $response .= "1. Ndio\n";
        $response .= "2. La";

        return $response;
    }

    private function saveGeoLocationServiceRequest(array $textArray): GeoLocation
    {
        $locationDesc = isset($textArray[6]) ? $textArray[6] : null;
        if ($textArray[2] == 98) {
            $locationDesc = isset($textArray[7]) ? $textArray[7] : null;
        }

        return GeoLocation::create([
            'location_description' => $locationDesc,
            'ward' => "Old Town",
            'constituency' => "Mvita Constituency",
            'lat' => null,
            'lng' => null
        ]);
    }

    private function saveServiceRequest($textArray, GeoLocation $geo): ServiceRequest
    {
        $details = isset($textArray[3]) ? $textArray[3] : null;
        $contactInfo = isset($textArray[4]) ? $textArray[4] : null;
        $official = isset($textArray[7]) ? $textArray[7] : null;
        $geoId = $geo ? $geo->id : null;
        $type = $textArray[2];
        $householdNumber = isset($textArray[5]) ? $textArray[5] : null;

        if ($textArray[2] == 98) {
            $details = isset($textArray[4]) ? $textArray[4] : null;
            $contactInfo = isset($textArray[5]) ? $textArray[5] : null;
            $official = isset($textArray[8]) ? $textArray[8] : null;
            $type = $textArray[3];
        }

        return ServiceRequest::create([
            'details' => $details,
            'contact_info' => $contactInfo,
            'official' => $official,
            'geo_location_id' => $geoId,
            'type' => $type,
            'household_number' => $householdNumber
        ]);
    }

    private function saveGeoLocationFeedback(array $textArray): GeoLocation
    {
        return GeoLocation::create([
            'location_description' => isset($textArray[6]) ? $textArray[6] : null,
            'ward' => isset($textArray[7]) ? $textArray[7] : null,
            'constituency' => isset($textArray[8]) ? $textArray[8] : null,
            'lat' => null,
            'lng' => null
        ]);
    }

    private function saveFeedback($textArray, GeoLocation $geo = null): Feedback
    {
        return Feedback::create([
            'description' => isset($textArray[3]) ? $textArray[3] : null,
            'official' => isset($textArray[5]) ? $textArray[5] : null,
            'occurrence_date' => isset($textArray[4]) ? $textArray[4] : null,
            'geo_location_id' => $geo ? $geo->id : null
        ]);
    }

    //TODO: REFACTOR!
    private function saveFeedbackMetadata(
        Feedback $feedback,
        $sessionId,
        $serviceCode,
        $phoneNumber,
        $textArray
    ): MetaData {
        return MetaData::create([
            'extra' => json_encode([
                'session_id' => $sessionId,
                'service_code' => $serviceCode,
                'phone_number' => $phoneNumber,
                'feedback_id' => $feedback->id,
                'language' => $textArray[0],
                'text_array' => $textArray,
            ])
        ]);
    }

    //TODO: REFACTOR!
    private function saveServiceRequestMetadata(
        ServiceRequest $serviceRequest,
        $sessionId,
        $serviceCode,
        $phoneNumber,
        $textArray
    ): MetaData {
        return MetaData::create([
            'extra' => json_encode([
                'session_id' => $sessionId,
                'service_code' => $serviceCode,
                'phone_number' => $phoneNumber,
                'service_request_id' => $serviceRequest->id,
                'language' => $textArray[0],
                'text_array' => $textArray,
            ])
        ]);
    }

    //TODO: REFACTOR!
    private function saveGuestMetaData(
        $sessionId,
        $serviceCode,
        $phoneNumber,
        $textArray
    ): MetaData {
        return MetaData::create([
            'extra' => json_encode([
                'session_id' => $sessionId,
                'service_code' => $serviceCode,
                'phone_number' => $phoneNumber,
                'language' => $textArray[0],
                'text_array' => $textArray,
            ])
        ]);
    }


    private function saveOrUpdateSession(
        $sessionId,
        $serviceCode,
        $phoneNumber,
        $textArray
    ): ATSession {
        $session = ATSession::where('at_id', $sessionId)->first();
        if ($session) {
            return $session->update([
                'meta' => json_encode([
                    'session_id' => $sessionId,
                    'service_code' => $serviceCode,
                    'phone_number' => $phoneNumber,
                    'language' => $textArray[0],
                    'text_array' => $textArray,
                ])
            ]);
        }

        return ATSession::create([
            'at_id' => $sessionId,
            'meta' => json_encode([
                'session_id' => $sessionId,
                'service_code' => $serviceCode,
                'phone_number' => $phoneNumber,
                'language' => $textArray[0],
                'text_array' => $textArray,
            ])
        ]);
    }

    private function getLatestStats(): Stats
    {
        return Stats::all()->last();
    }
}
