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
            $response = "CON Karibu katika huduma za Kaunti ya Mombasa. Tuko hapa kukuhudumia. \n\n";
            $response .= "Wewe ni mkaazi wa Old Town?. \n\n";
            $response .= "1. Ndio \n";
            $response .= "2. La";
        } elseif ($text == "1") {
            $response = "CON Ni huduma gani unahitaji kutoka kwa Kaunti ya Mombasa?  \n";
            $response .= "1.Kupimwa Corona\n";
            $response .= "2.Kuripoti Mshukiwa wa Corona\n";
            $response .= "3. Usadizi Wa Matibabu\n";
            $response .= "4. Msaada Wa Chakula\n";
            $response .= "5. Uzoaji Wa Takataka\n";
            $response .= "6. Dharura Nyengine\n";
            $response .= "7. Hakuna";
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 1) {
            $response = $this->loopServiceQuestions($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 2) {
            $response = $this->loopServiceQuestions($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 3) {
            $response = $this->loopServiceQuestions($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 4) {
            $response = $this->loopServiceQuestions($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 5) {
            $response = $this->loopServiceQuestions($ussdStringArray, $steps);
        } elseif ($ussdStringArray[0] == 1 && $ussdStringArray[1] == 6) {
            $response = $this->loopServiceQuestions($ussdStringArray, $steps);
        } elseif ($text == "2") {
            //note that we are using the $phoneNumber variable we got form the HTTP POST data.
            $response = "CON Una maoni yoyote kuhusu ugawanyo wa chakula cha msaada kwa Kaunti ya Mombasa?\n";
            $response .= "1. Ndio\n";
            $response .= "2. La";
        } // Nothing to do
        elseif ($text == "2*2") {
            $response = "END Thank you for checking us out. Goodbye!";
        } else if ($text == "1*7") {
            $response = "END Thank you for checking out our hotline. Goodbye!";
        }

        return $response;
    }

    private function loopServiceQuestions($textArray, $stepsCount)
    {
        $response = '';

        if ($stepsCount == 2) {
            $response = "CON Tafadhali eleza ombi lako kwa undani zaidi.";
        }

        if ($stepsCount == 3) {
            $response = "CON Ni nambari ipi ya simu tunaweza kuwasiliana na wewe?";
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
            //persist the answers, end the process
            $servicesAnswersBag = [
                'details' => isset($textArray[2]) ? $textArray[2] : null,
                'contact_info' => isset($textArray[3]) ? $textArray[3] : null,
                'household_number' => isset($textArray[4]) ? $textArray[4] : null,
                'geo_location_id' => isset($textArray[5]) ? $textArray[5] : null,
                'type' => $textArray[1],
                'official' => isset($textArray[6]) ? $textArray[6] : null
            ];

            $response = "END Thank you for your request, a service agent will get back to you as soon as possible";
        }

        return $response;
    }
}
