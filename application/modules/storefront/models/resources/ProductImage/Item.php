<?php

/**
 * Class Storefront_Resource_ProductImage_Item
 *
 * Resource class for database productImage table row
 * uses the Rowdata Gateway pattern
 */
class Storefront_Resource_ProductImage_Item extends SF_Model_Resource_Db_Table_Row_Abstract
    implements Storefront_Resource_ProductImage_Item_Interface
{

    /*
     * Interface implementation
     */

    /**
     * gets the filename of product image thumbnail
     *
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->getRow()->full;
    }


    /**
     * gets the filename of the product full image
     *
     * @return mixed
     */
    public function getFull()
    {
        return $this->getRow()->full;
    }


    /**
     * checks if the current image item is the product's default image or not
     *
     * @return bool
     */
    public function isDefault()
    {
        return $this->getRow()->isDefault === 'Yes' ? true : false;
    }
}