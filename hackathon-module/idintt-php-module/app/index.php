<?php require_once('./applogic.php'); ?>
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
		<link rel="stylesheet" type="text/css" href="css/default.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>
		<script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>
	</head>
	<body>
		<div class="container">
			<header class="clearfix">
				<span>idintt</span>
				<?php if($step==3){ ?>
					<h1 style="background-color:#09D261">You're identity is registered on the blockchain</h1>
				<?php } else { ?>
					<h1>Your trusted blockchain identity provider</h1>
				<?php } ?>
			</header>
			<div class="main">
				<form class="cbp-mc-form">
					<div class="cbp-mc-column">
							<?php if($step==0){ ?>
								<form action="index.php" method="get">
									<label for="initiating">Initiating application</label>
									<input type="text" id="initiating" name="initiating" placeholder="Harries Luchtkasteel" readonly>
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
								<form action="<?php echo $_SESSION['redirectUrl']; ?>" method="POST">
										<label for="keys">Your one-time<br/>transaction certificate</label>
								    <textarea id="keys" name="keys" style="background-color:#F8F8F8;color:#09D261"><?php echo $tcert; ?></textarea>
										<script>new Clipboard('.copybtn');</script>
										<div class="cbp-mc-submit-wrap">
											<input class="copybtn cbp-mc-submit" style="background-color:#F8F8F8;color:#09D261" type="button" data-clipboard-action="copy" data-clipboard-target="#keys" value="Ctrl + (C)ertificate" />
										</div>
										<div class="cbp-mc-submit-wrap">
									    <input class="cbp-mc-submit" type="submit" value="3) Go back to Harries Luchtk." />
										</div>
								</form>
							<?php } ?>
					</div>
					<?php if($step==2){ ?>
						<form action="index.php" method="get">
							<div class="cbp-mc-column">
									<?php
										if (strcasecmp($Model->getStatus(), $Model::$Success) == 0) {
										    foreach ($Model->getSamlResponse()->getAttributes() as $key => $value) {
													$key = substr($key, strpos($key, ".") + 1);
													$key = substr($key, strpos($key, ".") + 1);
												?>
													<label for="<?php echo $key; ?>"><?php echo $key; ?></label>
													<input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
										    <?php }
										}
									?>
			  			</div>
			  			<div class="cbp-mc-column">
			  				<label>Give access to</label>
								<input style="background-color:#09D261" type="text" id="org2" name="org2" placeholder="Harrie's lucht kasteel" readonly><br>
								<input style="background-color:#09D261" type="text" id="org1" name="org1" placeholder="Autoriteit Financiele Markten" readonly><br>
								<input style="background-color:#09D261" type="text" id="org1" name="org1" placeholder="De Belastingdienst" readonly>
								<input type="hidden" name="step" value="3">
								<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="2) Register my ledger idintt" /></div>
							</div>
						</form>
					<?php } ?>
				</form>
			</div>
		</div>
	</body>
</html>
