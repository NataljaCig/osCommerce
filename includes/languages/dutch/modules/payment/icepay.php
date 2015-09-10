<?php
/*
  $Id: icepay.php,v 1.0 2008/11/11 19:35:49

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
*/

if (!defined('DIR_WS_HTTP_CATALOG')) include("../includes/configure.php");

define('MODULE_PAYMENT_ICEPAY_TEXT_TITLE', 'Online betalen met ICEPAY');

define('MODULE_PAYMENT_ICEPAY_TEXT_DESCRIPTION', @"
	<img src='images/icon_info.gif' border='0'>&nbsp;<b>ICEPAY module for osCommerce</b><br />
	<br />
	<img src='images/icon_popup.gif' border='0'>&nbsp;<a href='http://www.icepay.eu' target='_blank' style='text-decoration: underline; font-weight: bold'>Bezoek de ICEPAY website</a>
");

define('MODULE_PAYMENT_ICEPAY_SUBMODULE_DESCRIPTION', 'The main ICEPAY module must be installed (does not have to be active) to use this payment method.');

define('MODULE_PAYMENT_ICEPAY_NAVBAR_TITLE_ERROR', 'Foutmelding');
define('MODULE_PAYMENT_ICEPAY_TEXT_ERROR', 'Fout!');
define('MODULE_PAYMENT_ICEPAY_TEXT_ERROR_MESSAGE', 'Er is een fout opgetreden tijdens het verwerken van uw betaling. Probeert u het later nog eens.');

/* Error */
define('TEXT_ICEPAY_ERROR', 'De betaling is niet gelukt. Betaal op een andere wijze, of probeert u het later nog eens.');
define('NAVBAR_TITLE_ICEPAY_ERROR', 'Betaling Mislukt');
define('HEADING_TITLE_ICEPAY_ERROR', 'Betaling Mislukt');

/* E-mails */
define('EMAIL_TEXT_SUBJECT_OK', 'Betaling ontvangen');
define('EMAIL_TEXT_SUBJECT_OK_INFO', 'De betaling voor uw bestelling is geheel ontvangen.');
define('EMAIL_TEXT_SUBJECT_OPEN', 'Verwerking bestelling');
define('EMAIL_TEXT_SUBJECT_OPEN_INFO', 'Uw bestelling wordt verwerkt.');
define('EMAIL_TEXT_ORDER_NUMBER', 'Bestellingsnummer: ');
define('EMAIL_TEXT_INVOICE_URL', 'Gespecificeerde Factuur: ');
define('EMAIL_TEXT_COMMENTS', 'Opmerkingen');
define('EMAIL_TEXT_DATE_ORDERED', 'Datum bestelling:');
define('EMAIL_TEXT_PRODUCTS', 'Artikelen');
define('EMAIL_TEXT_SUBTOTAL', 'Subtotaal: ');
define('EMAIL_TEXT_TAX', 'BTW:        ');
define('EMAIL_TEXT_SHIPPING', 'Verzendkosten: ');
define('EMAIL_TEXT_TOTAL', 'Totaal:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Leveringsadres');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Factuuradres');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Betalingswijze');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'via');

?>