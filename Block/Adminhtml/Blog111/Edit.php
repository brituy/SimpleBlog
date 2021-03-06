<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog;

use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Brituy\SimpleBlog\Model\Article;

/** Block for edit page */
class Edit extends Container 
{
    /** Core registry
    * @var \Magento\Framework\Registry */
    //public $coreRegistry;

    /** @param \Magento\Backend\Block\Widget\Context $context
        @param \Magento\Framework\Registry $registry
        @param array $data */
    //public function __construct(Registry $coreRegistry,Context $context,array $data = [])
    //{
	//$this->coreRegistry = $coreRegistry;
	//parent::__construct($context, $data);
    //}

    /** Init container Class constructor
      * @return void */
    protected function _construct() 
    {
	$this->_objectId = 'blog_id';
	$this->_blockGroup = 'Brituy_SimpleBlog';
	$this->_controller = 'adminhtml_blog';
	
	parent::_construct();
	
	$this->buttonList->update('save primary', 'label', __('Save Article'));
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
    /**public function getHeaderText() 
    {
	if ($this->coreRegistry->registry('simpleblog_article')->getId()) 
	{
		 return __("Edit Article '%1'", $this->escapeHtml($this->_coreRegistry->registry('simpleblog_article')->getTitle()));
	} else { return __('New Article'); }
    }**/
    
    /** Retrieve the save and continue edit Url.
      * @return string */
    //protected function _getSaveAndContinueUrl() 
    //{
	//return $this->getUrl('Brituy_SimpleBlog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    //}   
}
