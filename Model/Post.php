<?php
namespace Brituy\SimpleBlog\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime;
use Brituy\SimpleBlog\Helper\Data;
use Brituy\SimpleBlog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Brituy\SimpleBlog\Model\ResourceModel\Post as PostResource;
use Brituy\SimpleBlog\Model\ResourceModel\Post\Collection;
use Brituy\SimpleBlog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * @method Post setName($name)
 * @method Post setShortDescription($shortDescription)
 * @method Post setPostContent($postContent)
 * @method Post setImage($image)
 * @method Post setViews($views)
 * @method Post setEnabled($enabled)
 * @method Post setUrlKey($urlKey)
 * @method Post setInRss($inRss)
 * @method Post setAllowComment($allowComment)
 * @method Post setMetaTitle($metaTitle)
 * @method Post setMetaDescription($metaDescription)
 * @method Post setMetaKeywords($metaKeywords)
 * @method Post setMetaRobots($metaRobots)
 * @method mixed getName()
 * @method mixed getPostContent()
 * @method mixed getImage()
 * @method mixed getViews()
 * @method mixed getEnabled()
 * @method mixed getUrlKey()
 * @method mixed getInRss()
 * @method mixed getAllowComment()
 * @method mixed getMetaTitle()
 * @method mixed getMetaDescription()
 * @method mixed getMetaKeywords()
 * @method mixed getMetaRobots()
 * @method Post setCreatedAt(string $createdAt)
 * @method string getCreatedAt()
 * @method Post setUpdatedAt(string $updatedAt)
 * @method string getUpdatedAt()
 * @method Post setTagsData(array $data)
 * @method Post setTopicsData(array $data)
 * @method Post setProductsData(array $data)
 * @method array getTagsData()
 * @method array getProductsData()
 * @method array getTopicsData()
 * @method Post setIsChangedTagList(bool $flag)
 * @method Post setIsChangedProductList(bool $flag)
 * @method Post setIsChangedTopicList(bool $flag)
 * @method Post setIsChangedCategoryList(bool $flag)
 * @method bool getIsChangedTagList()
 * @method bool getIsChangedTopicList()
 * @method bool getIsChangedCategoryList()
 * @method Post setAffectedTagIds(array $ids)
 * @method Post setAffectedEntityIds(array $ids)
 * @method Post setAffectedTopicIds(array $ids)
 * @method Post setAffectedCategoryIds(array $ids)
 * @method bool getAffectedTagIds()
 * @method bool getAffectedTopicIds()
 * @method bool getAffectedCategoryIds()
 * @method array getCategoriesIds()
 * @method Post setCategoriesIds(array $categoryIds)
 * @method array getTagsIds()
 * @method Post setTagsIds(array $tagIds)
 * @method array getTopicsIds()
 * @method Post setTopicsIds(array $topicIds)
 */
class Post extends AbstractModel
{
    /** Cache tag
     * @var string */
    const CACHE_TAG = 'brituy_blog_main';

    /** Cache tag
     * @var string */
    protected $_cacheTag = 'brituy_blog_main';

    /** Event prefix
     * @var string */
    protected $_eventPrefix = 'brituy_blog_main';

    /** Blog Category Collection
     * @var ResourceModel\Category\Collection */
    public $categoryCollection;

    /** Blog Category Collection Factory
     * @var CategoryCollectionFactory */
    public $categoryCollectionFactory;

    /** @var Data */
    public $helperData;

    /** Post constructor.
     * @param Context $context
     * @param Registry $registry
     * @param DateTime $dateTime
     * @param Data $helperData
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param PostCollectionFactory $postCollectionFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        DateTime $dateTime,
        Data $helperData,
        CategoryCollectionFactory $categoryCollectionFactory,
        PostCollectionFactory $postCollectionFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->helperData = $helperData;
        $this->dateTime = $dateTime;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /** Initialize resource model
     * @return void */
    protected function _construct()
    {
        $this->_init(PostResource::class);
    }

    /** @inheritdoc */
    public function afterSave()
    {
        if ($this->isObjectNew()) {
            $trafficModel = $this->trafficFactory->create()
                ->load($this->getId(), 'blog_id');
            if (!$trafficModel->getId()) {
                $trafficModel->setData([
                    'blog_id' => $this->getId(),
                    'numbers_view' => 0
                ])->save();
            }
        }

        return parent::afterSave();
    }

    /** @param bool $shorten
     * @return mixed|string */
    public function getShortDescription($shorten = false)
    {
        $shortDescription = $this->getData('short_description');

        $maxLength = 200;
        if ($shorten && strlen($shortDescription) > $maxLength) {
            $shortDescription = substr($shortDescription, 0, $maxLength) . '...';
        }

        return $shortDescription;
    }

    /** @param null $store
     * @return string */
    public function getUrl($store = null)
    {
        return $this->helperData->getBlogUrl($this, Data::TYPE_POST, $store);
    }

    /** Get identities
     * @return array */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /** @return array
     * @throws LocalizedException */
    public function getCategoriesIds()
    {
        if (!$this->hasData('category_ids')) {
            $ids = $this->_getResource()->getCategoryIds($this);

            $this->setData('category_ids', $ids);
        }

        return (array)$this->_getData('category_ids');
    }

    /** @return ResourceModel\Category\Collection */
    public function getSelectedCategoriesCollection()
    {
        if ($this->categoryCollection === null) {
            $collection = $this->categoryCollectionFactory->create();
            $collection->join(
                $this->getResource()->getTable('brituy_blog_categories'),
                'main_table.category_id=' . $this->getResource()->getTable('brituy_blog_categories') .
                '.category_id',
                ['position']
            );
            $this->categoryCollection = $collection;
        }

        return $this->categoryCollection;
    }
}
