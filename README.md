# shopping_cart_price_rule_import

<summary>Quick and easy solution for importing custom coupon codes in Magento&amp;lt;br&amp;gt;&#xD;
Import hundreds of coupon at once with your shopping cart price rules&amp;lt;br&amp;gt;&#xD;
Simplt create CSV as in given format.&#xD;
Import coupons as well as shopping cart price rules with all conditions provide by Magento&amp;lt;br&amp;gt;&#xD;
Import an unlimited amount of coupon codes in easiest way.</summary>
    <description>&amp;lt;h3&amp;gt;Bulk import custom Magento coupons &amp;amp; shopping cart price rules with easy&amp;lt;/h3&amp;gt;&#xD;
&#xD;
&amp;lt;p&amp;gt;Our Coupon Import extension for Magento provides a &amp;lt;strong&amp;gt;simple and quick solution for importing custom coupon codes with shopping cart price rules.&amp;lt;/strong&amp;gt; &amp;lt;br&amp;gt;&amp;lt;br&amp;gt; &#xD;
&#xD;
Maybe you&amp;apos;d like to import coupons received for marketing campaigns or other purpose. With Coupon Import for Magento you can bulk upload your custom coupons in a less time, whether it&amp;apos;s just a couple or thousands coupons at once!&amp;lt;/p&amp;gt;&#xD;
&#xD;
&amp;lt;h3&amp;gt;Upload thousands of coupon codes in a snap&amp;lt;/h3&amp;gt;&#xD;
&#xD;
&amp;lt;p&amp;gt;Coupon Import for Magento offers two ways of bulk importing your custom coupons in your shopping cart price rule.&amp;lt;br&amp;gt;&amp;lt;br&amp;gt;&#xD;
&#xD;
All your import CSV file will uploaded under /media/import/coupon/&#xD;
Once you will import that CSV file it will move to archives with rename it prefix by [ymd]_coupon.csv under /media/import/coupon/archives/ymd_coupon.csv for your future backup or reused.&#xD;
&#xD;
Shopping Cart Price Rules grid have field to display no. of usage of coupons.&#xD;
&#xD;
&amp;lt;h3&amp;gt;Export&amp;lt;/h3&amp;gt;&#xD;
We have implemented default grid export functionality to Shopping Cart Price Rules.&#xD;
So, this export csv file field names will be change. So do not use exported CSV file directly to import.&#xD;
You have to refer sample coupon CSV format for import. You will found it under /media/import/coupon/sample_coupon.csv&#xD;
Below are some of field explanation with their values.&#xD;
&#xD;
rule_name	: Specify rule name&#xD;
description	: Specify rule description&#xD;
status		: 0 for Inactive, 1 for Active&#xD;
customer_group	: Customer Group Id, if more than one group then put comma separated  value. eg. 1,2,3&#xD;
coupon_code		: coupon code (numeric or Alphanumeric)&#xD;
from_date		: Date should be in format like 7/20/2015&#xD;
to_date			: Date should be in format like 7/30/2015&#xD;
discount_type	: the value should be by_percent, cart_fixed, by_fixed.&#xD;
discount_amount	: If you selected by_percent then value no more than 100.&#xD;
user_per_coupon	: Number of user per coupon&#xD;
stop_rules_processing	: 0 for No, 1 for Yes	&#xD;
uses_per_customer		: No. of usage per coupon&#xD;
simple_free_shipping	: 0 for No, 1 for Yes&#xD;
website					: Mention website id. If more than one then put comma separated value. e.g. 1,2,3&#xD;
discount_qty			: If you selected discount_type as by_fixed then you have to set this value otherwise it will apply each qty of cart item.</description>
