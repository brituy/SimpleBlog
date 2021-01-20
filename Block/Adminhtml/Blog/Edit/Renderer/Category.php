<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Renderer;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Select;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\Collection;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\CollectionFactory as CategoriesCollectionFactory;

/**
 * Class Category
 * @package Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Renderer
 */
class Category extends Select
{
    /** @var CategoriesCollectionFactory */
    public $categoriesCollectionFactory;
    
    /** @var UrlInterface */
    protected $_urlBuilder;

    /** Tag constructor.
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param CategoriesCollectionFactory $collectionFactory
     * @param AuthorizationInterface $authorization
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryElementCollection,
        Escaper $escaper,
        CategoriesCollectionFactory $categoriesCollectionFactory,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->CategoriesCollectionFactory = $categoriesCollectionFactory;
        $this->_urlBuilder = $urlBuilder;

        parent::__construct($factoryElement, $factoryElementCollection, $escaper, $data);
    }

    /** @inheritdoc */
    public function getElementHtml()
    {
        $html = '<div class="admin__field-control admin__control-grouped">';
        $html .= '<div id="blog-category-select" class="admin__field" data-bind="scope:\'blogCategory\'" data-index="index">';
        $html .= '<!-- ko foreach: elems() -->';
        $html .= '<input name="blog[category_id]" data-bind="value: value" style="display: none"/>';
        $html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
        $html .= '<!-- /ko -->';
        $html .= '</div>';

        $html .= '<div class="admin__field admin__field-group-additional admin__field-small"'
            . 'data-bind="scope:\'create_category_button\'">';
        $html .= '<div class="admin__field-control">';
        $html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
        $html .= '</div></div></div>';

        $html .= '<!-- ko scope: \'create_category_modal\' --><!-- ko template: getTemplate() --><!-- /ko --><!-- /ko -->';

        $html .= $this->getAfterElementHtml();

        return $html;
    }

    public function getCategoriesCollection()
    {
        /* @var $collection Collection */
        $collection = $this->CategoriesCollectionFactory->create();
        $categoryById = [];
        $categoryById[0]['value'] = 'none';
        $categoryById[0]['label'] = 'Please select';
        foreach ($collection as $category) {
            $categoryById[$category->getId()]['value'] = $category->getId();
            $categoryById[$category->getId()]['label'] = $category->getCategory();
        }

        return $categoryById;
    }
    
    public function getValues()
    {
        $values = $this->getValue();

        if (!is_array($values)) { $values = explode(',', $values); }

        if (!count($values)) { return []; }

        /* @var $collection Collection */
        $collection = $this->CategoriesCollectionFactory->create();

        $options = [];
        foreach ($collection as $category) { $options[] = $category->getId(); }

        return $options;
    }


    /** Attach Blog Category suggest widget initialization
     * @return string */
    public function getAfterElementHtml()
    {
        $html = '<script type="text/x-magento-init">
            {
                "*": {
                    "Magento_Ui/js/core/app": {
                        "components": {
                            "blogCategory": {
                                "component": "uiComponent",
                                "children": {
                                    "blog_select_category": {
                                        "component": "Magento_Ui/js/form/element/select",
                                        "config": {
                                            "filterOptions": true,
                                            "disableLabel": true,
                                            "chipsEnabled": true,
                                            "levelsVisibility": "1",
                                            "elementTmpl": "ui/form/element/select",
                                            "options": ' . json_encode($this->getCategoriesCollection()) . ',
                                            "value": ' . json_encode($this->getValues()) . ',
                                            "listens": {
                                                "index=create_category:responseData": "setParsed",
                                                "newOption": "toggleOptionSelected"
                                            },
                                            "config": {
                                                "dataScope": "blog_select_category",
                                                "sortOrder": 10
                                            }
                                        }
                                    }
                                }
                            },
                            "create_category_button": {
                                "title": "' . __('New Category') . '",
                                "formElement": "container",
                                "additionalClasses": "admin__field-small",
                                "componentType": "container",
                                "component": "Magento_Ui/js/form/components/button",
                                "template": "ui/form/components/button/container",
                                "actions": [
                                    {
                                        "targetName": "create_category_modal",
                                        "actionName": "toggleModal"
                                    },
                                    {
                                        "targetName": "create_category_modal.create_category",
                                        "actionName": "render"
                                    },
                                    {
                                        "targetName": "create_category_modal.create_category",
                                        "actionName": "resetForm"
                                    }
                                ],
                                "additionalForGroup": true,
                                "provider": false,
                                "source": "product_details",
                                "displayArea": "insideGroup"
                            },
                            "create_category_modal": {
                                "config": {
                                    "isTemplate": false,
                                    "componentType": "container",
                                    "component": "Magento_Ui/js/modal/modal-component",
                                    "options": {
                                        "title": "' . __('New Category') . '",
                                        "type": "slide"
                                    },
                                    "imports": {
                                        "state": "!index=create_category:responseStatus"
                                    }
                                },
                                "children": {
                                    "create_category": {
                                        "label": "",
                                        "componentType": "container",
                                        "component": "Magento_Ui/js/form/components/insert-form",
                                        "dataScope": "",
                                        "update_url": "' . $this->_urlBuilder->getUrl('mui/index/render') . '",
                                        "render_url": "' .
            $this->_urlBuilder->getUrl(
                'mui/index/render_handle',['handle'=>'brituy_simpleblog_category_create','buttons'=>1]) . '",
                                        "autoRender": false,
                                        "ns": "blog_new_category_form",
                                        "externalProvider": "blog_new_category_form.new_category_form_data_source",
                                        "toolbarContainer": "${ $.parentName }",
                                        "formSubmitType": "ajax"
                                    }
                                }
                            }
                        }
                    }
                }
            }
        </script>';

        return $html;
    }
}
