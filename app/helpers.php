<?php

if (!function_exists('usd_money_format')) {
    /**
     * format number.
     *
     * @param  float  $number
     * @return string
     */
    function usd_money_format($number): string
    {
        try {
            $currency = config('app.currency');
            $formattedNumber = str_replace('.00', '', number_format($number, 2));
            return  "{$currency}{$formattedNumber}";
        } catch (\Throwable $th) {
            return "error";
        }
    }
}
