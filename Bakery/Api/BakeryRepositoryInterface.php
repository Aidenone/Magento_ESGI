<?php

declare(strict_types=1);

namespace Baguette\Bakery\Api;

/**
 * Baguette bakery CRUD interface.
 * @api
 */
interface BakeryRepositoryInterface
{
    /**
     * Save block.
     *
     * @param \Baguette\Bakery\Api\Data\BakeryInterface $bakery
     * @return \Baguette\Bakery\Api\Data\BakeryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\BakeryInterface $bakery);

    /**
     * Retrieve $bakery.
     *
     * @param int $bakeryId
     * @return \Baguette\Bakery\Api\Data\BakeryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($bakeryId);

    /**
     * Retrieve bakerys matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Baguette\Bakery\Api\Data\BakerySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete bakery.
     *
     * @param \Baguette\Bakery\Api\Data\BakeryInterface $bakery
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\BakeryInterface $bakery);

    /**
     * Delete bakery by ID.
     *
     * @param int $bakeryId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($bakeryId);
}