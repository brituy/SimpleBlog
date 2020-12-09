<?php

namespace Brituy\SimpleBlog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Backend\Model\View\Result\ForwardFactory;

/** Class NewAction
  * @package Brituy\SimpleBlog\Controller\Adminhtml\Post */
class NewAction extends Action
{
    /** Redirect result factory
      * @var ForwardFactory */
    public $resultForwardFactory;

    /** constructor
      * @param ForwardFactory $resultForwardFactory
      * @param Context $context */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;

        parent::__construct($context);
    }

    /** forward to edit
      * @return Forward */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        $resultForward->forward('edit');

        return $resultForward;
    }
}
