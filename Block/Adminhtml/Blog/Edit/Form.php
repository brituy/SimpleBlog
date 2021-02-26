<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create([
            'data' => [
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            ]
        ]);
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
    
    /**protected $formFactory;
    protected $context;**/

    public function __construct(
        FormFactory $formFactory,
        Registry $registry,
        Context $context,
        array $data = []
    ) {
        //$this->formFactory = $formFactory;
        //$this->context     = $context;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /** @return string */
    /**public function getSaveUrl()
    {
        return $this->getUrl('save', ['blog_id' => $this->getRequest()->getParam('blog_id')]);
    }**/
}
