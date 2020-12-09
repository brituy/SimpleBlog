<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Post\Edit\Tab\Renderer;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Multiselect;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Authors\Collection;
use Brituy\SimpleBlog\Model\ResourceModel\Authors\CollectionFactory as BlogAuthorsCollectionFactory;

/** Class Authors
 * @package Brituy\SimpleBlog\Block\Adminhtml\Post\Edit\Tab\Renderer */
class Authors extends Multiselect
{
    /** @var BlogAuthorsCollectionFactory */
    public $collectionFactory;

    /** @var UrlInterface */
    protected $_urlBuilder;

    /** Tag constructor.
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param BlogAuthorsCollectionFactory $collectionFactory
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        BlogAuthorsCollectionFactory $collectionFactory,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_urlBuilder = $urlBuilder;

        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
    }

    /** @inheritdoc */
    public function getElementHtml()
    {
        $html = '<div class="admin__field-control admin__control-grouped">';
        $html .= '<div id="blog-authors-select" class="admin__field" data-bind="scope:\'blogAuthors\'" data-index="index">';
        $html .= '<!-- ko foreach: elems() -->';
        $html .= '<input name="post[authors_ids]" data-bind="value: value" style="display: none"/>';
        $html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
        $html .= '<!-- /ko -->';
        $html .= '</div>';

        $html .= '<div class="admin__field admin__field-group-additional admin__field-small"'
            . 'data-bind="scope:\'create_authors_button\'">';
        $html .= '<div class="admin__field-control">';
        $html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
        $html .= '</div></div></div>';

        $html .= '<!-- ko scope: \'create_authors_modal\' --><!-- ko template: getTemplate() --><!-- /ko --><!-- /ko -->';

        $html .= $this->getAfterElementHtml();

        return $html;
    }

    /** @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getAuthorsCollection();
    }

    /** @return mixed */
    public function getAuthorsCollection()
    {
        /* @var $collection Collection */
        $collection = $this->collectionFactory->create();
        $authorsById = [];
        foreach ($collection as $authors) {
            $authorsById[$authors->getId()]['value'] = $authors->getAuthorId();
            $authorsById[$authors->getId()]['label'] = $authors->getAuthor();
        }

        return $authorsById;
    }

    /** Get values for select
     * @return array */
    public function getValues()
    {
        $values = $this->getValue();

        if (!is_array($values)) {
            $values = explode(',', $values);
        }

        if (!count($values)) {
            return [];
        }

        /* @var $collection Collection */
        $collection = $this->collectionFactory->create()
            ->addIdFilter($values);

        $options = [];
        foreach ($collection as $authors) {
            $options[] = $authors->getId();
        }

        return $options;
    }

    /** Attach Blog Authors suggest widget initialization
     * @return string */
    public function getAfterElementHtml()
    {
        $html = '<script type="text/x-magento-init">
            {
                "*": {
                    "Magento_Ui/js/core/app": {
                        "components": {
                            "blogAuthors": {
                                "component": "uiComponent",
                                "children": {
                                    "blog_select_authors": {
                                        "component": "Brituy_SimpleBlog/js/components/new-category",
                                        "config": {
                                            "filterOptions": true,
                                            "disableLabel": true,
                                            "chipsEnabled": true,
                                            "levelsVisibility": "1",
                                            "elementTmpl": "ui/grid/filters/elements/ui-select",
                                            "options": ' . json_encode($this->getAuthorsCollection()) . ',
                                            "value": ' . json_encode($this->getValues()) . ',
                                            "listens": {
                                                "index=create_tag:responseData": "setParsed",
                                                "newOption": "toggleOptionSelected"
                                            },
                                            "config": {
                                                "dataScope": "blog_select_authors",
                                                "sortOrder": 10
                                            }
                                        }
                                    }
                                }
                            },
                            "create_tag_button": {
                                "title": "' . __('New Author') . '",
                                "formElement": "container",
                                "additionalClasses": "admin__field-small",
                                "componentType": "container",
                                "component": "Magento_Ui/js/form/components/button",
                                "template": "ui/form/components/button/container",
                                "actions": [
                                    {
                                        "targetName": "create_authors_modal",
                                        "actionName": "toggleModal"
                                    },
                                    {
                                        "targetName": "create_authors_modal.create_authors",
                                        "actionName": "render"
                                    },
                                    {
                                        "targetName": "create_authors_modal.create_authors",
                                        "actionName": "resetForm"
                                    }
                                ],
                                "additionalForGroup": true,
                                "provider": false,
                                "source": "product_details",
                                "displayArea": "insideGroup"
                            },
                            "create_authors_modal": {
                                "config": {
                                    "isTemplate": false,
                                    "componentType": "container",
                                    "component": "Magento_Ui/js/modal/modal-component",
                                    "options": {
                                        "title": "' . __('New Author') . '",
                                        "type": "slide"
                                    },
                                    "imports": {
                                        "state": "!index=create_authors:responseStatus"
                                    }
                                },
                                "children": {
                                    "create_authors": {
                                        "label": "",
                                        "componentType": "container",
                                        "component": "Magento_Ui/js/form/components/insert-form",
                                        "dataScope": "",
                                        "update_url": "' . $this->_urlBuilder->getUrl('mui/index/render') . '",
                                        "render_url": "' .
            $this->_urlBuilder->getUrl(
                'mui/index/render_handle',
                [
                    'handle' => 'brituy_blog_authors_create',
                    'buttons' => 1
                ]
            ) . '",
                                        "autoRender": false,
                                        "ns": "blog_new_authors_form",
                                        "externalProvider": "blog_new_authors_form.new_authors_form_data_source",
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
