<?php

class Storefront_Model_Catalog extends SF_Model_Abstract
{
    /**
     * gets a list of categories based on parent ID
     *
     * @param $parentId     parent ID
     */
    public function getCategoriesByParentId($parentId)
    {

    }


    /**
     * gets a single category based on its identity string
     *
     * @param $ident    identity string
     */
    public function getCategoryByIdent($ident)
    {

    }


    /**
     * gets a single product based on its ID
     *
     * @param $id   product ID
     */
    public function getProductById($id)
    {

    }


    /**
     * gets a single product based on its identity string
     *
     * @param $ident    identity string
     */
    public function getProductByIdent($ident)
    {

    }


    /**
     * gets a list of products that are contained within a given category
     *
     * @param $category         product's category
     * @param bool $paged
     * @param null $order
     * @param bool $deep
     */
    public function getProductByCategory($category, $paged = false, $order = null, $deep = true)
    {

    }


    /**
     * gets a list of children category IDs of a given category
     *
     * @param $categoryId       category ID
     * @param bool $recursive
     */
    public function getCategoryChildrenIds($categoryId, $recursive = false)
    {

    }


    /**
     * gets a list of parent categories for a given category
     *
     * @param $category     category
     */
    public function getParentCategories($category)
    {

    }
}