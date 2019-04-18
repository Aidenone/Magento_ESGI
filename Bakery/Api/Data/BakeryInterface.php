<?php

declare(strict_types=1);

namespace Baguette\Bakery\Api\Data;

/**
 * Baguette bakery interface.
 *
 * @api
 */
interface BakeryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'entity_id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const ADDRESS = 'address';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getTitle(): string;

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): string;

    /**
     * Get address
     *
     * @return string|null
     */
    public function getAddress(): string;

    /**
     * Set ID
     *
     * @param int $id
     *
     * @return BakeryInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $title
     *
     * @return BakeryInterface
     */
    public function setTitle(string $title): BakeryInterface;

    /**
     * Set description
     *
     * @param string $description
     *
     * @return DepartmentInterface
     */
    public function setDescription(string $content): BakeryInterface;

    /**
     * Set address
     *
     * @param string $address
     *
     * @return DepartmentInterface
     */
    public function setAddress(string $content): BakeryInterface;
}