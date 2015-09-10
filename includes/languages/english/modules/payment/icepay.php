<?php
/*
  $Id: icepay.php, v2.0 2008/11/11 19:35:49

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008-2009 osCommerce

  Released under the GNU General Public License
*/

if (!defined('DIR_WS_HTTP_CATALOG')) include("../includes/configure.php");

define('MODULE_PAYMENT_ICEPAY_TEXT_TITLE', 'Online Payment with ICEPAY');

define('MODULE_PAYMENT_ICEPAY_TEXT_DESCRIPTION', @"
	<img src='images/icon_info.gif' border='0'>&nbsp;<b>ICEPAY module for osCommerce</b><br />
	<br />
	<img src='images/icon_popup.gif' border='0'>&nbsp;<a href='http://www.icepay.eu' target='_blank' style='text-decoration: underline; font-weight: bold'>Visit ICEPAY website</a>
");

define('MODULE_PAYMENT_ICEPAY_SUBMODULE_DESCRIPTION', 'The main ICEPAY module must be installed (does not have to be active) to use this payment method.');

define('MODULE_PAYMENT_ICEPAY_NAVBAR_TITLE_ERROR', 'Error');
define('MODULE_PAYMENT_ICEPAY_TEXT_ERROR', 'Error!');
define('MODULE_PAYMENT_ICEPAY_TEXT_ERROR_MESSAGE', 'There has been an error processing your payment. Please try again.');

define('EMAIL_TEXT_SUBJECT_OK', 'Payment received');
define('EMAIL_TEXT_SUBJECT_OK_INFO', 'The payment for your order has been received.');
define('EMAIL_TEXT_SUBJECT_OPEN', 'Order Process');
define('EMAIL_TEXT_SUBJECT_OPEN_INFO', 'The order has been placed and awaiting payment verification. You will receive an e-mail when payment has been completed or you can track the status of your order on our site.');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_COMMENTS', 'Remarks');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_PRODUCTS', 'Products');
define('EMAIL_TEXT_SUBTOTAL', 'Sub-Total:');
define('EMAIL_TEXT_TAX', 'Tax:        ');
define('EMAIL_TEXT_SHIPPING', 'Shipping: ');
define('EMAIL_TEXT_TOTAL', 'Total:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Delivery Address');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Billing Address');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Payment Method');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'via');

?>