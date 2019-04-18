<?php

declare(strict_types=1);

namespace Baguette\Bakery\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for job bakery search results.
 * @api
 */
interface BakerySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get departments list.
     *
     * @return \Baguette\Bakery\Api\Data\BakeryInterface[]
     */
    public function getItems();

    /**
     * Set bakeries list.
     *
     * @param \Baguette\Bakery\Api\Data\BakeryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}