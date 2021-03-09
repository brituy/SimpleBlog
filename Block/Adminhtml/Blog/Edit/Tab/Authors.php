<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Tab;

use Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
//use Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Renderer\Category;
//use Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Renderer\Author;

class Authors extends Generic implements TabInterface
{
    /** @var Registry */
    //protected $registry;

    /** @var FormFactory */
    //protected $formFactory;

    /** @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Status $status
     * CategoriesOpt $categoriesOptSource,
     * AuthorsOpt $authorsOptSource,
     * @param array $data */
    public function __construct(Context $context,Registry $registry,FormFactory $formFactory,array $data = [])
    {
        $this->formFactory   = $formFactory;
        $this->registry      = $registry;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /** Prepare form fields
     * @return \Magento\Backend\Block\Widget\Form */
    protected function _prepareForm()
    {
        /** @var $blog \Brituy\SimpleBlog\Model\BlogFactory */
        $author = $this->_coreRegistry->registry('simpleblog_article');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->formFactory->create();
        $form->setHtmlIdPrefix('author_');

        $afieldset = $form->addFieldset('base_fieldset',['legend'=>__('Add Author Data'),'class'=>'fieldset-wide']);

        $afieldset->addField('author','text',
        	['name'=>'author_name','label'=>__('Name'),'title'=>__('Name'),'required'=>true]);

        $afieldset->addField('author_mail','text',
        	['name'=>'author_mail','label'=>__('E-Mail'),'title'=>__('E-Mail'),'required'=>true]);

        $form->addValues($author->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /** Prepare label for tab
     ** @return string */
    public function getTabLabel()
    {
        return __('Author');
    }

    /** Prepare title for tab
     ** @return string */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /** Can show tab in tabs
     ** @return boolean */
    public function canShowTab()
    {
        return true;
    }

    /** Tab is hidden
     ** @return boolean */
    public function isHidden()
    {
        return false;
    }
}

