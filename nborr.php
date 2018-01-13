<?php
	$ssn=$_GET["ssn"];
	$name=$_GET["name"];
	$add=$_GET["add"];
	$phone=$_GET["phone"];
	$con = new mysqli("localhost","root","root","library");
	$sql = "select max(card_id) from borrower";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$i = $row["max(card_id)"];
	$i=$i+1;
	$sql = "insert into borrower values($i,'$ssn','$name','$add','$phone')";
	if ($con->query($sql) === TRUE)
	{
		echo "Borrower added successfully !!";
	}
	else 
	{
		echo "SSN already exists !!";
	}

?>