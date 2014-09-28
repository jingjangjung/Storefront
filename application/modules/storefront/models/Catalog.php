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
        $parentID = (int) $parentId;

        return $this->getResource('Category')
            ->getCategoriesByParentId($parentID);
    }


    /**
     * gets a single category based on its identity string
     *
     * @param $ident    identity string
     */
    public function getCategoryByIdent($ident)
    {
        return $this->getResource('Category')
            ->getCategoryByIdent($ident);
    }


    /**
     * gets a single product based on its ID
     *
     * @param $id   product ID
     */
    public function getProductById($id)
    {
        $id = (int) $id;
        return $this->getResource('Product')
            ->getProductById($id);
    }


    /**
     * gets a single product based on its identity string
     *
     * @param $ident    identity string
     */
    public function getProductByIdent($ident)
    {
        return $this->getResource('Product')
            ->getProductByIdent($ident);
    }


    /**
     * gets a list of products that are contained within a given category
     *
     * @param $category         product's category, can be int ($categoryId) or string($ident)
     * @param bool $paged       getting the result paginated or not
     * @param null $order       array containing the SQL order clause
     * @param bool $deep        gets all products from a category branch or from a single category only
     */
    public function getProductByCategory($category, $paged = false, $order = null, $deep = true)
    {
        // getting the category id
        // if category is a string we query based on ident
        if(is_string($category))
        {
            $cat = $this->getResource('Category')
                ->getCategoryByIdent($category);

            $categoryId = null === $cat ? 0 : $cat->categoryId;
        }
        // if category is a integer then is will be queried by id
        else
        {
            $categoryId = (int) $category;
        }

        // getting the category children
        if($deep === true)
        {
            $ids = $this->getCategoryChildrenIds(
                $categoryId, true
            );
            $ids[] = $categoryId;
            $categoryId = null === $ids ? $categoryId : $ids;
        }

        // returning the result
        return $this->getResource('Product')
            ->getProductsByCategory(
                $categoryId,
                $paged,
                $order
            );
    }


    /**
     * gets a list of children category IDs of a given category
     *
     * @param $categoryId       category ID of the category that we want the child category IDs from
     * @param bool $recursive   whether we want to recursively get the category's IDs or not
     */
    public function getCategoryChildrenIds($categoryId, $recursive = false)
    {
        $categories = $this->getCategoriesByParentId($categoryId);
        $cats = array();

        foreach($categories as $category)
        {
            $cats = $category->categoryId;
            if($recursive === true)
            {
                $cats = array_merge(
                    $cats,
                    $this->getCategoryChildrenIds($category->categoryId, true)
                );
            }
        }

        return false;
    }


    /**
     * gets a list of parent categories for a given category
     *
     * @param $category     category
     */
    public function getParentCategories($category)
    {
        $cats = array($category);

        if($category->parentId == 0)
        {
            return $cats;
        }

        $parent = $category->getParentCategory();
        $cats[] = $parent;

        if($parent->parentId != 0)
        {
            $cats = array_merge(
                $cats,
                $this->getParentCategories($parent)
            );
        }

        return $cats;
    }
}