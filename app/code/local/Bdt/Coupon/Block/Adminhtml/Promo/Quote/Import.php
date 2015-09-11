<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Sphinx Search Ultimate
 * @version   2.3.2
 * @build     939
 * @copyright Copyright (C) 2014 Mirasvit (http://mirasvit.com/)
 */


/**
 * ÐÐ»Ð¾Ðº Ð¸Ð¼Ð¿Ð¾ÑÑÐ° ÑÐ¸Ð½Ð¾Ð½Ð¸Ð¼Ð¾Ð²
 *
 * @category Mirasvit
 * @package  Mirasvit_SearchSphinx
 */
class Bdt_Coupon_Block_Adminhtml_Promo_Quote_Import extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected $_buttomLabel = '';

    public function __construct ()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_promo_quote';
        $this->_mode       = 'import';
        $this->_blockGroup = 'coupon';

        $this->getDictionaries();

        $this->_updateButton('save', 'label', $this->getLabel());
        return $this;
    }

    public function getHeaderText ()
    {
        return Mage::helper('coupon')->__('Import Coupons');
    }
    protected function getDictionaries()
    {
        $values = array();
        $path   = Mage::getBaseDir('media').DS.'import'.DS.'coupon'.DS;
        if (file_exists($path)) {
            if ($handle = opendir($path)) {
                while (false !== ($entry = readdir($handle))) {
                    if (substr($entry, 0, 1) != '.' ) {
                        $r = pathinfo($entry);
                        if($r['extension'] == 'csv') {
                            $values[] = array(
                                'label' => $entry,
                                'value' => $path . DS . $entry
                            );
                        }
                    }
                }
                closedir($handle);
            }
            if (count($values) == 0) {
                $this->_buttomLabel = Mage::helper('coupon')->__('Save & Continue');
                return;
            }
        } else {
            $this->_buttomLabel = Mage::helper('coupon')->__('Save & Continue');
            return;
        }
        $this->_buttomLabel = Mage::helper('coupon')->__('Import Coupons');
        return;
    }

    public function getLabel(){
        return $this->_buttomLabel;
    }
}