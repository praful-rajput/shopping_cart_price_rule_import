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
 * Ð¤Ð¾ÑÐ¼Ð° Ð¸Ð¼Ð¿Ð¾ÑÑÐ° ÑÐ¸Ð½Ð¾Ð½Ð¸Ð¼Ð¾Ð²
 *
 * @category Mirasvit
 * @package  Mirasvit_SearchSphinx
 */
class Bdt_Coupon_Block_Adminhtml_Promo_Quote_Import_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {

        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getData('action'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $fieldset = $form->addFieldset('general', array('legend' => Mage::helper('coupon')->__('Import')));
        
        $dictionaries = $this->getDictionaries();
        if (!is_array($dictionaries)) {
            $fieldset->addField('label', 'label', array(
                'value' =>  '',
                'note' => $dictionaries,
            ));
            $fieldset->addField('file', 'file', array(
                'name'     => 'file',
                'label'    => Mage::helper('coupon')->__('File'),
                'value' =>  '',
                'note' => 'Please upload CSV file.',
            ));
        } else {
            $fieldset->addField('file', 'select', array(
                'name'     => 'file',
                'label'    => Mage::helper('coupon')->__('File'),
                'required' => true,
                'values'   => $dictionaries,
            ));
        }



        $form->setAction($this->getUrl('*/*/massImport'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
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
                $values = "Can't find any files in folder $path";
               // $values = "<div id='messages'><ul class='messages'><li class='success-msg'><ul><li><span>Cant find any files in folder $path</span></li></ul></li></ul></div>";
            }
        } else {
            $values = "Can't find folder $path";
        }

        return $values;
    }

    public function __construct()
    {
        parent::__construct();
        $this->setId('promo_quote_form');
        $this->setTitle(Mage::helper('salesrule')->__('Rule Information'));
    }


}