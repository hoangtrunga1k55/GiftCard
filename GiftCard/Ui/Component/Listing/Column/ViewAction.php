<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mageplaza\GiftCard\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class ViewAction
 */
class ViewAction extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
//        if (isset($dataSource['data']['items'])) {
//            foreach ($dataSource['data']['items'] as & $item) {
//                if (isset($item['giftcard_id'])) {
//                    $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
//                    $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'giftcard_id';
//                    $item[$this->getData('name')] = [
//                        'view' => [
//                            'href' => $this->urlBuilder->getUrl(
//                                $viewUrlPath,
//                                [
//                                    $urlEntityParamName => $item['giftcard_id']
//                                ]
//                            ),
//                            'label' => __('Edit')
//                        ]
//                    ];
//                }
//            }
//        }

        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                $id = "X";
                if (isset($item["giftcard_id"])) {
                    $id = $item["giftcard_id"];
                }
                $item[$name]["view"] = [
                    "href"  => $this->getContext()->getUrl(
                        "giftcard/code/editpage",
                        ["id" => $id]
                    ),
                    "label" => __("Edit"),
                ];
            }
        }

        return $dataSource;
    }
}
