<?php

namespace Baguette\Bakery\Block\Adminhtml\Bakery\Edit;
/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('bakery_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Bakery'));
    }
}