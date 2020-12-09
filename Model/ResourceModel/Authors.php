<?php

namespace Brituy\SimpleBlog\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Brituy\SimpleBlog\Helper\Data;

/** Class Author
  * @package Brituy\SimpleBlog\Model\ResourceModel */
class Authors extends AbstractDb
{
    /** @var Data */
    public $helperData;

    /** @var DateTime */
    public $dateTime;

    /** @var string */
    public $postTable;

    /** Author constructor.
      * @param Context $context
      * @param Data $helperData
      * @param DateTime $dateTime */
    public function __construct(
        Context $context,
        Data $helperData,
        DateTime $dateTime
    ) {
        $this->helperData = $helperData;
        $this->dateTime = $dateTime;

        parent::__construct($context);
        $this->postTable = $this->getTable('brituy_blog_main');
    }

    /** @inheritdoc */
    protected function _construct()
    {
        $this->_init('brituy_blog_authors', 'author_id');
    }

    /** @inheritdoc
      * @throws LocalizedException */
    protected function _beforeSave(AbstractModel $object)
    {
        $object->setUrlKey(
            $this->helperData->generateUrlKey($this, $object, $object->getUrlKey() ?: $object->getName())
        );

        if (!$object->isObjectNew()) {
            $timeStamp = $this->dateTime->gmtDate();
            $object->setUpdatedAt($timeStamp);
        }

        return $this;
    }
}
