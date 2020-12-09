<?php

namespace Brituy\SimpleBlog\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/** Class Topic
 * @package Brituy\SimpleBlog\Block\Adminhtml */
class Post extends Container
{
    /** constructor
      * @return void */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_post';
        $this->_blockGroup = 'Brituy_SimpleBlog';
        $this->_headerText = __('Articles');
        $this->_addButtonLabel = __('Add Article');

        parent::_construct();
    }
}
