<?php

declare(strict_types=1);

namespace Baguette\Bakery\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Bakery extends AbstractDb
{

    const TBL_ATT_PRODUCT = 'baguette_bakery_bakery_product';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        // Table Name and Primary Key column
        $this->_init('baguette_bakery_bakery', 'entity_id');
    }
}