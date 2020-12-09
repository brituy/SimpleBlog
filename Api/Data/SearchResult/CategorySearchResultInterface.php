<?php

namespace Brituy\SimpleBlog\Api\Data\SearchResult;

use Magento\Framework\Api\SearchResultsInterface;

/** Interface CategorySearchResultInterface
 * @package Brituy\SimpleBlog\Api\Data\SearchResult */
interface CategorySearchResultInterface extends SearchResultsInterface
{
    /** @return \Brituy\SimpleBlog\Api\Data\CategoryInterface[] */
    public function getItems();

    /** @param \Brituy\SimpleBlog\Api\Data\CategoryInterface[] $items
     * @return $this  */
    public function setItems(array $items = null);
}
