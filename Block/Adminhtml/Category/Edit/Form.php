<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Category\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;

class Form extends Generic
{
    /** @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /** Prepare form fields
     * @return \Magento\Backend\Block\Widget\Form */
    protected function _prepareForm()
    {
        /** @var $model \Brituy\SimpleBlog\Model\BlogFactory */
        $model = $this->_coreRegistry->registry('simpleblog_category');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            		['data'=>['id' => 'edit_form',
                            	   'enctype' => 'multipart/form-data',
                            	   'action' => $this->getData('action'),
                            	   'method' => 'post']
            		]);
        $form->setHtmlIdPrefix('category_');
        
        // new filed
        if ($model->getId())
        {
            $fieldset = $form->addFieldset('base_fieldset',['legend'=>__('Edit Category Data'),'class'=>'fieldset-wide']);
            $fieldset->addField('category_id', 'hidden', ['name' => 'category_id']);
        } else {
            $fieldset = $form->addFieldset('base_fieldset',['legend'=>__('Add Category Data'),'class'=>'fieldset-wide']);
        }

        $fieldset->addField('category','text',
        	['name'=>'category','label'=>__('Category'),'title'=>__('Category'),'required'=>true]);

        $data = $model->getData();
        $form->setValues($data);
        $form->setUseContainer(true); //!!! no Save action works without this
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

