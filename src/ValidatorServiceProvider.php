<?php

namespace ThemisMin\LaravelLuhuValidator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
        Validator::extend('luhn', function ($attribute, $value, $parameters, $validator) {
            // Add a custom message. Doing it this way instead of doing
            // Validator::extend('luhn', 'Class@method') mean we're not
            // taking up the custom resolver spot.

            /** @var \Illuminate\Validation\Validator $validator */
            $validator->setCustomMessages(['luhn' => 'Card number is invalid.']);
            // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
            $value = preg_replace('/\D/', '', $value);
            // Set the string length and parity
            $number_length = strlen($value);
            $parity = $number_length % 2;
            // Loop through each digit and do the maths
            $total = 0;
            for ($i = 0; $i < $number_length; $i++) {
                $digit = $value[$i];
                // Multiply alternate digits by two
                if ($i % 2 == $parity) {
                    $digit *= 2;
                    // If the sum is two digits, add them together (in effect)
                    if ($digit > 9) {
                        $digit -= 9;
                    }
                }
                // Total up the digits
                $total += $digit;
            }
            // If the total mod 10 equals 0, the number is valid
            return ($total % 10 === 0);
        });
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        //
    }

}
