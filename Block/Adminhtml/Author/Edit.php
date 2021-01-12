<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Author;

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
	$this->_objectId = 'author_id';
	$this->_blockGroup = 'Brituy_SimpleBlog';
	$this->_controller = 'adminhtml_author';
	parent::_construct();
	
	$this->buttonList->update('save primary', 'label', __('Save Author'));
	$this->buttonList->add(
		'saveandcontinue',[
			'label' => __('Save and Continue Edit'),
			'class' => 'save',
			'data_attribute' => [
				'mage-init' => [
					'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
				],
			],
		],
	-100);

	$this->buttonList->update('delete', 'label', __('Delete'));
    }

    /** Get edit form container header text
      * @return \Magento\Framework\Phrase|string */
    public function getHeaderText() 
    {
	if ($this->_coreRegistry->registry('simpleblog_author')->getId()) 
	{
		 return __("Edit Author '%1'", $this->escapeHtml($this->_coreRegistry->registry('simpleblog_author')->getTitle()));
	} else { return __('New Author'); }
	
    }
    
    /** Retrieve the save and continue edit Url.
      * @return string */
    protected function _getSaveAndContinueUrl() 
    {
	return $this->getUrl('Brituy_SimpleBlog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }   
}
