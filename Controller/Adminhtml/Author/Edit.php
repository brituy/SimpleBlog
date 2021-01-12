<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Author;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Edit extends \Magento\Backend\App\Action
{
    private $coreRegistry;

    public $resultPageFactory;

    protected $resultForwardFactory;
    protected $_authorsFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Brituy\SimpleBlog\Model\AuthorsFactory $authorsFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->_authorsFactory = $authorsFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $authorid = (int) $this->getRequest()->getParam('author_id');
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($authorid) {
            $authorData = $this->_authorsFactory->create()->load($authorid);

            if (!$authorData->getId()) {
                $this->messageManager->addError(__('Author no longer exist.'));
                $this->_redirect('*/*/*');
                return;
            }
        }else{ $authorData = $this->_authorsFactory->create(); }

        $this->coreRegistry->register('simpleblog_author', $authorData);
        $resultPageFactory = $this->resultPageFactory->create();
        $resultPageFactory->getConfig()->getTitle()->prepend(
            $authorData->getId()
                ? __('Edit Author [%1]', $authorData->getId())
                : __('Create New Author')
        );
        return $resultPageFactory;
    }
}
