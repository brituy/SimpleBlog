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
use Brituy\SimpleBlog\Model\Source\Status;
use Brituy\SimpleBlog\Model\Source\CategoriesOpt;
use Brituy\SimpleBlog\Model\Source\AuthorsOpt;

class Article extends Generic implements TabInterface
{
    /** @var \Magento\Cms\Model\Wysiwyg\Config */
    protected $wysiwygConfig;

    /** @var Registry */
    //protected $registry;

    /** @var \Brituy\SimpleBlog\Model\Source\Status */
    protected $status;

    /** @var FormFactory */
    //protected $formFactory;

    /** Categories source
     * @var \Brituy\SimpleBlog\Model\Source\CategoriesOpt  */
    protected $categoriesOptSource;

    /** Authors source
     * @var \Brituy\SimpleBlog\Model\Source\AuthorsOpt  */
    protected $authorsOptSource;

    /** @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Status $status
     * CategoriesOpt $categoriesOptSource,
     * AuthorsOpt $authorsOptSource,
     * @param array $data */
    public function __construct(Context $context,Registry $registry,FormFactory $formFactory,WysiwygConfig $wysiwygConfig,
    				Status $status,CategoriesOpt $categoriesOptSource,AuthorsOpt $authorsOptSource,array $data=[])
    {
        $this->wysiwygConfig = $wysiwygConfig;
        $this->status = $status;
        $this->formFactory   = $formFactory;
        $this->registry      = $registry;
        $this->categoriesOptSource = $categoriesOptSource;
        $this->authorsOptSource = $authorsOptSource;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /** Prepare form fields
     * @return \Magento\Backend\Block\Widget\Form */
    protected function _prepareForm()
    {
        /** @var $blog \Brituy\SimpleBlog\Model\BlogFactory */
        $blog = $this->_coreRegistry->registry('simpleblog_article');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->formFactory->create();
        $form->setHtmlIdPrefix('blog_');
        // $form->setFieldNameSuffix('blog');

        //$form->setUseContainer(true); //!!! no Save action works without this

        // new filed
        if ($blog->getId()) {
            $fieldset = $form->addFieldset('base_fieldset',['legend'=>__('Edit Article Data'),'class'=>'fieldset-wide']);
            $fieldset->addField('blog_id', 'hidden', ['name' => 'blog_id']);
        } else {
            $fieldset = $form->addFieldset('base_fieldset',['legend'=>__('Add Article Data'),'class'=>'fieldset-wide']);
        }

        $fieldset->addField('visibility','select',
        	['name'=>'visibility','label'=>__('Visibility'),'options'=>$this->status->toOptionArray()]);

        $categoriesOptOptions = $this->categoriesOptSource->getAvailableOptions();
        $fieldset->addField('category_id', 'select',
        	['name'=>'category_id','label'=>__('Category'),'title'=>__("Category"),'required'=>true,'class'=>'validate-select',
        	'options'=>$categoriesOptOptions,]);

        $authorsOptOptions = $this->authorsOptSource->getAvailableOptions();
        $fieldset->addField('author_id', 'select',
        	['name'=>'author_id','label'=>__('Author'),'title'=>__("Author"),'required'=>true,'class'=>'validate-select',
        	'options'=>$authorsOptOptions,]);

        $fieldset->addField('blog_date','date',
        	['name'=>'blog_date','label'=>__('Blog Date'),'title'=>__('Blog Date'),'required'=>true,'date_format'=>'dd-MM-yyyy',]);

        $fieldset->addField('title','text',
        	['name'=>'title','label'=>__('Title'),'title'=>__('Title'),'required'=>true]);

        $fieldset->addField('content','editor',
        	['name'=>'content','label'=>'Content','config'=>$this->wysiwygConfig->getConfig(),'wysiwyg'=>true,'required'=>false]);

	/**$fieldset->addField('image','text',
        	array('name'=>'image','label'=> __('Image'),'title'=>__('Image'),));**/

        $form->addValues($blog->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /** Prepare label for tab
     ** @return string */
    public function getTabLabel()
    {
        return __('Article');
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

