<?php

declare(strict_types=1);

namespace Baguette\Bakery\Model;

use Baguette\Bakery\Api\Data\BakeryInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Baguette\Bakery\Model\ResourceModel\Bakery as BakeryResourceModel;

class Bakery extends AbstractModel implements BakeryInterface, IdentityInterface
{
    /**
     * Esgi Job department cache tag
     */
    const CACHE_TAG = 'baguette_bakery_b';

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'esgi_job';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'department';

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(BakeryResourceModel::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Retrieve department id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Retrieve department name
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Retrieve bakery description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Retrieve bakery address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return BakeryInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Set name
     *
     * @param string $title
     * @return BakeryInterface
     */
    public function setTitle(string $title): BakeryInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $description
     * @return BakeryInterface
     */
    public function setDescription(string $description): BakeryInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Set address
     *
     * @param string $address
     * @return BakeryInterface
     */
    public function setAddress(string $address): BakeryInterface
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Description beforeSave function
     *
     * @return AbstractModel
     */
    public function beforeSave(): AbstractModel
    {
        if ($this->hasDataChanges()) {
            $this->setUpdateTime(null);
        }

        return parent::beforeSave();
    }

    public function getProducts(\Baguette\Bakery\Model\Bakery $object)
    {
        $tbl = $this->getResource()->getTable(\Baguette\Bakery\Model\ResourceModel\Bakery::TBL_ATT_PRODUCT);

        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['product_id']
        )
            ->where(
                'bakery_id = ?',
                (int)$object->getId()
            );
        return $this->getResource()->getConnection()->fetchCol($select);
    }
}