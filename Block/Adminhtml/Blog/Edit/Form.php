<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Brituy\SimpleBlog\Model\Source\Status;
use Brituy\SimpleBlog\Model\Source\CategoriesOpt;
use Brituy\SimpleBlog\Model\Source\AuthorsOpt;

class Form extends Generic
{
    /** @var \Magento\Cms\Model\Wysiwyg\Config */
    protected $_wysiwygConfig;

    /** @var \Brituy\SimpleBlog\Model\Source\Status */
    protected $_status;

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
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $status,
        CategoriesOpt $categoriesOptSource,
        AuthorsOpt $authorsOptSource,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        $this->categoriesOptSource = $categoriesOptSource;
        $this->authorsOptSource = $authorsOptSource;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /** Prepare form fields
     * @return \Magento\Backend\Block\Widget\Form */
    protected function _prepareForm()
    {
        /** @var $model \Brituy\SimpleBlog\Model\BlogFactory */
        $model = $this->_coreRegistry->registry('simpleblog_article');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            		['data'=>['id' => 'edit_form',
                            	   'enctype' => 'multipart/form-data',
                            	   'action' => $this->getData('action'),
                            	   'method' => 'post']
            		]);
        $form->setHtmlIdPrefix('blog_');
        
        // $form->setFieldNameSuffix('blog');
        // new filed
        if ($model->getId()) {
            $fieldset = $form->addFieldset('base_fieldset',['legend'=>__('Edit Article Data'),'class'=>'fieldset-wide']);
            $fieldset->addField('blog_id', 'hidden', ['name' => 'blog_id']);
        } else {
            $fieldset = $form->addFieldset('base_fieldset',['legend'=>__('Add Article Data'),'class'=>'fieldset-wide']);
        }

        $fieldset->addField('visibility','select',
        	['name'=>'visibility','label'=>__('Visibility'),'options'=>$this->_status->toOptionArray()]);

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
        	['name'=>'content','label'=>'Content','config'=>$this->_wysiwygConfig->getConfig(),'wysiwyg'=>true,'required'=>false]);

	/**$fieldset->addField('image','text',
        	array('name'=>'image','label'=> __('Image'),'title'=>__('Image'),));**/

        $data = $model->getData();
        $form->setValues($data);
        $form->setUseContainer(true); //!!! no Save action works without this
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

