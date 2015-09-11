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
 * ÐÐ¾Ð´ÐµÐ»Ñ Ð´Ð»Ñ ÑÐ°Ð±Ð¾ÑÑ Ñ ÑÐ¸Ð½Ð¾Ð½Ð¸Ð¼Ð°Ð¼Ð¸
 *
 * @category Mirasvit
 * @package  Mirasvit_SearchSphinx
 */
class Bdt_Coupon_Model_Coupon extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('coupon/coupon');
    }

    public function import($filename){
        try{
            if(file_exists($filename)){
                $fp = fopen($filename,'r') or die("can't open file");
                $count = 0;
                $countNotImpt = 0;
                $i = 0;
                $fields = array_flip(fgetcsv($fp,1024,","));

                while($csv_line = fgetcsv($fp,1024,",")) {
                    if($csv_line[$fields['status']] == 1) {
                        $options['rule_name'] = $rulename = $csv_line[$fields['rule_name']];
                        $options['description'] =$desc = $csv_line[$fields['description']];
                        $options['status'] =$status = $csv_line[$fields['status']];
                        $options['customer_group'] =$customerGroups = $csv_line[$fields['customer_group']];
                        $options['coupon_code'] =$couponCode = $csv_line[$fields['coupon_code']];
                        $options['from_date'] =$fromDate = $csv_line[$fields['from_date']];
                        $options['to_date'] =$toDate = $csv_line[$fields['to_date']];
                        $options['discount_type'] =$discountType = $csv_line[$fields['discount_type']];
                        $options['discount_amount'] =$discountAmount = $csv_line[$fields['discount_amount']];
                        $options['user_per_coupon'] =$userPerCoupon = $csv_line[$fields['user_per_coupon']];
                        $options['stop_rules_processing'] =$stopRulesProcessing = $csv_line[$fields['stop_rules_processing']];
                        $options['uses_per_customer'] =$usesPerCustomer = $csv_line[$fields['uses_per_customer']];
                        $options['simple_free_shipping'] =$simpleFreeShipping = $csv_line[$fields['simple_free_shipping']];
                        $options['website'] =$simpleFreeShipping = $csv_line[$fields['website']];
                        $options['discount_qty'] = ($csv_line[$fields['discount_qty']] > 0) ? $csv_line[$fields['discount_qty']] : 0;
                        if($this->generateRule($options)) {
                            $count++;
                        }
                        else{
                            $countNotImpt++;
                        }
                    }
                    $i++;
                }
                fclose($fp) or die("can't close file");

                $message['count']= $count;
                $message['countNotImpt']= $countNotImpt;

                $archives = Mage::getBaseDir('media'). DS . 'import' . DS . 'coupon' . DS . 'archives' . DS . date('ymd').'_coupon.csv';
                copy($filename, $archives) or die("can't move file");

                unlink($filename) or die("can't delete file");

            }else{
                echo $filename . '<br/>File is not available.';
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }

        return $message;
    }

    public function generateRule($options){

        $couponCheck = Mage::getModel('salesrule/rule')->getCollection()
                                                       ->addFieldToFilter('code',$options['coupon_code'])
                                                        ->load();
        $couponCheckArr = $couponCheck->getData();
        if(count($couponCheckArr)>0) {
            return false;
        }
        $rule = Mage::getModel('salesrule/rule');
        $rule->setName($options['rule_name']);
        $rule->setDescription($options['description']);
        $rule->setFromDate($options['from_date']);//starting today
        if($options['from_date'] !="") {
            $rule->setToDate($options['from_date']);//if you need an expiration date
        }
        $rule->setCouponCode($options['coupon_code']);
        $rule->setUsesPerCoupon($options['user_per_coupon']);//number of allowed uses for this coupon
        $rule->setUsesPerCustomer($options['uses_per_customer']);//number of allowed uses for this coupon for each customer
        $customerGroups = explode(',',$options['customer_group']);
        $rule->setCustomerGroupIds($customerGroups);//if you want only certain groups replace getAllCustomerGroups() with an array of desired ids
        $rule->setIsActive($options['status']);
        $rule->setStopRulesProcessing($options['stop_rules_processing']);//set to 1 if you want all other rules after this to not be processed
        $rule->setIsRss(0);//set to 1 if you want this rule to be public in rss
        $rule->setIsAdvanced(1);//have no idea what it means :)
        $rule->setProductIds('');
        $rule->setSortOrder(0);// order in which the rules will be applied
        $rule->setSimpleAction($options['discount_type']);
        $rule->setDiscountAmount($options['discount_amount']);//the discount amount/percent. if SimpleAction is by_percent this value must be <= 100
        $rule->setDiscountQty($options['discount_qty']);//Maximum Qty Discount is Applied to
        $rule->setDiscountStep(0);//used for buy_x_get_y; This is X
        $rule->setSimpleFreeShipping($options['simple_free_shipping']);//set to 1 for Free shipping
        $rule->setApplyToShipping(0);//set to 0 if you don't want the rule to be applied to shipping
        $websites = explode(',',$options['website']);
        $rule->setWebsiteIds($websites);//if you want only certain websites replace getAllWbsites() with an array of desired ids

        $conditions = array();
        $conditions[1] = array(
            'type' => 'salesrule/rule_condition_combine',
            'aggregator' => 'all',
            'value' => 1,
            'new_child' => ''
        );

        $rule->setData('conditions',$conditions);
        $rule->loadPost($rule->getData());
        $rule->setCouponType(2); // No Coupon=>1, Specific Coupon=>2, Auto=>3
        if($rule->save()) {

            return true;
        }
        else {
            return false;
        }
    }
}