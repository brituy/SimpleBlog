<?php
namespace Brituy\SimpleBlog\Ui\Component\Form\Buttons;

use Magento\Backend\Block\Widget\Context;
use Brituy\SimpleBlog\Api\Data\PostInterface;

class GenericButton
{
    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function getId()
    {
        return $this->context->getRequest()->getParam(PostInterface::ID);
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
