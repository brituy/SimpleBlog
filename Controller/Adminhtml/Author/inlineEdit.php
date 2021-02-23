<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Author;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Brituy\SimpleBlog\Model\AuthorsFactory;

class InlineEdit extends Action
{
    /** Authorization level of a basic admin session
     ** @see _isAllowed() */
    const ADMIN_RESOURCE = 'Brituy_SimpleBlog::author_save';
    
    protected $jsonFactory;
    protected $_authorsFactory;

    public function __construct(Context $context,JsonFactory $jsonFactory,AuthorsFactory $authorsFactory)
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->_authorsFactory = $authorsFactory;
        
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
                foreach (array_keys($postItems) as $authorId)
                {
                    /** load your model to update the data */
                    $model = $this->_authorsFactory->create()->load($authorId);
                    try
                    {
                        $model->setData(array_merge($model->getData(), $postItems[$authorId]));
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
