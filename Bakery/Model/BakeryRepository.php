<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Baguette\Bakery\Model;

use Baguette\Bakery\Api\BakeryRepositoryInterface;
use Baguette\Bakery\Api\Data;
use Baguette\Bakery\Model\ResourceModel\Bakery as BakeryResource;
use Baguette\Bakery\Model\BakeryFactory;
use Baguette\Bakery\Model\ResourceModel\Bakery\CollectionFactory as BakeryCollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class BlockRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BakeryRepository implements BakeryRepositoryInterface
{
    /**
     * @var BakeryResource
     */
    protected $resource;

    /**
     * @var BakeryFactory
     */
    protected $bakeryFactory;

    /**
     * @var BakeryCollectionFactory
     */
    protected $bakeryCollectionFactory;

    /**
     * @var Data\BakerySearchResultsInterface
     */
    protected $searchResultsFactory;

    /**
     * @param BakeryResource $resource
     * @param BakeryFactory $bakeryFactory
     * @param BakeryCollectionFactory $bakeryCollectionFactory
     * @param Data\BakerySearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        BakeryResource $resource,
        BakeryFactory $bakeryFactory,
        \Baguette\Bakery\Api\Data\BakeryInterfaceFactory $dataBakeryFactory,
        BakeryCollectionFactory $bakeryCollectionFactory,
        Data\BakerySearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->bakeryFactory = $bakeryFactory;
        $this->bakeryCollectionFactory = $bakeryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save Bakery data
     *
     * @param \Baguette\Bakery\Api\Data\BakeryInterface $bakery
     * @return Bakery
     * @throws CouldNotSaveException
     */
    public function save(Data\BakeryInterface $bakery)
    {
        try {
            $this->resource->save($bakery);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $bakery;
    }

    /**
     * Load Bakery data by given Bakery Identity
     *
     * @param string $bakeryId
     * @return Bakery
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($bakeryId)
    {
        $bakery = $this->bakeryFactory->create();
        $this->resource->load($bakery, $bakeryId);
        if (!$bakery->getId()) {
            throw new NoSuchEntityException(__('Bakery with id "%1" does not exist.', $bakery));
        }

        return $bakery;
    }

    /**
     * Load Bakery data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Baguette\Bakery\Api\Data\BakerySearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Baguette\Bakery\Model\ResourceModel\Bakery\Collection $collection */
        $collection = $this->bakeryCollectionFactory->create();

        /** @var Data\BakerySearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete Bakery
     *
     * @param \Baguette\Bakery\Api\Data\BakeryInterface $bakery
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\BakeryInterface $bakery)
    {
        try {
            $this->resource->delete($bakery);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete Bakery by given Bakery Identity
     *
     * @param string $bakeryId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($bakeryId)
    {
        return $this->delete($this->getById($bakeryId));
    }
}