<?php

namespace Brituy\SimpleBlog\Model\ResourceModel\Authors;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/** Class Collection
  * @package Brituy\SimpleBlog\Model\ResourceModel\Authors */
class Collection extends AbstractCollection
{
    /** @inheritdoc */
    protected $_idFieldName = 'author_id';

    /** Construct */
    protected function _construct()
    {
        $this->_init('Brituy\SimpleBlog\Model\Authors', 'Brituy\SimpleBlog\Model\ResourceModel\Authors');
    }

    /** add if filter
     * @param $authorsIds
     * @return $this */
    public function addIdFilter($authorsIds)
    {
        $condition = '';

        if (is_array($authorsIds)) {
            if (!empty($authorsIds)) {
                $condition = ['in' => $authorsIds];
            }
        } elseif (is_numeric($authorsIds)) {
            $condition = $authorsIds;
        } elseif (is_string($authorsIds)) {
            $ids = explode(',', $authorsIds);
            if (empty($ids)) {
                $condition = $authorsIds;
            } else {
                $condition = ['in' => $ids];
            }
        }

        if ($condition) {
            $this->addFieldToFilter('author_id', $condition);
        }

        return $this;
    }
}
