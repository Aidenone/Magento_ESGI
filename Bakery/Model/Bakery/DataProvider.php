<?php

namespace Baguette\Bakery\Model\Bakery;

use Baguette\Bakery\Model\ResourceModel\Bakery\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Baguette\Bakery\Model\ResourceModel\Bakery\Collection
     */
    protected $collection;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string                 $name
     * @param string                 $primaryFieldName
     * @param string                 $requestFieldName
     * @param CollectionFactory      $bakeryCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array                  $meta
     * @param array                  $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bakeryCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection    = $bakeryCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Baguette\Bakery\Model\Bakery $bakery */
        foreach ($items as $bakery) {
            $this->loadedData[$bakery->getId()] = $bakery->getData();
        }

        $data = $this->dataPersistor->get('bakery_bakery');

        if (!empty($data)) {
            $bakery = $this->collection->getNewEmptyItem();
            $bakery->setData($data);
            $this->loadedData[$bakery->getId()] = $bakery->getData();
            $this->dataPersistor->clear('bakery_bakery');
        }

        return $this->loadedData;
    }
}