<?php

/**
 * Class Storefront_Resource_Product
 *
 * Resource class for database product table
 * uses the Tabledata Gateway pattern
 */
class Storefront_Resource_Product extends SF_Model_Resource_Db_Table_Abstract
{
    protected $_name = 'product';
    protected $_primary = 'productId';
    protected $_rowClass = 'Storefront_Resource_Product_Item';
}