<?php
// model file contain overall database logic
namespace Brituy\SimpleBlog\Model\ResourceModel;

use Magento\Backend\Model\Auth;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Brituy\SimpleBlog\Helper\Data;

class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public $blogAuthorsTable;
    public $blogCategoryTable;

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);

        $this->blogAuthorsTable = $this->getTable('brituy_blog_authors');
        $this->blogCategoryTable = $this->getTable('brituy_blog_categories');
    }

	protected function _construct()
	{
		$this->_init('brituy_blog_main', 'blog_id');
	}


}
