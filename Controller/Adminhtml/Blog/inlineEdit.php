<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Brituy\SimpleBlog\Model\BlogFactory;

class InlineEdit extends Action
{

    protected $jsonFactory;
    protected $_blogFactory;

    public function __construct(Context $context,JsonFactory $jsonFactory,BlogFactory $blogFactory)
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->_blogFactory = $blogFactory;
        
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
                foreach (array_keys($postItems) as $blogId)
                {
                    /** load your model to update the data */
                    $model = $this->_blogFactory->create()->load($blogId);
                    try
                    {
                        $model->setData(array_merge($model->getData(), $postItems[$blogId]));
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
