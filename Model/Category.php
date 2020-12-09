<?php

namespace Brituy\SimpleBlog\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Brituy\SimpleBlog\Helper\Data;

/** Class Category
 * @package Brituy\SimpleBlog\Model */
class Category extends AbstractModel
{
    /** @inheritdoc */
    const CACHE_TAG = 'brituy_blog_categories';

    /** @var Data */
    protected $helperData;

    /** Author constructor.
     * @param Context $context
     * @param Registry $registry
     * @param Data $helperData
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data */
    public function __construct(
        Context $context,
        Registry $registry,
        Data $helperData,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->helperData = $helperData;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /** Constructor */
    protected function _construct()
    {
        $this->_init(ResourceModel\Category::class);
    }

    /** @param $name
     * @return DataObject */
    public function getCategoryByName($name)
    {
        return $this->getCollection()->addFieldToFilter('category', $name)->getFirstItem();
    }

    /** @return array */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /** @return string */
    public function getUrl()
    {
        return $this->helperData->getBlogUrl($this, Data::TYPE_CATEGORY);
    }

    /** @return bool */
    public function hasPost()
    {
        try {
            return (bool)count($this->_getResource()->getPostIds($this));
        } catch (LocalizedException $exception) {
            return false;
        }
    }
}