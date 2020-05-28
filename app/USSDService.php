<?php

namespace App;

class USSDService
{
    public function processText(
        $sessionId,
        $serviceCode,
        $phoneNumber,
        $text
    ) {
        $response = '';
        $ussdStringArray = explode("*", $text);

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
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 2) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 3) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 4) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 5) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 6) {
            $response = $this->loopServiceQuestionsEnglish($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 1) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 2) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 3) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 4) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 5) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 1 && $ussdStringArray[2] == 6) {
            $response = $this->loopServiceQuestionsSwahili($ussdStringArray, $steps);
        } // General Feedback/Complains questions Starts here
        elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 2 && $ussdStringArray[2] == 1) {
            $response = $this->loopFeedbackQuestionsEnglish($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 2 && $ussdStringArray[1] == 2 && $ussdStringArray[2] == 1) {
            $response = $this->loopFeedbackQuestionsSwahili($ussdStringArray, $steps);
        } elseif ($text == "1*2*2") {
            $response = "END Thank you for checking us out. Goodbye!";
        } elseif ($text == "2*2*2") {
            $response = "END Ahsante. Kwaheri!";
        } else if ($text == "1*1*7") {
            $response = "END Thank you for checking out our hotline. Goodbye!";
        } else if ($text == "2*1*7") {
            $response = "END Ahsante kwa kufika kwa huduma zetu za hotline. Kwaheri!";
        }

        return $response;
    }

    private function loopServiceQuestionsSwahili($textArray, $stepsCount)
    {
        $response = '';

        if ($stepsCount == 2) {
            $response = "CON Tafadhali eleza ombi lako kwa undani zaidi.";
        }

        if ($stepsCount == 3) {
            $response = "CON Tupe nambari ya simu tunaweza kuwasiliana na wewe hapa";
        }

        if ($stepsCount == 4) {
            $response = "CON Katika nyumba yenu muko wangapi?";
        }

        if ($stepsCount == 5) {
            $response = "CON Tunaweza kuifikia vipi nyumba yako? Tafadhali tupe ramani, rangi ya mlango wako. Nambari ya chumba chako.";
        }

        if ($stepsCount == 6) {
            $response = "CON Ni nani mzee wa nyumba kumi mtaani kwenu?";
        }

        // end of questions
        if ($stepsCount > 6) {
            $this->saveServiceRequest($textArray, $this->saveGeoLocationServiceRequest($textArray));
            $response = "END Ahsante kwa ombi yako, muhudumu wetu ataishughulikia kwa upesi iwezekwanavyo";
        }

        return $response;
    }

    private function loopServiceQuestionsEnglish($textArray, $stepsCount)
    {
        $response = '';

        if ($stepsCount == 2) {
            $response = "CON Please tell us about your request in details";
        }

        if ($stepsCount == 3) {
            $response = "CON Please write here phone number we can use to contact you";
        }

        if ($stepsCount == 4) {
            $response = "CON How many are you in your household?";
        }

        if ($stepsCount == 5) {
            $response = "CON How can we access your residence? Please share exact details including door number, color if there is one.";
        }

        if ($stepsCount == 6) {
            $response = "CON Who is your village elder?";
        }

        // end of questions
        if ($stepsCount > 6) {
            $this->saveServiceRequest($textArray, $this->saveGeoLocationServiceRequest($textArray));
            $response = "END Thank you for your request, a service agent will get back to you as soon as possible";
        }

        return $response;
    }

    private function loopFeedbackQuestionsSwahili($textArray, $stepsCount)
    {
        $response = '';

        if ($stepsCount == 2) {
            $response = "CON Maoni, lawama au pendekezo lako ni yepi?";
        }

        if ($stepsCount == 3) {
            $response = "CON Kisa kimetokea lini?";
        }

        if ($stepsCount == 4) {
            $response = "CON Mzee wa mtaa wako ni nani?";
        }

        if ($stepsCount == 5) {
            $response = "CON Elezea jinsi tutafika kwako. Tupe mwelekezo wa ramani, rangi ya nyumba na namba ya chumba kama kunayo";
        }

        if ($stepsCount == 6) {
            $response = "CON Jina la kata yako?";
        }
        if ($stepsCount == 7) {
            $response = "CON Unatoka eneo bunge gani?";
        }


        // end of questions
        if ($stepsCount > 7) {
            $this->saveFeedback($textArray, $this->saveGeoLocationFeedback($textArray));

            $response = "END Ahsante kwa kuripoti hilo tukio. Itashughulikwa kwa haraka iwezekenavyo!";
        }

        return $response;
    }

    private function loopFeedbackQuestionsEnglish($textArray, $stepsCount)
    {
        $response = '';

        if ($stepsCount == 2) {
            $response = "CON What is your suggestions, complain or report?";
        }

        if ($stepsCount == 3) {
            $response = "CON When did this happen?";
        }

        if ($stepsCount == 4) {
            $response = "CON What is the name of your village elder?";
        }

        if ($stepsCount == 5) {
            $response = "CON Where do you stay? Please be detailed as possible";
        }

        if ($stepsCount == 6) {
            $response = "CON What is the name of your ward?";
        }
        if ($stepsCount == 7) {
            $response = "CON What is the name of your constituency?";
        }


        // end of questions
        if ($stepsCount > 7) {
            $this->saveFeedback($textArray, $this->saveGeoLocationFeedback($textArray));
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
        $response = "CON Are you Old Town resident?. \n\n";
        $response .= "1. Yes \n";
        $response .= "2. No";

        return $response;
    }

    private function launchText()
    {
        $response = "CON Welcome to Mombasa County Services. We are here to Serve you.\n\n Pick a language (Chagua lugha) \n\n";
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
        $response = "CON What service do you require from Mombasa County?  \n";
        $response .= "1. Get tested for COVID-19\n";
        $response .= "2. Report a suspected COVID-19 case\n";
        $response .= "3. Healthcare assistance\n";
        $response .= "4. Relief food assistance\n";
        $response .= "5. Garbage collection\n";
        $response .= "6. Other emergency\n";
        $response .= "7. Nothing";

        return $response;
    }

    private function saveGeoLocationFeedback(array $textArray): GeoLocation
    {
        return GeoLocation::create([
            'location_description' => isset($textArray[5]) ? $textArray[5] : null,
            'ward' => isset($textArray[6]) ? $textArray[6] : null,
            'constituency' => isset($textArray[7]) ? $textArray[7] : null,
            'lat' => null,
            'lng' => null
        ]);
    }

    private function saveFeedback($textArray, GeoLocation $geo = null): Feedback
    {
        return Feedback::create([
            'description' => isset($textArray[2]) ? $textArray[2] : null,
            'official' => isset($textArray[4]) ? $textArray[4] : null,
            'occurrence_date' => isset($textArray[3]) ? $textArray[3] : null,
            'geo_location_id' => $geo ? $geo->id : null
        ]);
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
        return GeoLocation::create([
            'location_description' => isset($textArray[5]) ? $textArray[5] : null,
            'ward' => "Old Town",
            'constituency' => "Mvita Constituency",
            'lat' => null,
            'lng' => null
        ]);
    }

    private function saveServiceRequest($textArray, GeoLocation $geo): ServiceRequest
    {
        return ServiceRequest::create([
            'details' => isset($textArray[2]) ? $textArray[2] : null,
            'contact_info' => isset($textArray[3]) ? $textArray[3] : null,
            'official' => isset($textArray[6]) ? $textArray[6] : null,
            'geo_location_id' => $geo ? $geo->id : null,
            'type' => $textArray[1],
            'household_number' => isset($textArray[4]) ? $textArray[4] : null

        ]);
    }
}
