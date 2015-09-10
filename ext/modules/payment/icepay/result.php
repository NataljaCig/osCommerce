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

chdir("../../../../");

require("includes/application_top.php");
include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PROCESS);

require(DIR_WS_CLASSES . "payment.php");
$payment_modules = new payment("icepay");
$payment_module = $GLOBALS[$payment_modules->selected_module];

$oscv = 0;
if (file_exists('includes/version.php')) $oscv = trim(implode('', file('includes/version.php')));

switch($_GET["Status"]){
	case "OK":
		$cart->reset(true);
		tep_session_unregister('sendto');
		tep_session_unregister('billto');
		tep_session_unregister('shipping');
		tep_session_unregister('payment');
		tep_session_unregister('comments');
		tep_session_register('customer_id');
		tep_redirect(tep_href_link(FILENAME_CHECKOUT_SUCCESS));
		break;
	case "OPEN":
		$cart->reset(true);
		tep_session_unregister('sendto');
		tep_session_unregister('billto');
		tep_session_unregister('shipping');
		tep_session_unregister('payment');
		tep_session_unregister('comments');
		tep_session_register('customer_id');
		if (floatval($oscv) >= 2.3){
			include_once(DIR_WS_MODULES . 'payment/icepay/custom/page_checkout_open_osc2_3.php');
		} else {
			include_once(DIR_WS_MODULES . 'payment/icepay/custom/page_checkout_open.php');
		}
		break;
	default:
		$url = tep_href_link(
			FILENAME_CHECKOUT_PAYMENT,
			'payment_error=' . $payment_module->code . '&message=' . urlencode($_GET["StatusCode"]),
			'NONSSL', true, false
		);
		tep_redirect($url);
}

?>
