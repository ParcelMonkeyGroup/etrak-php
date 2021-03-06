<?PHP

/*

Get an eTrak label.

*/

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
include_once('../vendor/autoload.php');

$YOUR_API_KEY = '';
$CONSIGNMENT_ID = ''; // The consignment ID you'd like the label for

$etrak = \etrak\etrak::instance()->setApiKey($YOUR_API_KEY)->sandbox();

$response = \etrak\Label::get($CONSIGNMENT_ID);
header("Content-type:application/pdf");
header("Content-Disposition:inline;filename='$CONSIGNMENT_ID.pdf");
echo base64_decode($response->body->data);


