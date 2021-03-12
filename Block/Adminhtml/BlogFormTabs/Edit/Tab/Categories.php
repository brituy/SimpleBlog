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
use Brituy\SimpleBlog\Model\ResourceModel\Categories\Collection as CategoriesCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\CollectionFactory as CategoriesCollectionFactory;

class Categories extends Generic implements TabInterface
{
    public function __construct(Context $context,Registry $registry,FormFactory $formFactory,
    				CategoriesCollectionFactory $categoriesCollection,array $data = [])
    {
        $this->formFactory   = $formFactory;
        $this->registry      = $registry;
        $this->categoriesCollectionFactory = $categoriesCollection;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /** Prepare form fields
     * @return \Magento\Backend\Block\Widget\Form */
    protected function _prepareForm()
    {
        /** @var $category \Brituy\SimpleBlog\Model\CategoriesCollectionFactory */
        $category = $this->categoriesCollectionFactory->create();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->formFactory->create();
        $form->setHtmlIdPrefix('category_');

        $cfieldset = $form->addFieldset('base_fieldset',['legend'=>__('Add Category Data'),'class'=>'fieldset-wide']);
        
        $cfieldset->addField('category','text',['name'=>'category','label'=>__('Category'),'title'=>__('Category'),'required'=>true]);

        $cfieldset->addField('savecat', 'button', array(
        	'label' => __('Save new category'),
        	'value' => __('Save category'),
        	'name'  => 'savecat',
        	'class' => 'submit',
        	'onclick' => "setLocation('{$this->getUrl('*/blog/savecategory')}')",));

        $form->addValues($category->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /** Prepare label for tab
     ** @return string */
    public function getTabLabel()
    {
        return __('Category');
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

