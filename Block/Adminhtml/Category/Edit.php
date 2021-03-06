<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Category;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

/** Block for edit page */
class Edit extends Container 
{
    /** Core registry
    * @var \Magento\Framework\Registry */
    protected $_coreRegistry = null;

    /** @param \Magento\Backend\Block\Widget\Context $context
        @param \Magento\Framework\Registry $registry
        @param array $data */
    public function __construct(Context $context, Registry $registry, array $data = [])
    {
	$this->_coreRegistry = $registry;
	parent::__construct($context, $data);
    }

    /** Init container Class constructor
      * @return void */
    protected function _construct() 
    {
	$this->_objectId = 'category_id';
	$this->_blockGroup = 'Brituy_SimpleBlog';
	$this->_controller = 'adminhtml_category';
	parent::_construct();
	
	$this->buttonList->update('save primary', 'label', __('Save Category'));

	$this->buttonList->update('delete', 'label', __('Delete'));
    }

    /** Get edit form container header text
      * @return \Magento\Framework\Phrase|string */
    public function getHeaderText() 
    {
	if ($this->_coreRegistry->registry('simpleblog_category')->getId()) 
	{
		 return __("Edit Category '%1'", $this->escapeHtml($this->_coreRegistry->registry('simpleblog_category')->getTitle()));
	} else { return __('New Category'); }
	
    }
    
    /** Retrieve the save and continue edit Url.
      * @return string */
    protected function _getSaveAndContinueUrl() 
    {
	return $this->getUrl('Brituy_SimpleBlog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }   
}
