<?php

namespace Brituy\SimpleBlog\Model\Config\Source;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Option\ArrayInterface;
use Brituy\SimpleBlog\Model\CategoryFactory;

/** Class Categories
 * @package Brituy\Faqs\Model\Config\Source */
class Category implements ArrayInterface
{
    /** @var CategoryFactory */
    public $_categoryFactory;

    public function __construct(
        CategoryFactory $categoryFactory
    ) {
        $this->_categoryFactory = $categoryFactory;
    }

    /** @return array */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->getCategory() as $value => $category) {
            $options[] = [
                'value' => $value,
                'label' => $category->getCategory()
            ];
        }

        return $options;
    }

    /** @return AbstractCollection */
    public function getCategory()
    {
        return $this->_categoryFactory->create()->getCollection();
    }
}
