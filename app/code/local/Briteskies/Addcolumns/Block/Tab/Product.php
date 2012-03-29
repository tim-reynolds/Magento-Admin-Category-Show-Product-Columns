<?php

class Briteskies_Addcolumns_Block_Tab_Product extends Mage_Adminhtml_Block_Catalog_Category_Tab_Product {

    protected function _prepareCollection(){
        //This is to prevent calling load on the collection in
        //adminhtml/widget_grid->_prepareCollection()
        $temp_export = $this->_isExport;
        $this->_isExport = true;
        $temp = parent::_prepareCollection();
        $this->getCollection()->addAttributeToSelect('visibility');

        $this->_isExport = $temp_export;
        if(!$this->_isExport){
            $this->getCollection()->load();
            $this->_afterLoadCollection();
        }

        return $temp;
    }

    protected function _prepareColumns(){
        $temp = parent::_prepareColumns();
        $this->addColumn('type',
            array(
                'header' => Mage::helper('catalog')->__('Type'),
                'width' => '60px',
                'index' => 'type_id',
                'type' => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
            ));
        $this->addColumn('visibility',
            array(
                'header' => Mage::helper('catalog')->__('Visibility'),
                'width' => '70px',
                'index' => 'visibility',
                'type' => 'options',
                'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
            ));
        return $temp;
    }
}