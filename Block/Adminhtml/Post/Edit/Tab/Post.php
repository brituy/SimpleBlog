<?php

namespace Brituy\SimpleBlog\Block\Adminhtml\Post\Edit\Tab;

use Exception;
use Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
/**use Magento\Backend\Model\Auth\Session;**/
use Magento\Cms\Model\Page\Source\PageLayout as BasePageLayout;
use Magento\Cms\Model\Wysiwyg\Config;
/**use Magento\Config\Model\Config\Source\Design\Robots;**/
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\Data\Form;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;
/**use Magento\Store\Model\System\Store;**/
use Brituy\SimpleBlog\Block\Adminhtml\Post\Edit\Tab\Renderer\Authors;
use Brituy\SimpleBlog\Block\Adminhtml\Post\Edit\Tab\Renderer\Category;
/** use Brituy\SimpleBlog\Helper\Image; **/
/**use Brituy\SimpleBlog\Model\Config\Source\Authors;**/
/**use Brituy\SimpleBlog\Model\Config\Source\Category;**/
/** Class Post
  * @package Brituy\SimpleBlog\Block\Adminhtml\Post\Edit\Tab */
class Post extends Generic implements TabInterface
{
    /** Wysiwyg config
      * @var Config */
    public $wysiwygConfig;

    public $booleanOptions;

    /** @var Image */
    /** protected $imageHelper; */

    /** @var DateTime */
    protected $_date;

    /** @var BasePageLayout */
    protected $_layoutOptions;

    /** @var Authors */
    protected $_authors;

    /** @var Category */
    protected $_category;

    /** Post constructor.
     * @param Context $context
     * @param Registry $registry
     * @param DateTime $dateTime
     * @param BasePageLayout $layoutOption
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Yesno $booleanOptions
     * @param Image $imageHelper
     * @param Authors $authors
     * @param Category $category
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        DateTime $dateTime,
        BasePageLayout $layoutOption,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Yesno $booleanOptions,
      /**  Image $imageHelper, **/
        Authors $authors,
        Category $category,
        array $data = []
    ) {
        $this->wysiwygConfig = $wysiwygConfig;
        $this->booleanOptions = $booleanOptions;
        $this->_date = $dateTime;
        $this->_layoutOptions = $layoutOption;
        /** $this->imageHelper = $imageHelper; **/
        $this->_authors = $authors;
        $this->_category = $category;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /** @inheritdoc
      * @throws Exception */
    protected function _prepareForm()
    {
        /** @var \Brituy\SimpleBlog\Model\Post $post */
        $post = $this->_coreRegistry->registry('brituy_simpleblog_post');

        /** @var Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Article Information'),
            'class' => 'fieldset-wide'
        ]);

        /**if ($this->_request->getParam('duplicate')) {
            $fieldset->addField('duplicate', 'hidden', [
                'name' => 'duplicate',
                'value' => 1
            ]);
        }**/

        $fieldset->addField('visibility', 'select', [
            'name' => 'visibility',
            'label' => __('Visibility'),
            'title' => __('Visibility'),
            'values' => $this->booleanOptions->toOptionArray(),
        ]);
        if (!$post->hasData('visibility')) {
            $post->setVisibility(1);
        }

        $fieldset->addField('category_id', Category::class, [
            'name' => 'category',
            'label' => __('Category'),
            'title' => __('Category'),
            'required' => true,
            'values' => $this->_category->toOptionArray()
        ]);

        $fieldset->addField('author_id', Authors::class, [
            'name' => 'author',
            'label' => __('Author'),
            'title' => __('Author'),
            'required' => true,
            'values' => $this->_authors->toOptionArray()
        ]);

        $fieldset->addField(
            'blog_date',
            'date',
            [
                'name' => 'blog_date',
                'label' => __('Blog Date'),
                'title' => __('Blog Date'),
                'required' => true,
                'date_format' => 'dd-MM-yyyy',
            ]
        );

        $fieldset->addField('title', 'textarea', [
            'name' => 'title',
            'label' => __('Article Title'),
            'title' => __('Article Title'),
            'required' => true
        ]);

        $fieldset->addField('content', 'editor', [
            'name' => 'content',
            'label' => __('Content'),
            'title' => __('Content'),
            'required' => true,
            'config' => $this->wysiwygConfig->getConfig([
                'add_variables' => false,
                'add_widgets' => false,
                'add_directives' => false
            ])
        ]);

        /**
        $fieldset->addField('image', \Brituy\SimpleBlog\Block\Adminhtml\Renderer\Image::class, [
            'name' => 'image',
            'label' => __('Image'),
            'title' => __('Image'),
            'path' => $this->imageHelper->getBaseMediaPath(Image::TEMPLATE_MEDIA_TYPE_POST),
            'note' => __('The appropriate size is 265px * 250px.')
        ]);
        **/

        $form->addValues($post->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /** Prepare label for tab
      * @return string*/
    public function getTabLabel()
    {
        return __('Article ***');
    }

    /** Prepare title for tab
      * @return string*/
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /** Can show tab in tabs
      * @return boolean*/
    public function canShowTab()
    {
        return true;
    }

    /** Tab is hidden
      * @return boolean*/
    public function isHidden()
    {
        return false;
    }
}
