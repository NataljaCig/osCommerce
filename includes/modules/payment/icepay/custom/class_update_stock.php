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

	class_update_stock.php
	
	Function: Substracting the stock of the ordered products
	Called from: notify.php as payment is completed, 
	"Update stock only on succes" setting in admin must be True(Active)
	or script will be skipped.
	
	This file contains the code of the osCommerce order.php Class.
	If that file has been modified you are required to modify this file aswell.
	
*/

for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
    // Stock Update - Joao Correia
    if (STOCK_LIMITED == 'true') {
        if (DOWNLOAD_ENABLED == 'true') {
            $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename
								FROM " . TABLE_PRODUCTS . " p
								LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
								 ON p.products_id=pa.products_id
								LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
								 ON pa.products_attributes_id=pad.products_attributes_id
								WHERE p.products_id = '" . tep_get_prid($order->products[$i]['id']) . "'";
            // Will work with only one option for downloadable products
            // otherwise, we have to build the query dynamically with a loop
            $products_attributes = $order->products[$i]['attributes'];
            if (is_array($products_attributes)) {
                $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
            }
            $stock_query = tep_db_query($stock_query_raw);
        } else {
            $stock_query = tep_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
        }
        if (tep_db_num_rows($stock_query) > 0) {
            $stock_values = tep_db_fetch_array($stock_query);
            // do not decrement quantities if products_attributes_filename exists
            if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values['products_attributes_filename'])) {
                $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
            } else {
                $stock_left = $stock_values['products_quantity'];
            }
            tep_db_query("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
            if (($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false')) {
                tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
            }
        }
    }
}

?>