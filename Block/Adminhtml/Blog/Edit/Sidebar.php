<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit;

use Exception;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Registry;
use Brituy\SimpleBlog\Model\Blog;
use Zend_Locale_Data;
use Zend_Locale_Exception;

class Sidebar extends Template
{
    /** @var string */
    protected $_template = "blog/edit/sidebar.phtml";

    /** @var Registry */
    protected $registry;

    /** @param Registry $registry
     * @param Context  $context */
    public function __construct(
        ResolverInterface $localeResolver,
        Registry $registry,
        Context $context
    ) {
        $this->localeResolver = $localeResolver;
        $this->registry       = $registry;

        parent::__construct($context);
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->registry->registry('simpleblog_article');
    }

    /**
     * @param string $param
     * @param string $default
     *
     * @return string
     * @throws Zend_Locale_Exception
     */
    public function getLocaleData($param, $default = '')
    {
        try {
            $text = Zend_Locale_Data::getContent($this->localeResolver->getLocale(), $param);
        } catch (Exception $e) {
            $text = $default;
        }

        return $text;
    }
}
