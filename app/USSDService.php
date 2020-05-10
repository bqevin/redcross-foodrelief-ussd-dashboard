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
        $response = "";
        $servicesAnswersBag = [];
        $ussdStringArray = explode("*", $text);
        $isServiceRequestOption = $ussdStringArray[0] == 1 && $ussdStringArray[1] == 1;
        // Get ussd menu level number from the gateway
        $steps = count($ussdStringArray);
        if ($text == "") {
            $response = "CON Karibu katika huduma za Kaunti ya Mombasa. Tuko hapa kukuhudumia. \n\n";
            $response .= "Wewe ni mkaazi wa Old Town?. \n\n";
            $response .= "1. Ndio \n";
            $response .= "2. La";
        } else
            if ($text == "1") {
                $response = "CON Ni huduma gani unahitaji kutoka kwa Kaunti ya Mombasa?  \n";
                $response .= "1.Kupimwa Corona\n";
                $response .= "2.Kuripoti Mshukiwa wa Corona\n";
                $response .= "3. Usadizi Wa Matibabu\n";
                $response .= "4. Msaada Wa Chakula\n";
                $response .= "5. Uzoaji Wa Takataka\n";
                $response .= "6. Dharura Nyengine\n";
                $response .= "7. Hakuna";
            } else
                if (
                    $text == "1*1" ||
                    $text == "1*2" ||
                    $text == "1*3" ||
                    $text == "1*4" ||
                    $text == "1*5" ||
                    $text == "1*6"
                ) {
                    $response = "CON Tafadhali eleza ombi lako kwa undani zaidi.";
                    array_push($servicesAnswersBag, ['details' => $ussdStringArray[3]]);
                } else if ($isServiceRequestOption && $steps == 3) {
                    $response = "CON Ni nambari ipi ya simu tunaweza kuwasiliana na wewe?";
                    array_push($servicesAnswersBag, ['contact_info' => $ussdStringArray[4]]);
                } elseif ($isServiceRequestOption && $steps == 4) {
                    $response = "CON Katika nyumba yenu muko wangapi?";
                    array_push($servicesAnswersBag, ['household_number' => $ussdStringArray[5]]);
                } elseif ($isServiceRequestOption && $steps == 5) {
                    $response = "CON Tunaweza kuifikia vipi nyumba yako? Tafadhali tupe ramani, rangi ya mlango wako. Nambari ya chumba chako.";
//                    array_push($servicesAnswersBag, ['details' => $ussdStringArray[6]]);
                } elseif ($isServiceRequestOption && $steps == 6) {
                    $response = "CON Ni nani mzee wa nyumba kumi mtaani kwenu?";
                    array_push($servicesAnswersBag, ['official' => $ussdStringArray[7]]);
                } else
                    if ($text == "2") {
                        //note that we are using the $phoneNumber variable we got form the HTTP POST data.
                        $response = "CON Una maoni yoyote kuhusu ugawanyo wa chakula cha msaada kwa Kaunti ya Mombasa?\n";
                        $response .= "1. Ndio\n";
                        $response .= "2. La";
                    } // Nothing to do
                    else
                        if ($text == "2*2") {
                            $response = "END Thank you for checking us out. Goodbye!";
                        } else if ("1*7") {
                            $response = "END Thank you for checking out our hotline. Goodbye!";
                        }

        return $response;
    }
}
