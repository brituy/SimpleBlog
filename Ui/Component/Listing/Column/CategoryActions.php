<?php
namespace Brituy\SimpleBlog\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
//use Brituy\SimpleBlog\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder;

class CategoryActions extends Column
{
    /** Url path */
    const URL_EDIT_PATH = 'brituy_simpleblog/category/edit';
    const URL_DELETE_PATH = 'brituy_simpleblog/category/delete';
    
    /** @var UrlBuilder */
    //protected $actionUrlBuilder;

    /** @var UrlInterface */
    protected $urlBuilder;

    /** @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        //UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        //$this->actionUrlBuilder = $actionUrlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    
    /** Prepare Data Source
     * @param array $dataSource
     * @return array*/
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) 
        {
            foreach ($dataSource['data']['items'] as & $item) 
            {
                if (isset($item['category_id'])) 
                {
                    $item[$this->getData('name')] = [
                        'edit'=>['href' => $this->urlBuilder->getUrl(static::URL_EDIT_PATH,['category_id'=>$item['category_id'],]),
                            	  'label'=>__('Edit'),],
                        'delete'=>['href'=>$this->urlBuilder->getUrl(static::URL_DELETE_PATH,['category_id'=>$item['category_id'],]),
                            	  'label' => __('Delete'),],
                            	  ];
                }
            }
        }
        return $dataSource;
    }
}
