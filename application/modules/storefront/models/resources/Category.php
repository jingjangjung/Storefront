<?php

// any Zend_Db_table component uses ZendLoader::loadClass() to load dependent classes
// and this method does not trigger the autoloader, meaning it's necessary to include
// any class that this current class depends on

if(!class_exists('Storefront_Resource_Category_Item'))
{
    require_once dirname(__FILE__) . '/Category/Item.php';
}

/**
 * Class Storefront_Resource_Category
 *
 * Resource class for database category table
 * uses the Tabledata Gateway pattern
 */
class Storefront_Resource_Category extends SF_Model_Resource_Db_Table_Abstract
    implements Storefront_Resource_Category_Interface
{
    protected $_name = 'category';
    protected $_primary = 'categoryId';
    protected $_rowClass = 'Storefront_Resource_Category_Item';
    protected $_referenceMap = array(
        'SubCategory' => array(
            'columns' => 'parentId',
            'refTableClass' => 'Storefront_Resource_Category',
            'refColumns' => 'categoryId'
        )
    );


    /*
     * Interface implementation
     */

    /**
     * fetches all categories within a category that match $parentId
     *
     * @param $parentId     parent category ID
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getCategoriesByParentId($parentId)
    {
        // $select is a Zend_Db_Table_Select instance
        $select = $this->select()
            ->where('parentID = ?', $parentId)
            ->order('name');

        // running and returning the SQL statement to fetch all rows that match
        return $this->fetchAll($select);
    }


    /**
     * fetches a category that matches the identity string
     *
     * (each category has an unique identity string that will be used
     * to create user-friendly URLs such as /catalog/hats)
     *
     * @param $ident    identity string
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getCategoryByIdent($ident)
    {
        $select = $this->select()
            ->where('ident = ?', $ident);

        return $this->fetchRow($select);
    }


    /**
     * fetches a category by category Id
     *
     * @param $id       category ID
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getCategoryById($id)
    {
        $select = $this->select()
            ->where('categoryId = ?', $id);

        return $this->fetchRow($select);
    }
}