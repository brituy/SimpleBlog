<?php

namespace Brituy\SimpleBlog\Api\Data;

/** Interface CategoryInterface
 * @package Brituy\SimpleBlog\Api\Data */
interface CategoryInterface
{
    /** Constants used as data array keys */
    const CATEGORY_ID      = 'category_id';
    const CATEGORY         = 'category';

    const ATTRIBUTES = [
        self::CATEGORY_ID,
        self::CATEGORY
    ];

    /** @return int|null */
    public function getId();

    /** @param int $id
     * @return $this */
    public function setId($id);

    /** @return string/null */
    public function getCategory();

    /** @param string $name
     * @return $this */
    public function setCategory($name);
}
