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
        $ussdStringArray = explode("*", $text);
        $isServiceRequestOption =
            $text == "1*1" || $text == "1*2" ||
            $text == "1*3" || $text == "1*4" ||
            $text == "1*5" || $text == "1*6";


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
        } elseif ($isServiceRequestOption) {
            switch ($text) {
                case "1*1":
                    $response = $this->loopServiceQuestions($ussdStringArray, $steps, 1);
                    break;
                case "1*2":
                    $response = $this->loopServiceQuestions($ussdStringArray, $steps, 2);
                    break;
                case "1*3":
                    $response = $this->loopServiceQuestions($ussdStringArray, $steps, 3);
                    break;
                case "1*4":
                    $response = $this->loopServiceQuestions($ussdStringArray, $steps, 4);
                    break;
                case "1*5":
                    $response = $this->loopServiceQuestions($ussdStringArray, $steps, 5);
                    break;
                case "1*6":
                    $response = $this->loopServiceQuestions($ussdStringArray, $steps, 6);
                default:
            }
        } elseif ($text == "2") {
            //note that we are using the $phoneNumber variable we got form the HTTP POST data.
            $response = "CON Una maoni yoyote kuhusu ugawanyo wa chakula cha msaada kwa Kaunti ya Mombasa?\n";
            $response .= "1. Ndio\n";
            $response .= "2. La";
        } // Nothing to do
        elseif ($text == "2*2") {
            $response = "END Thank you for checking us out. Goodbye!";
        } else if ("1*7") {
            $response = "END Thank you for checking out our hotline. Goodbye!";
        }

        return $response;
    }

    private function loopServiceQuestions($textArray, $stepsCount, int $optionNumber)
    {

        $response = '';
        $servicesAnswersBag = [];
        $isCorrectLevel = $textArray[0] == 1 && $textArray[1] == $optionNumber;
        $response = "CON Tafadhali eleza ombi lako kwa undani zaidi.";

        if ($isCorrectLevel && $stepsCount == 3) {
//            array_push($servicesAnswersBag, ['details' => $textArray[3]]);
            $response = "CON Ni nambari ipi ya simu tunaweza kuwasiliana na wewe?";
        } elseif ($isCorrectLevel && $stepsCount == 4) {
//            array_push($servicesAnswersBag, ['contact_info' => $textArray[4]]);
            $response = "CON Katika nyumba yenu muko wangapi?";
        } elseif ($isCorrectLevel && $stepsCount == 5) {
//            array_push($servicesAnswersBag, ['household_number' => $textArray[5]]);
            $response = "CON Tunaweza kuifikia vipi nyumba yako? Tafadhali tupe ramani, rangi ya mlango wako. Nambari ya chumba chako.";
        } elseif ($isCorrectLevel && $stepsCount == 6) {
//            array_push($servicesAnswersBag, ['details' => $textArray[6]]);
            $response = "CON Ni nani mzee wa nyumba kumi mtaani kwenu?";
//            array_push($servicesAnswersBag, ['official' => $textArray[7]]);
        }

        return $response;
    }
}
