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
            self::ENABLED => __('Visible'),
            self::DISABLED => __('UnVisible'),
        ];
        return $options;
    }
 
}
