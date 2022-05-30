<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend("mask", function($attribute, $value, $parameters, $validator) {
            if (preg_match("/^[а-яА-Я\d]+$/u", $value) !== 1) {
                return false;
            }

            $cipher = request()->input($parameters[0]);

            $cipher_numbers = array_map(fn($cipher_row) => $cipher_row["number"], $cipher);

            // Checking for each character which is numeric that it's contain in cipher's numbers
            foreach (mb_str_split($value) as $char) {
                if (is_numeric($char)) {
                    if (!in_array($char, $cipher_numbers)) {
                        return false;
                    }
                }
            }

            return true;
        });

        Validator::extend("cipher", function($attribute, $value, $parameters, $validator) {
            if (!is_array($value)) {
                return false;
            }


            $used_numbers = [];
            $user_chars = [];
            foreach ($value as $number) {
                if (
                    !isset($number["number"]) 
                    || 
                    !is_numeric($number["number"]) 
                    ||
                    !($number["number"] >= 0 && $number["number"] <= 9)
                    || 
                    in_array($number["number"], $used_numbers)
                ) {
                    return false;
                }

                $used_numbers[] = $number["number"];

                if (!isset($number["chars"]) || !is_array($number["chars"])) {
                    return false;
                }

                $encoding = mb_internal_encoding();
                foreach ($number["chars"] as $char) {
                    if (
                        preg_match("/^[а-яА-Я]$/u", $char) !== 1
                        ||
                        in_array(mb_strtolower($char, $encoding), $user_chars)
                    ) {
                        return false;
                    }

                    $user_chars[] = mb_strtolower($char, $encoding);
                }
            }

            return true;
        });   
    }
}
