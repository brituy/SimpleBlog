<?php
namespace Brituy\SimpleBlog\Model\Source;
 
use Magento\Framework\Option\ArrayInterface;
 
class Status implements ArrayInterface
{
    const ENABLED  = 1;
    const DISABLED = 0;
 
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('UnVisible'),
                'value' => self::DISABLED,
            ],
            [
                'label' => __('Visible'),
                'value' => self::ENABLED,
            ],
        ];
        return $options;
    }
 
}
