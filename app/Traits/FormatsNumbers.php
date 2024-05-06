<?php

namespace App\Traits;

trait FormatsNumbers
{
    public function numberFormatBangladeshi($number)
    {
        // Ensure the number is a string for manipulation
        $number = (string) $number;

        // Check if the number length is more than 3 to start processing
        if (strlen($number) > 3) {
            $lastThree = substr($number, -3);
            $rest = substr($number, 0, -3);

            // Insert commas every two digits for the rest
            $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);

            return $rest.','.$lastThree;
        }

        // If the number is 3 digits or less, no formatting needed
        return $number;
    }
}
