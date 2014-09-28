<?php

/**
 * Class Storefront_Resource_Category_Item
 *
 * Resource class for database category table row
 * uses the Rowdata Gateway pattern
 */
class Storefront_Resource_Category_Item extends SF_Model_Resource_Db_Table_Row_Abstract
    implements Storefront_Resource_Category_Item_Interface
{
    public function getParentCategory()
    {
        // using the table relationship defined in category resources
        return $this->findParentRow('Storefront_Resource_Category', 'SubCategory');
    }
}