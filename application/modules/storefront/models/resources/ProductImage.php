<?php

// any Zend_Db_table component uses ZendLoader::loadClass() to load dependent classes
// and this method does not trigger the autoloader, meaning it's necessary to include
// any class that this current class depends on

if(!class_exists('Storefront_Resource_Product'))
{
    require_once dirname(__FILE__) . '/Product.php';
}

if(!class_exists('Storefront_Resource_ProductImage_Item'))
{
    require_once dirname(__FILE__) . '/ProductImage/Item.php';
}

/**
 * Class Storefront_Resource_ProductImage
 *
 * Resource class for database productImage table
 * uses the Tabledata Gateway pattern
 */
class Storefront_Resource_ProductImage extends SF_Model_Resource_Db_Table_Abstract
    implements Storefront_Resource_ProductImage_Interface
{
    protected $_name = 'productImage';
    protected $_primary = 'imageId';
    protected $_rowClass = 'Storefront_Resource_ProductImage_Item';
    protected $_referenceMap = array(
        'Image' => array(
            'columns' => 'productId',
            'refTableClass' => 'Storefront_Resource_Product',
            'refColumns' => 'productId'
        )
    );
}