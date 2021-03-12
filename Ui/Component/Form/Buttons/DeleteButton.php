<?php
namespace Brituy\SimpleBlog\Ui\Component\Form\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Brituy\SimpleBlog\Api\Data\PostInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'label'      => __('Delete'),
                'class'      => 'delete',
                'on_click'   => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', [PostInterface::ID => $this->getId()]);
    }
}
