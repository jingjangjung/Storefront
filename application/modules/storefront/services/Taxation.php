<?php

/**
 * Class Storefront_Service_Taxation
 *
 * service that handles tax calculation
 */
class Storefront_Service_Taxation
{
    const TAXRATE = 15;


    /**
     * adds tax to given amount
     *
     * @param $amount   initial amount
     * @return float
     */
    public function addTax($amount)
    {
        $tax = ($amount * self::TAXRATE) / 100;
        $amount = round($amount + $tax, 2);
        return $amount;
    }
}