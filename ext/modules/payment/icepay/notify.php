<?php

/*
#################################################################
#                                                             	#
#	The property of ICEPAY www.icepay.eu                      	#
#                                                             	#
#   The merchant is entitled to change de ICEPAY plug-in code,	#
#	any changes will be at merchant's own risk.					#
#	Requesting ICEPAY support for a modified plug-in will be	#
#	charged in accordance with the standard ICEPAY tariffs.		#
#                                                             	#
#################################################################

	osCommerce, Open Source E-Commerce Solutions
	http://www.oscommerce.com
	Copyright (c) 2008 osCommerce
	Released under the GNU General Public License
	
*/

// Get ORDER ID from Reference
$referenceOrderID = $_POST['OrderID'];
$referenceLanguage = $_POST['Reference'];
$currency = $_POST['Currency'];

// Language override
if (!$referenceLanguage) $referenceLanguage = "EN";
$_GET['language'] = strtolower($referenceLanguage);
$HTTP_GET_VARS['language'] = strtolower($referenceLanguage); //MS 2.2 fix

// Currency override
if (!$currency) $currency = "EUR";
$_GET['currency'] = strtoupper($currency);
$HTTP_GET_VARS['currency'] = strtoupper($currency);            // MS 2.2 fix

// Load osCommerce environment
chdir("../../../../");

if (!file_exists("includes/application_top.php")) die("Unable to load configuration, check the file");

require('includes/application_top.php');

if ($_SERVER['REQUEST_METHOD'] != "POST") die("Postback script properly installed");

// Set ICEPAY class
require(DIR_WS_CLASSES . "payment.php");
$payment_modules = new payment("icepay");
$payment_module = $GLOBALS[$payment_modules->selected_module];
$payment_module->setMerchant();

//Check postback
if (!$payment_module->OnPostback()) die("Invalid postback data");

$paymentIDs = $_POST['StatusCode'] . " ( " .
    "OrderID:" . $referenceOrderID .
    ", Reference:" . $_POST['Reference'] .
    ", TransactionID:" . $_POST['TransactionID'] .
    ", PaymentID:" . $_POST['PaymentID'] .
    " )";
$orderInfo = $referenceOrderID .
    " ( Reference:" . $_POST['Reference'] .
    ", TransactionID:" . $_POST['TransactionID'] .
    ", PaymentID:" . $_POST['PaymentID'] .
    " )";
define(ICEPAY_EMAIL_TEXT_PM, $_POST['PaymentMethod']);
define(ICEPAY_EMAIL_TEXT_ORDER, $orderInfo);

// Get Order data from osCommerce
require(DIR_WS_CLASSES . "order.php");
$order = new order($referenceOrderID);
require(DIR_WS_CLASSES . "order_total.php");
$order_total_modules = new order_total();

// set some globals (expected by osCommerce)
$customer_id = $order->customer['id'];
$order_totals = $order->totals;

// Get current status from Order
$order_status_query = tep_db_query(sprintf("SELECT orders_status_id FROM %s WHERE orders_status_name = '%s' AND language_id = '%s'",
    TABLE_ORDERS_STATUS,
    $order->info['orders_status'],
    $languages_id
));
$order_status = tep_db_fetch_array($order_status_query);
$order->info['order_status'] = $order_status['orders_status_id'];

$status_to_db = 0;
$update_stock = 0;
$customer_notified = 0;

// Actions
switch ($_POST['Status']) {
    case "OPEN":
        if ($order->info['order_status'] == MODULE_PAYMENT_ICEPAY_ORDER_STATUS_ID) {
            define(ICEPAY_EMAIL_TEXT_SUBJECT, EMAIL_TEXT_SUBJECT_OPEN);
            define(ICEPAY_EMAIL_TEXT_INFO, EMAIL_TEXT_SUBJECT_OPEN_INFO);
            $customer_notified = strtolower(MODULE_PAYMENT_ICEPAY_SENDEMAIL_OK) == 'true' ? 1 : 0;
            $payment_module->updateStatus($referenceOrderID, MODULE_PAYMENT_ICEPAY_OPEN_ORDER_STATUS_ID, $paymentIDs, $customer_notified);
        };
        break;
    case "OK":
        if ($order->info['order_status'] == MODULE_PAYMENT_ICEPAY_ORDER_STATUS_ID || $order->info['order_status'] == MODULE_PAYMENT_ICEPAY_OPEN_ORDER_STATUS_ID) {
            define(ICEPAY_EMAIL_TEXT_SUBJECT, EMAIL_TEXT_SUBJECT_OK);
            define(ICEPAY_EMAIL_TEXT_INFO, EMAIL_TEXT_SUBJECT_OK_INFO);
            $customer_notified = strtolower(MODULE_PAYMENT_ICEPAY_SENDEMAIL_OPEN) == 'true' ? 1 : 0;
            $update_stock = strtolower(MODULE_PAYMENT_ICEPAY_STOCKUPDATE) == 'true' ? 1 : 0;
            $payment_module->updateStatus($referenceOrderID, MODULE_PAYMENT_ICEPAY_SUCCESS_ORDER_STATUS_ID, $paymentIDs, $customer_notified);
        };
        break;
    case "ERR":
        if ($order->info['order_status'] == MODULE_PAYMENT_ICEPAY_ORDER_STATUS_ID || $order->info['order_status'] == MODULE_PAYMENT_ICEPAY_OPEN_ORDER_STATUS_ID) {
            $payment_module->updateStatus($referenceOrderID, MODULE_PAYMENT_ICEPAY_CANCELLED_ORDER_STATUS_ID, $paymentIDs, $customer_notified);
        };
        break;
    case "REFUND":
        if ($order->info['order_status'] == MODULE_PAYMENT_ICEPAY_SUCCESS_ORDER_STATUS_ID) {
            $payment_module->updateStatus($referenceOrderID, MODULE_PAYMENT_ICEPAY_REFUND_ORDER_STATUS_ID, $paymentIDs, $customer_notified);
        };
        break;
    case "CBACK":
        if ($order->info['order_status'] == MODULE_PAYMENT_ICEPAY_SUCCESS_ORDER_STATUS_ID) {
            $payment_module->updateStatus($referenceOrderID, MODULE_PAYMENT_ICEPAY_CHARGEBACK_ORDER_STATUS_ID, $paymentIDs, $customer_notified);
        };
        break;
};

// Update stock
if ($update_stock == 1) {
    include_once(DIR_WS_MODULES . 'payment/icepay/custom/class_update_stock.php');
};

// Notify customer
if ($customer_notified == 1) {
    $payment_module->_notify_customer($referenceOrderID);
};

require('includes/application_bottom.php');

?>
