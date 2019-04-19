<?php

namespace Baguette\Bakery\Controller\Adminhtml\Bakery
;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\TestFramework\ErrorLog\Logger;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;
    /**
     * @var \Baguette\Bakery\Model\ResourceModel\Bakery\CollectionFactory
     */
    protected $_bakeryCollectionFactory;
    /**
     * \Magento\Backend\Helper\Js $jsHelper
     * @param Action\Context $context
     */
    public function __construct(
        Context $context,
        \Magento\Backend\Helper\Js $jsHelper,
        \Baguette\Bakery\Model\ResourceModel\Bakery\CollectionFactory $bakeryCollectionFactory
    ) {
        $this->_jsHelper = $jsHelper;
        $this->_bakeryCollectionFactory = $bakeryCollectionFactory;
        parent::__construct($context);
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Baguette\Bakery\Model\Bakery $model */
            $model = $this->_objectManager->create('Baguette\Bakery\Model\Bakery');
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
            $temp_data = $data;
            if(isset($temp_data['products']))
                unset($temp_data['products']);
            $model->setData($temp_data);
            try {
                $model->save();
                $this->saveProducts($model, $data);
                $this->messageManager->addSuccess(__('You saved this bakery.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['bakery_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the bakery THIS.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['bakery_id' => $this->getRequest()->getParam('bakery_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    public function saveProducts($model, $post)
    {
        // Attach the attachments to bakery
        if (!isset($post['products'])) {
            $post['products'] = "";
        }
        $productIds = $this->_jsHelper->decodeGridSerializedInput($post['products']);
        try {
            $oldProducts = (array) $model->getProducts($model);
            $newProducts = (array) $productIds;
            $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
            $connection = $this->_resources->getConnection();
            $table = $this->_resources->getTableName(\Baguette\Bakery\Model\ResourceModel\Bakery::TBL_ATT_PRODUCT);
            $insert = array_diff($newProducts, $oldProducts);
            $delete = array_diff($oldProducts, $newProducts);
            if ($delete) {
                $where = ['bakery_id = ?' => (int)$model->getId(), 'product_id IN (?)' => $delete];
                $connection->delete($table, $where);
            }
            if ($insert) {
                $data = [];
                foreach ($insert as $product_id) {
                    $data[] = ['bakery_id' => (int)$model->getId(), 'product_id' => (int)$product_id];
                }
                $connection->insertMultiple($table, $data);
            }
        } catch (Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while saving the bakery.'));
        }

    }
}