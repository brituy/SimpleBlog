<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Author\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Button "Create Author" in "New Blog" slide-out panel of a product page
 */
class CreateAuthor implements ButtonProviderInterface
{
    /** @return array */
    public function getButtonData()
    {
        return [
            'label' => __('Add Author'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 10
        ];
    }
}
