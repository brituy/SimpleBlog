<?php

namespace Brituy\SimpleBlog\Model\Config\Source;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Option\ArrayInterface;
use Brituy\SimpleBlog\Model\AuthorsFactory;

/** Class Authors
 * @package Brituy\Faqs\Model\Config\Source */
class Authors implements ArrayInterface
{
    /** @var AuthorsFactory */
    public $_authorsFactory;

    public function __construct(
        AuthorsFactory $authorsFactory
    ) {
        $this->_authorsFactory = $authorsFactory;
    }

    /** @return array */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->getAuthors() as $value => $authors) {
            $options[] = [
                'value' => $value,
                'label' => $authors->getAuthor()
            ];
        }

        return $options;
    }

    /** @return AbstractCollection */
    public function getAuthors()
    {
        return $this->_authorsFactory->create()->getCollection();
    }
}
