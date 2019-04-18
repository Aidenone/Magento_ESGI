<?php

declare(strict_types=1);

namespace Baguette\Bakery\Model\ResourceModel\Bakery;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Baguette\Bakery\Model\Bakery;
use Baguette\Bakery\Model\ResourceModel\Bakery as BakeryResourceModel;

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
        $this->_init(Bakery::class, BakeryResourceModel::class);
    }
}