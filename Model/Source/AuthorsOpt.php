<?php
namespace Brituy\SimpleBlog\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Authors\CollectionFactory;
use Brituy\SimpleBlog\Model\ResourceModel\Authors\Collection as AuthorsCollection;

/** CategoriesOpt
 * @package Brituy\SimpleBlog\Model\System */
class AuthorsOpt implements OptionSourceInterface
{
    /** @var CollectionFactory */
    private $categoriesCollectionFactory;

    /** @param CollectionFactory $authorsCollectionFactory */
    public function __construct(CollectionFactory $authorsCollectionFactory) 
    {
        $this->authorsCollectionFactory = $authorsCollectionFactory;
    }

    /** {@inheritdoc} */
    public function toOptionArray()
    {
        /** @var CategoriesCollectionFactory $collection */
        $collection = $this->authorsCollectionFactory->create();

        $authorsOptions = [];
        foreach ($collection as $item) {
            $authorsOptions[] = [
                'value' => $item->getId(),
                'label' => $item->getAuthor(),
            ];
        }
        return $authorsOptions;
    }

    /** Get options
     * @return array */
    public function getOptions()
    {
        $optionsArray = $this->toOptionArray();
        $options = [];
        foreach ($optionsArray as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }

    /** Get available options
     * @return array */
    public function getAvailableOptions()
    {
        $allOptions = $this->getOptions();
        $newOptions = [
            'none' => __('Please select')
        ];
        return $newOptions + $allOptions;
    }

    /** Get option by value
     * @param int $value
     * @return string|null */
    public function getOptionByValue($value)
    {
        $options = $this->getOptions();
        if (array_key_exists($value, $options)) {
            return $options[$value];
        }
        return null;
    }
}
