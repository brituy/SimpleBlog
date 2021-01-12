<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Brituy\SimpleBlog\Model\CategoriesFactory;

class InlineEdit extends Action
{

    protected $jsonFactory;
    protected $_categoriesFactory;

    public function __construct(Context $context,JsonFactory $jsonFactory,CategoriesFactory $categoriesFactory)
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->_categoriesFactory = $categoriesFactory;
        
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) 
        {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems))
            {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $categoryId)
                {
                    /** load your model to update the data */
                    $model = $this->_categoriesFactory->create()->load($categoryId);
                    try
                    {
                        $model->setData(array_merge($model->getData(), $postItems[$categoryId]));
                        $model->save();
                    } catch (\Exception $e) 
                      {
                        $messages[] = "[Error:]  {$e->getMessage()}";
                        $error = true;
                      }
                }
            }
        }

        return $resultJson->setData(['messages' => $messages,'error' => $error]);
    }
}
