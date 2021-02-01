<?php
namespace Brituy\SimpleBlog\Api\Data;


interface BlogInterface
{
    /** Constants for keys of data array. Identical to the name of the getter in snake case */
    const BLOG_ID       = 'blog_id';
    const VISIBILITY    = 'visibility';
    const CATEGORY_ID   = 'category_id';
    const AUTHOR_ID     = 'author_id';
    const BLOG_DATE     = 'blog_date';
    const TITLE         = 'title';
    const CONTENT       = 'content';

    /** Get blog ID
     ** @return int|null */
    public function getBlogId();
    
    /** Get Visibility
     ** @return bool|null */
    public function getVisibility();
    
    /** Get creation date
     ** @return string|null */
    public function getBlogDate();

    /** Get title
     ** @return string|null */
    public function getTitle();

    /** Get content
     ** @return string|null */
    public function getContent();

    

    /** Set blog ID
     ** @param int $blogid
     * @return \Brituy\SimpleBlog\Api\Data\BlogInterface */
    public function setBlogId($blogid);
    
    /** Set is visibility
     ** @param int|bool $visibility
     * @return \Brituy\SimpleBlog\Api\Data\BlogInterface */
    public function setVisibility($visibility);

    /** Set creation date
     ** @param string $blogDate
     * @return \Brituy\SimpleBlog\Api\Data\BlogInterface */
    public function setBlogDate($blogDate);
    
    /** Set title
     ** @param string $title
     * @return \Brituy\SimpleBlog\Api\Data\BlogInterface */
    public function setTitle($title);

    /** Set content
     ** @param string $content
     * @return \Brituy\SimpleBlog\Api\Data\BlogInterface */
    public function setContent($content);
}
