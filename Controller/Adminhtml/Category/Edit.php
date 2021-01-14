<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Category;

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
    protected $_categoriesFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Brituy\SimpleBlog\Model\CategoriesFactory $categoriesFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->_categoriesFactory = $categoriesFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $categoryid = (int) $this->getRequest()->getParam('category_id');
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($categoryid) {
            $categoryData = $this->_categoriesFactory->create()->load($categoryid);

            if (!$categoryData->getId()) {
                $this->messageManager->addError(__('Category no longer exist.'));
                $this->_redirect('*/*/*');
                return;
            }
        }else{ $categoryData = $this->_categoriesFactory->create(); }

        $this->coreRegistry->register('simpleblog_category', $categoryData);
        $resultPageFactory = $this->resultPageFactory->create();
        $resultPageFactory->getConfig()->getTitle()->prepend(
            $categoryData->getId()
                ? __('Edit Category [%1]', $categoryData->getId())
                : __('Create New Category')
        );
        return $resultPageFactory;
    }
}
