<?php
namespace Brituy\SimpleBlog\Api\Data;


interface PostInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const BLOG_ID       = 'blog_id';
    const VISIBILITY    = 'visibility';
    const CATEGORY_ID   = 'category_id';
    const AUTHOR_ID     = 'author_id';
    const DATE          = 'date';
    const TITLE         = 'title';
    const CONTENT       = 'content';

    /**
     * Get BLOG_ID
     * @return int|null
     */
    public function getBlogId();

    /**
     * Get article visibility
     * @return bool|null
     */
    public function getVisibility();

    /**
     * Get category_id
     * @return int|null
     */
    public function getCategoryId();

    /**
     * Get AuthorId
     * @return int|null
     */
    public function getAuthorId();

    /**
     * Get creationDate
     * @return string|null
     */
    public function getDate();

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Get CONTENT
     * @return Blob|null
     */
    public function getContent();



    /**
     * Set BlogId
     * @param int $blogid
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setBlogId($blogid);

    /**
     * Set visibility
     * @param int|bool $visibility
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setVisibility($visibility);

    /**
     * Set CategoryId
     * @param int $categoryid
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setCategoryId($categoryid);

    /**
     * Set authorid
     * @param int $authorid
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setAuthorId($authorid);

    /**
     * Set creationDate
     * @param string $creationDate
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setDate($creationDate);

    /**
     * Set title
     * @param string $title
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setTitle($title);

    /**
     * Set content
     * @param Blob $content
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setContent($content);
}
