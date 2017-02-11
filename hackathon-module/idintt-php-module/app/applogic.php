<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED);

require __DIR__ . '/../library/vendor/autoload.php';
use BankId\Merchant\Library\Configuration;
use BankId\Merchant\Library\Communicator;
use BankId\Merchant\Library\AuthenticationRequest;
use BankId\Merchant\Library\AssuranceLevel;
use BankId\Merchant\Library\StatusRequest;
Configuration::defaultInstance()->load("bankid-config.xml");

if(isset($_GET['step'])){$step = $_GET['step'];}
else{$step=0;}

if($step==0){
	$comm = new Communicator();
	$Model = $comm->getDirectory();
	$_SESSION['redirectUrl'] = $_POST['redirectUrl'];
}

if($step==1){
	$comm = new Communicator();
	$a = new AuthenticationRequest();
	$a->setIssuerID($_GET['bank']);
	$a->setLanguage("nl");
	$a->setExpirationPeriod("PT5M");
	$a->setEntranceCode("12345ec");
	$a->setMerchantReference("merchantReference");
	$a->setRequestedServiceID("17600");
	$a->setAssuranceLevel("nl:bvn:bankid:1.0:loa2");
	$Model = $comm->newAuthenticationRequest($a);
	$url = $Model->getIssuerAuthenticationURL();
	header('Location: '.$url);
}

if($step==2){
	$comm = new Communicator();
	$s = new StatusRequest();
	$s->setTransactionID($_GET['trxid']);
	$Model = $comm->getResponse($s);
}

// Post to fabric-module api
if($step==3){
    function postJson($url, $data) {
        $ch = curl_init($url);
        $data_string = json_encode($data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    $data = array(
    	'name' => urlencode('Name'), // TODO
    	'bin' => urlencode($_GET['bin']),
    	'vendorId' => urlencode('HARRY'),
    );
    $tcert = postJson('http://fabric-module:8080/api/v1/user', $data);
}

if($step==4){
	header('Location: '."./index-demo.php");
}
?>
