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

if(isset($_GET['step'])){
	$step = $_GET['step'];
}
else{
	$step=0;
}

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

<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>iDIN-TT trusted blockchain identities</title>
		<meta name="description" content="Blueprint: Blueprint: Responsive Multi-Column Form" />
		<meta name="keywords" content="responsive form, inputs, html5, responsive, multi-column, fluid, media query, template" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/default.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>
	</head>
	<body>
		<div class="container">
			<header class="clearfix">
				<span>idintt</span>
				<?php if($step==3){ ?>
					<h1 style="background-color:#09D261">You're now registered on the blockchain</h1>
				<?php } else { ?>
					<h1>Your trusted blockchain identity provider</h1>
				<?php } ?>
			</header>
			<div class="main">
				<form class="cbp-mc-form">
					<div class="cbp-mc-column">
							<?php if($step==0){ ?>
							<form action="index.php" method="get">
							<label for="redirected">Redirected by</label>
							<input type="text" id="redirected" name="redirected" placeholder="Harries Luchtkasteel" readonly>
							<label for="bank">Select your bank</label>
							<select id="bank" name="bank">
					        <?php foreach ($Model->getIssuersByCountry() as $key=>$value) { ?>
					            <optgroup label="<?php echo $key; ?>">
					                <?php foreach ($value as $issuer) { ?>
					                    <option value="<?php echo $issuer->getID(); ?>"><?php echo $issuer->getName(); ?></option>
					                <?php } ?>
					            </optgroup>
									<?php } ?>
							</select>
							<input type="hidden" name="step" value="1">
							<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="1) Go to your bank" /></div>
							</form>
							<?php } if($step==3){ ?>
								<form action="index.php" method="get">
									<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="3) Go back to Harries Luchtk." /></div>
								</form>
							<?php } ?>
					</div>
					<div class="cbp-mc-column">
					<form action="index.php" method="get">
					<?php if($step==2){
						if (strcasecmp($Model->getStatus(), $Model::$Success) == 0) {
						    foreach ($Model->getSamlResponse()->getAttributes() as $key => $value) {
									$key = substr($key, strpos($key, ".") + 1);
									$key = substr($key, strpos($key, ".") + 1);
								?>
									<label for="<?php echo $key; ?>"><?php echo $key; ?></label>
									<input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>" placeholder="<?php echo $value; ?>" readonly>
						    <?php }
						} else {
						?>
						    <pre>Status = <?php echo $Model->getStatus(); ?></pre>
						<?php } ?>
	  			</div>
	  			<div class="cbp-mc-column">
	  					<label>Give access to</label>
							<input style="background-color:#09D261" type="text" id="org2" name="org2" placeholder="Harrie's lucht kasteel" readonly><br>
							<input style="background-color:#09D261" type="text" id="org1" name="org1" placeholder="Autoriteit Financiele Markten" readonly><br>
							<input style="background-color:#09D261" type="text" id="org1" name="org1" placeholder="De Belastingdienst" readonly>
							<input type="hidden" name="step" value="3">
							<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="2) Register my ledger idintt" /></div>

					</form>
					</div>
					<?php } ?>
				</form>
			</div>
		</div>
	</body>
</html>
