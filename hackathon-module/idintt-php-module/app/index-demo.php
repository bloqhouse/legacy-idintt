<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED);

if(isset($_GET['step'])){
	$step = $_GET['step'];
}
else{
	$step=0;
}

if($step==0){
}

if($step==1){
	file_put_contents('../demo-scripts/1issuerid', $_GET['bank']);
	sleep(5);
	$redirecturl = file_get_contents('../demo-scripts/step4.txt');
	$redirecturl = substr($redirecturl, strpos($redirecturl, "Location: ") + 10);
	$redirecturl = substr($redirecturl, 0, strpos($redirecturl, "[")-1);
	header('Location: '."$redirecturl");
}

if($step==2){
	$issuerid = file_get_contents('../demo-scripts/1issuerid');
	sleep(5);
	$result = file_get_contents('../demo-scripts/step7.txt');
	$legallastname = substr($result, strpos($result, 'legallastname')+22);
	$legallastname = substr($legallastname, 0, strpos($legallastname, '<'));

	$postalcode = substr($result, strpos($result, 'postalcode')+19);
	$postalcode = substr($postalcode, 0, strpos($postalcode, '<'));

	$dateofbirth = substr($result, strpos($result, 'dateofbirth')+20);
	$dateofbirth = substr($dateofbirth, 0, strpos($dateofbirth, '<'));

	$initials = substr($result, strpos($result, 'initials')+17);
	$initials = substr($initials, 0, strpos($initials, '<'));
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
				<h1>Your trusted blockchain identity provider</h1>
				<!--
				<nav>
					<a href="#" class="bp-icon bp-icon-prev" data-info="Previous step"><span>Previous</span></a>
					<a href="#" class="bp-icon bp-icon-next" data-info="Next step"><span>Next</span></a>
					<a href="#" class="bp-icon bp-icon-drop" data-info="Information"><span>Information</span></a>
					<a href="#" class="bp-icon bp-icon-archive" data-info="Contact"><span>Contact</span></a>
				</nav>
				-->
			</header>
			<div class="main">
				<form class="cbp-mc-form">
					<div class="cbp-mc-column">
							<form action="index.php" method="get">
							<label for="bank">Select your bank</label>

							<?php if($step==0){ ?>
							<select id="bank" name="bank">
					            <optgroup label="Nederland">
												<option value="SNSBNL2A">SNS</option>
												<option value="ABNANL2A">ABN Amro</option>
												<option value="ASNBNL21">ASN</option>
												<option value="INGBNL2A">ING</option>
												<option value="RABONL2U">Rabobank</option>
												<option value="RBRBNL21">Regiobank</option>
												<option value="SNSBNL2A">SNS</option>
												<option value="TRIONL2U">Triodos bank</option>
					            </optgroup>
							</select>
							<input type="hidden" name="step" value="1">
							<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="1) Go to your bank" /></div>
							</form>

							<?php } if($step==2) { ?>
								<select id="bank" name="bank" disabled>
									<option value="<?php echo $issuerid; ?>"><?php echo $issuerid; ?></option>
								</select>
							<?php } ?>

					</div>
					<div class="cbp-mc-column">
					<?php if($step==2){ ?>
						<label for="initials">Initials</label>
						<input type="text" id="initials" name="initials" placeholder="<?php echo $initials; ?>" readonly>

						<label for="lastname">Last name</label>
						<input type="text" id="lastname" name="lastname" placeholder="<?php echo $legallastname; ?>" readonly>

						<label for="postalcode">Postal code</label>
						<input type="text" id="postalcode" name="postalcode" placeholder="<?php echo $postalcode; ?>" readonly>

						<label for="dateofbirth">Birthdate</label>
						<input type="text" id="dateofbirth" name="dateofbirth" placeholder="<?php echo $dateofbirth; ?>" readonly>
	  			</div>
	  			<div class="cbp-mc-column">
	  					<label>Give access to</label>
							<input type="text" id="org2" name="org2" placeholder="Harrie's lucht kasteel" readonly><br>
							<input type="text" id="org1" name="org1" placeholder="Autoriteit Financiele Markten" readonly><br>
							<input type="text" id="org1" name="org1" placeholder="De Belastingdienst" readonly>
							<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="2) Register and return" /></div>
	  			</div>
					<?php } ?>
				</form>
			</div>
		</div>
	</body>
</html>
