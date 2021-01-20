<?php
namespace Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Renderer;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Select;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Authors\Collection;
use Brituy\SimpleBlog\Model\ResourceModel\Authors\CollectionFactory as AuthorsCollectionFactory;

/**
 * Class Authors
 * @package Brituy\SimpleBlog\Block\Adminhtml\Blog\Edit\Renderer
 */
class Author extends Select
{
    /** @var CategoriesCollectionFactory */
    public $authorsCollectionFactory;

    /** @var UrlInterface */
    protected $_urlBuilder;

    /** Author constructor.
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param AuthorsCollectionFactory $authorsCollectionFactory
     * @param AuthorizationInterface $authorization
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryElementCollection,
        Escaper $escaper,
        AuthorsCollectionFactory $authorsCollectionFactory,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->AuthorsCollectionFactory = $authorsCollectionFactory;
        $this->_urlBuilder = $urlBuilder;

        parent::__construct($factoryElement, $factoryElementCollection, $escaper, $data);
    }

    /** @inheritdoc */
    public function getElementHtml()
    {
        $html = '<div class="admin__field-control admin__control-grouped">';
        $html .= '<div id="blog-author-select" class="admin__field" data-bind="scope:\'blogAuthor\'" data-index="index">';
        $html .= '<!-- ko foreach: elems() -->';
        $html .= '<input name="blog[author_id]" data-bind="value: value" style="display: none"/>';
        $html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
        $html .= '<!-- /ko -->';
        $html .= '</div>';

        $html .= '<div class="admin__field admin__field-group-additional admin__field-small"'
            . 'data-bind="scope:\'create_author_button\'">';
        $html .= '<div class="admin__field-control">';
        $html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
        $html .= '</div></div></div>';

        $html .= '<!-- ko scope: \'create_author_modal\' --><!-- ko template: getTemplate() --><!-- /ko --><!-- /ko -->';

        $html .= $this->getAfterElementHtml();

        return $html;
    }

    public function getAuthorsCollection()
    {
        /* @var $collection Collection */
        $collection = $this->AuthorsCollectionFactory->create();
        $authorById = [];
        $authorById[0]['value'] = 'none';
        $authorById[0]['label'] = 'Please select';
        foreach ($collection as $author) {
            $authorById[$author->getId()]['value'] = $author->getId();
            $authorById[$author->getId()]['label'] = $author->getAuthor();
        }

        return $authorById;
    }

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
        $collection = $this->AuthorsCollectionFactory->create();

        $options = [];
        foreach ($collection as $author) {
            $options[] = $author->getId();
        }

        return $options;
    }


    /** Attach Blog author suggest widget initialization
     * @return string */
    public function getAfterElementHtml()
    {
        $html = '<script type="text/x-magento-init">
            {
                "*": {
                    "Magento_Ui/js/core/app": {
                        "components": {
                            "blogAuthor": {
                                "component": "uiComponent",
                                "children": {
                                    "blog_select_author": {
                                        "component": "Magento_Ui/js/form/element/select",
                                        "config": {
                                            "filterOptions": true,
                                            "disableLabel": true,
                                            "chipsEnabled": true,
                                            "levelsVisibility": "1",
                                            "elementTmpl": "ui/form/element/select",
                                            "options": ' . json_encode($this->getAuthorsCollection()) . ',
                                            "value": ' . json_encode($this->getValues()) . ',
                                            "listens": {
                                                "index=create_author:responseData": "setParsed",
                                                "newOption": "toggleOptionSelected"
                                            },
                                            "config": {
                                                "dataScope": "blog_select_author",
                                                "sortOrder": 10
                                            }
                                        }
                                    }
                                }
                            },
                            "create_author_button": {
                                "title": "' . __('New Author') . '",
                                "formElement": "container",
                                "additionalClasses": "admin__field-small",
                                "componentType": "container",
                                "component": "Magento_Ui/js/form/components/button",
                                "template": "ui/form/components/button/container",
                                "actions": [
                                    {
                                        "targetName": "create_author_modal",
                                        "actionName": "toggleModal"
                                    },
                                    {
                                        "targetName": "create_author_modal.create_author",
                                        "actionName": "render"
                                    },
                                    {
                                        "targetName": "create_author_modal.create_author",
                                        "actionName": "resetForm"
                                    }
                                ],
                                "additionalForGroup": true,
                                "provider": false,
                                "source": "product_details",
                                "displayArea": "insideGroup"
                            },
                            "create_author_modal": {
                                "config": {
                                    "isTemplate": false,
                                    "componentType": "container",
                                    "component": "Magento_Ui/js/modal/modal-component",
                                    "options": {
                                        "title": "' . __('New Author') . '",
                                        "type": "slide"
                                    },
                                    "imports": {
                                        "state": "!index=create_author:responseStatus"
                                    }
                                },
                                "children": {
                                    "create_author": {
                                        "label": "",
                                        "componentType": "container",
                                        "component": "Magento_Ui/js/form/components/insert-form",
                                        "dataScope": "",
                                        "update_url": "' . $this->_urlBuilder->getUrl('mui/index/render') . '",
                                        "render_url": "' .
            $this->_urlBuilder->getUrl(
                'mui/index/render_handle',
                [
                    'handle' => 'brituy_simpleblog_author_create',
                    'buttons' => 1
                ]
            ) . '",
                                        "autoRender": false,
                                        "ns": "blog_new_author_form",
                                        "externalProvider": "blog_new_author_form.new_author_form_data_source",
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
