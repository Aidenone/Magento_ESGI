<?php

namespace Baguette\Bakery\Controller\Adminhtml\Bakery;

use Magento\Backend\App\Action\Context;
use Baguette\Bakery\Model\Bakery;
use Baguette\Bakery\Model\BakeryFactory;
use Baguette\Bakery\Model\ResourceModel\Bakery as BakeryResourceModel;
use Baguette\Bakery\Api\BakeryRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Baguette\Bakery\Controller\Adminhtml\Bakery
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * Description $bakeryRepository field
     *
     * @var BakeryRepositoryInterface $bakeryRepository
     */
    protected $bakeryRepository;
    /**
     * Description $bakeryFactory field
     *
     * @var BakeryFactory $bakeryFactory
     */
    protected $bakeryFactory;
    /**
     * Description $bakeryResourceModel field
     *
     * @var BakeryResourceModel $bakeryResourceModel
     */
    protected $bakeryResourceModel;

    /**
     * Save constructor
     *
     * @param Context                       $context
     * @param \Magento\Framework\Registry   $coreRegistry
     * @param DataPersistorInterface        $dataPersistor
     * @param BakeryRepositoryInterface $bakeryRepository
     * @param BakeryFactory             $bakeryFactory
     * @param BakeryResourceModel       $bakeryResourceModel
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        BakeryRepositoryInterface $bakeryRepository,
        BakeryFactory $bakeryFactory,
        BakeryResourceModel $bakeryResourceModel
    ) {
        parent::__construct($context, $coreRegistry);

        $this->dataPersistor           = $dataPersistor;
        $this->bakeryRepository    = $bakeryRepository;
        $this->bakeryFactory       = $bakeryFactory;
        $this->bakeryResourceModel = $bakeryResourceModel;
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }

            /** @var Bakery $model */
            $model = $this->bakeryFactory->create();

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->bakeryRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This bakery no longer exists.'));

                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->bakeryRepository->save($model);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the bakery.'));
            }

            $this->dataPersistor->set('bakery_bakery', $data);

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}