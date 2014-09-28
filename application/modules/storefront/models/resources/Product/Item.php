<?php

/**
 * Class Storefront_Resource_Product_Item
 *
 * Resource class for database product table row
 * uses the Rowdata Gateway pattern
 */
class Storefront_Resource_Product_Item extends SF_Model_Resource_Db_Table_Row_Abstract
    implements Storefront_Resource_Product_Item_Interface
{

    /*
     * Interface implementation
     */

    /**
     * gets the current item's related images
     *
     * @param bool $includeDefault
     * @return mixed
     */
    public function getImages($includeDefault = false)
    {
        return $this->findDependentRowset('Storefront_Resource_ProductImage', 'Image');
    }


    /**
     * gets the default image for the current item
     *
     * @return mixed
     */
    public function getDefaultImage()
    {
        $row = $this->findDependentRowset(
            'Storefront_Resource_ProductImage',
            'Image',
            // restricting findDependRowset by passing a Zend_Db_Select instance
            $this->select()
                ->where('isDefault = ?', 'Yes')
                ->limit(1))
            ->current();

        return $row;
    }


    /**
     * gets the item's price, which can have a discount and be taxable
     *
     * @param bool $withDiscount    discount value
     * @param bool $withTax         tax value
     * @return float
     */
    public function getPrice($withDiscount = true, $withTax = true)
    {
        $price = $this->getRow()->price;

        if($this->isDiscounted() === true && $withDiscount === true)
        {
            $discount = $this->getRow()->discountPercent;
            $discounted = ($price * $discount) / 100;
            $price = round($price - $discounted, 2);
        }

        if($this->isTaxable() === true && $withTax === true)
        {
            $taxService = new Storefront_Service_Taxation();
            $price = $taxService->addTax($price);
        }

        return $price;
    }


    /**
     * checks is a product item has a discount
     *
     * @return bool
     */
    public function isDiscounted()
    {
        return $this->getRow()->discountPercent == 0 ? false : true;
    }


    /**
     * checks if a product item is taxable
     *
     * @return bool
     */
    public function isTaxable()
    {
        return $this->getRow()->taxable == 'Yes' ? true : false;
    }
}