<?php

// any Zend_Db_table component uses ZendLoader::loadClass() to load dependent classes
// and this method does not trigger the autoloader, meaning it's necessary to include
// any class that this current class depends on

if(!class_exists('Storefront_Resource_ProductImage'))
{
    require_once dirname(__FILE__) . '/ProductImage.php';
}

if(!class_exists('Storefront_Resource_Product_Item'))
{
    require_once dirname(__FILE__) . '/Product/Item.php';
}


/**
 * Class Storefront_Resource_Product
 *
 * Resource class for database product table
 * uses the Tabledata Gateway pattern
 */
class Storefront_Resource_Product extends SF_Model_Resource_Db_Table_Abstract
    implements Storefront_Resource_Product_Interface
{
    protected $_name = 'product';
    protected $_primary = 'productId';
    protected $_rowClass = 'Storefront_Resource_Product_Item';


    /*
     * Interface implementation
     */

    /**
     * fetches a product based on id
     *
     * @param $id       product ID
     * @return Zend_Db_Table_Row_Abstract
     */
    public function getProductById($id)
    {
        // it's equivalent to ->select->where('productId = ?', $id);
        return $this->find($id)->current();
    }


    /**
     * fetches a product based on identity string
     *
     * @param $ident    identity string
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getProductByIdent($ident)
    {
        // alternative syntax:
        //  $select = $this->select()
        //      ->where('ident = ?',  $ident);
        //  return $this->fetchRow($select);

        return $this->fetchRow($this->select()->where('ident = ?', $ident));
    }



    /**
     * gets a listing of products based on category
     *
     * (main method used in product listings)
     *
     * @param $categoryId       category ID (can be more than one)
     * @param null $paged       current page (null, no pagination; not null contains the current page)
     * @param null $order       order clause
     * @return Zend_Db_Table_Rowset_Abstract|Zend_Paginator
     */
    public function getProductByCategory($categoryId, $paged = null, $order = null)
    {
        // creating the select statement
        // using the IN clause is suitable as $categoryId is an array of categories
        $select = $this->select()
            ->from('product')
            ->where('categoryId IN (?)', $categoryId);

        // ordering according to order clause
        // (e.g., array('name ASC', 'price DESC')
        if(is_array($order) === true)
        {
            $select->order($order);
        }

        // paginating the result
        if($paged !== null)
        {
            // adapter to configure the paginator instance
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

            // select statement that calculates the total amount of rows returned by the main statement
            $count = clone $select;
            // reseting the cloned statement
            $count->reset(Zend_Db_Select::COLUMNS);
            $count->reset(Zend_Db_Select::FROM);
            // creating the count expression with Zend_Db_Expr
            $count->from('product',
                new Zend_Db_Expr('COUNT(*) as `zend_paginator_row_count`'));

            // setting the count statement in the adapter
            $adapter->setRowCount($count);

            // creating the zend paginator instance using the adapter
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(5)
                ->setCurrentPageNumber((int) $paged);

            return $paginator;
        }

        return $this->fetchAll($select);
    }



    public function saveProduct($info)
    {

    }
}