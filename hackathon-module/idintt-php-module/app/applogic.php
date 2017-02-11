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

if($step==4){
	header('Location: '."./index-demo.php");
}
?>
