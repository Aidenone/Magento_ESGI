<?php

declare(strict_types=1);

namespace Baguette\Bakery\Model\ResourceModel\Bakery;

use Magento\Catalog\Model\Product;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Catalog\Model\ResourceModel\Product as ProductResourceModel;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Product::class, ProductResourceModel::class);
    }
}