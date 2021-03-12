<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit;

use Magento\Framework\Data\FormFactory;
use Magento\Backend\Block\Widget\Context;

class Form extends \Magento\Backend\Block\Widget\Form
{
    /** @var FormFactory */
    protected $formFactory;

    /** @var Context */
    protected $context;

    /** @param FormFactory   $formFactory
     * @param Context $context
     * @param array  $data  */
    public function __construct(FormFactory $formFactory,Context $context,array $data = [])
    {
        $this->formFactory = $formFactory;
        $this->context     = $context;

        parent::__construct($context, $data);
    }

    /** @return string */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', ['blog_id' => $this->getRequest()->getParam('blog_id')]);
    }
}
