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
        $ussdStringArray = explode("*", $text);
        // Get ussd menu level number from the gateway
        $steps = count($ussdStringArray);
        if ($text == "") {
            $response = "CON Karibu katika huduma za Kaunti ya Mombasa. Tuko hapa kukuhudumia. \n\n";
            $response .= "Wewe ni mkaazi wa Old Town?. \n\n";
            $response .= "1. Ndio \n";
            $response .= "2. La";
        } else if ($text == "1") {
            $response = "CON Ni huduma gani unahitaji kutoka kwa Kaunti ya Mombasa?  \n";
            $response .= "1.Kupimwa Corona\n";
            $response .= "2.Kuripoti Mshukiwa wa Corona\n";
            $response .= "3. Usadizi Wa Matibabu\n";
            $response .= "4. Msaada Wa Chakula\n";
            $response .= "5. Uzoaji Wa Takataka\n";
            $response .= "6. Dharura Nyengine\n";
            $response .= "7. Hakuna";
        } else if ($text == "2") {
            //note that we are using the $phoneNumber variable we got form the HTTP POST data.
            $response = "CON Una maoni yoyote kuhusu ugawanyo wa chakula cha msaada kwa Kaunti ya Mombasa?\n";
            $response .= "1. Ndio\n";
            $response .= "2. La";
        }
        // Nothing to do
        else if ($text == "2*2") {
            $response = "END Thank you for checking us out. Goodbye!";
        } else if ("1*7") {
            $response = "END Thank you for checking out our hotline. Goodbye!";
        }
    }
}
