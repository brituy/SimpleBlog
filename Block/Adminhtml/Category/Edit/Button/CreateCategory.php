<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Category\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Button "Create Category" in "New Blog" slide-out panel of a product page
 */
class CreateCategory implements ButtonProviderInterface
{
    /** @return array */
    public function getButtonData()
    {
        return [
            'label' => __('Add Category'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save', 'target' => '#edit_form']],
                'form-role' => 'save',
            ],
            'sort_order' => 10
        ];
    }
}
