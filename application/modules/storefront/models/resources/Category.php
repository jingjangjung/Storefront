<?php

/**
 * Class Storefront_Resource_Category
 *
 * Resource class for database category table
 * uses the Tabledata Gateway pattern
 */
class Storefront_Resource_Category extends SF_Model_Resource_Db_Table_Abstract
{
    protected $_name = 'category';
    protected $_primary = 'categoryId';
    protected $_referenceMap = array(
        'SubCategory' => array(
            'columns' => 'parentId',
            'refTableClass' => 'Storefront_Resource_Category',
            'refColumns' => 'categoryId'
        )
    );
}