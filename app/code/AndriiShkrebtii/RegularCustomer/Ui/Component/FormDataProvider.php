<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Ui\Component;

class FormDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * DiscountFormDataProvider constructor.
     * @param \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory,
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $discountRequestCollectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        $data = [];

        foreach (parent::getData()['items'] as $item) {
            $data[$item['customer_request_id']] = $item;
        }

        return $data;
    }
}
