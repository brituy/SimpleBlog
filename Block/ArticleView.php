<?php
namespace Brituy\SimpleBlog\Block;

use Brituy\SimpleBlog\Model\Config;
use Brituy\SimpleBlog\Model\Blog;
use Brituy\SimpleBlog\Model\BlogFactory;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection as BlogCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\AbstractBlock;
use Zend_Db_Select;
use Zend_Filter_Exception;
use Zend_Filter_Interface;

class ArticleView extends Template implements IdentityInterface
{
    const NUMBER_RELATED_PRODUCTS = 10;

    /** @var PostFactory */
    protected $blogFactory;

    /** @var Zend_Filter_Interface */
    protected $templateProcessor;

    /** @var ReviewRendererInterface */
    protected $reviewRenderer;

    /** @var PostCollectionFactory */
    protected $postCollectionFactory;

    public function __construct(
        Template\Context $context,
        BlogFactory $blogFactory,
        Zend_Filter_Interface $templateProcessor,
        Config $config,
        Registry $registry,
        PageConfig $pageConfig,
        BlogCollectionFactory $blogCollectionFactory,
        array $data = []
    ) {
        $this->_registry = $registry;
        $this->blogFactory = $blogFactory;
        $this->templateProcessor = $templateProcessor;
        $this->blogCollectionFactory = $blogCollectionFactory;
        parent::__construct($context);
    }

    /** @return Article|null */
    public function getArticle()
    {
        $blogid = $this->getRequest()->getParam('blog_id');
        
        return $this->blogFactory->create()->load($blogid);
    }

    /** Get posts which are related to the current post
     * @return array|PostCollection
     * @throws NoSuchEntityException */
    public function getRecentArticles()
    {
        $currentPost = $this->getPost();
        $relatedPostIds = $currentPost->getRelatedPostIds();
        $relatedPosts = $this->postCollectionFactory->create();

        if (!count($relatedPostIds)) {
            return [];
        }

        $relatedPosts->addFieldToFilter('is_active', Post::STATUS_ENABLED)
            ->addStoreFilter($this->_storeManager->getStore());
        $relatedPosts->addFieldToFilter('post_id', ['in' => $relatedPostIds]);
        $relatedPosts->addFieldToFilter('post_id', ['neq' => $currentPost->getId()])
            ->setOrder('post_id')
            ->setPageSize($this->config->getRelatedPosts() ?: self::NUMBER_RELATED_POSTS);
        return $relatedPosts;
    }

    /**
     * Get recent posts
     *
     * @return PostCollection
     * @throws NoSuchEntityException
     */
    public function getRecentPosts()
    {
        $currentPost = $this->getPost();
        $recentPosts = $this->postCollectionFactory->create();
        $recentPosts->addFieldToFilter('is_active', Post::STATUS_ENABLED)
            ->addStoreFilter($this->_storeManager->getStore());
        $recentPosts->addFieldToFilter('post_id', ['neq' => $currentPost->getId()])
            ->setOrder('post_id')
            ->setPageSize($this->config->getRelatedPosts() ?: self::NUMBER_RELATED_POSTS);

        return $recentPosts;
    }

    /** @param $string
     * @return mixed
     * @throws Zend_Filter_Exception  */
    public function filterOutputHtml($string)
    {
        return $this->templateProcessor->filter($string);
    }

    /** Return unique ID(s) for each object in system
     * @return string[]  */
    public function getIdentities()
    {
        return  $this->getPost()->getIdentities();
    }

    /**
     * @return $this|AbstractBlock
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function _prepareLayout()
    {
        if ($blog = $this->getBlog()) {
            $this->addBreadcrumbs();
            $this->pageConfig->setMetaTitle($blog->getMetaTitle());
            $this->pageConfig->getTitle()->set($blog->getMetaTitle() ?: $blog->getTitle());
        }
        return $this;
    }

    /** Add Breadcrumbs for block
     * @throws LocalizedException
     * @throws NoSuchEntityException */
    protected function addBreadcrumbs()
    {
        if ($currentPost = $this->getPost()) {
            $breadCrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
            if ($breadCrumbsBlock) {
                $this->addHomeBreadCrumb($breadCrumbsBlock);
                $this->addBlogBreadCrumb($breadCrumbsBlock);
                $currentPostTitle = $currentPost->getTitle();
                $breadCrumbsBlock->addCrumb(
                    'post_page',
                    [
                        'label' => $currentPostTitle,
                        'title' => $currentPostTitle,
                        'link'  => ''
                    ]
                );
            }
        }
    }
}
