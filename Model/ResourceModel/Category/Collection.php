<?php

namespace Brituy\SimpleBlog\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/** Class Collection
 * @package Mageplaza\Blog\Model\ResourceModel\Category */
class Collection extends AbstractCollection
{
    /** @inheritdoc */
    protected $_idFieldName = 'category_id';

    /** Construct */
    protected function _construct()
    {
        $this->_init('Brituy\SimpleBlog\Model\Category', 'Brituy\SimpleBlog\Model\ResourceModel\Category');
    }

    /** add if filter
     * @param $categoryIds
     * @return $this */
    public function addIdFilter($categoryIds)
    {
        $condition = '';

        if (is_array($categoryIds)) {
            if (!empty($categoryIds)) {
                $condition = ['in' => $categoryIds];
            }
        } elseif (is_numeric($categoryIds)) {
            $condition = $categoryIds;
        } elseif (is_string($categoryIds)) {
            $ids = explode(',', $categoryIds);
            if (empty($ids)) {
                $condition = $categoryIds;
            } else {
                $condition = ['in' => $ids];
            }
        }

        if ($condition) {
            $this->addFieldToFilter('category_id', $condition);
        }

        return $this;
    }
}
