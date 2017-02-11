<?php
file_put_contents('../demo-scripts/3trxid', $_GET['trxid']);
header('Location: '."http://localhost/app/index-demo.php?step=2");
?>
