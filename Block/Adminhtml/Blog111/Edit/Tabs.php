<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit;

/** Class Tabs
 ** @package Brituy\SimpleBlog\Block\Adminhtml\Post\Edit */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();

        $this->setId('blog_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Article Information'));
    }
    
    /**protected function _beforeToHtml()
    {
        $this->addTab('article_section', [
            'label'   => __('Article Information'),
            'title' => __('Article Information'),
            'content' => $this->getLayout()->createBlock('Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Tab\Article')->toHtml(),
            'active' => true
        ]);

        $this->addTab('author_section', [
            'label'   => __('Authors'),
            'title' => __('Blog Authors'),
            'content' => $this->getLayout()->createBlock('Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Tab\Authors')->toHtml(),
            'active' => true
        ]);

        $this->addTab('category_section', [
            'label'   => __('Categories'),
            'title' => __('Blog Categories'),
            'content' => $this->getLayout()->createBlock('Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Tab\Categories')->toHtml(),
            'active' => true
        ]);

        return parent::_beforeToHtml();
    }**/
}
