<?php
namespace Brituy\SimpleBlog\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\CollectionFactory;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\Collection as CategoriesCollection;

/** CategoriesOpt
 * @package Brituy\SimpleBlog\Model\System */
class CategoriesOpt implements OptionSourceInterface
{
    /** @var CollectionFactory */
    private $categoriesCollectionFactory;

    /** @param CollectionFactory $categoriesCollectionFactory */
    public function __construct(CollectionFactory $categoriesCollectionFactory) 
    {
        $this->categoriesCollectionFactory = $categoriesCollectionFactory;
    }

    /** {@inheritdoc} */
    public function toOptionArray()
    {
        /** @var CategoriesCollectionFactory $collection */
        $collection = $this->categoriesCollectionFactory->create();
        $collection->setOrder('category','ASC');

        $categoriesOptions = [];
        foreach ($collection as $item) 
        {
            $categoriesOptions[] = [
                'value' => $item->getId(),
                'label' => $item->getCategory(),
            ];
        }
        return $categoriesOptions;
    }

    /** Get options
     * @return array */
    public function getOptions()
    {
        $optionsArray = $this->toOptionArray();
        $options = [];
        foreach ($optionsArray as $option) 
        {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }

    /** Get available options
     * @return array */
    public function getAvailableOptions()
    {
        $allOptions = $this->getOptions();
        $newOptions = ['none'=>__('Please select')];
        return $newOptions + $allOptions;
    }

    /** Get option by value
     * @param int $value
     * @return string|null */
    public function getOptionByValue($value)
    {
        $options = $this->getOptions();
        
        if (array_key_exists($value, $options)) 
        {
            return $options[$value];
        }
        return null;
    }
}
