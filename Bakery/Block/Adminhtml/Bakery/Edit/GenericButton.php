<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Baguette\Bakery\Block\Adminhtml\Bakery\Edit;

use Magento\Backend\Block\Widget\Context;
use Baguette\Bakery\Api\BakeryRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var BakeryRepositoryInterface
     */
    protected $bakeryRepository;

    /**
     * @param Context $context
     * @param BakeryRepositoryInterface $bakeryRepository
     */
    public function __construct(
        Context $context,
        BakeryRepositoryInterface $bakeryRepository
    ) {
        $this->context          = $context;
        $this->bakeryRepository = $bakeryRepository;
    }

    /**
     * Return Bakery bakery ID
     *
     * @return int|null
     */
    public function getBakeryId()
    {
        try {
            return $this->bakeryRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}