<?php
namespace Brituy\SimpleBlog\Controller\Index;

use Brituy\SimpleBlog\Model\Config;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /** @var PageFactory */
    protected $resultPageFactory;

    protected $config;

    /** Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Config $config
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->config = $config;
    }

    /** @return ResponseInterface|ResultInterface|Page */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
