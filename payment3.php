<?php
	$con = new mysqli("localhost","root","root","library");
	$l=$_GET["loan_id"];
	$x = intval($l);
	$sql = "update fines set paid=true where loan_id=$x";
	if ($con->query($sql) === TRUE)
		echo "Fine Payment Successfull";
	$con->close();
?>
