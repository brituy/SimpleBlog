<?php
namespace Brituy\SimpleBlog\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Event\ObserverInterface;
use Brituy\SimpleBlog\Model\Config;

class TopMenuObserver implements ObserverInterface
{
    /** @var Config */
    protected $config;
    
    public function __construct( Config $config )
    {
	$this->config = $config;
    }
    
    /** @param EventObserver $observer
     * @return $this */
    public function execute(EventObserver $observer)
    {
        if (!$this->config->isDisplayInMenu()) { return; }
        
        /** @var \Magento\Framework\Data\Tree\Node $menu */
        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $data = ['id'		=> 'simpleblog_menu_node', //unique-id-here
        	  'name'	=> $this->config->getMenuTitle(), // Link Lable
		  'url'	=> 'blog',
		  'is_active'	=> false //(expression to determine if menu item is selected or not) (true/false)
        ];
        $node = new Node($data, 'id', $tree, $menu);
        $menu->addChild($node);
        return $this;
    }
}
