<?php
	$con = new mysqli("localhost","root","root","library");
	$isbn=$_GET["isbn"];
	$card=$_GET["card"];
	$date=$_GET["returndate"];
	$sql = "update book_loans set date_in='$date' where isbn='$isbn' and card_id=$card";
	if ($con->query($sql) === TRUE)
		echo "The book hs been successfully returned.";
	$sql = "select loan_id,due_date from book_loans where isbn='$isbn' and card_id=$card";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$loan = $row['loan_id'];
	$d = $row['due_date'];
	$sql = "select loan_id from fines where loan_id=$loan";
	$result = $con->query($sql);
	if($result->num_rows > 0)
	{
		$sql2="update fines set fine_amt=((SELECT DATEDIFF('$date','$d') AS days)*0.25) where loan_id=$loan";
		$con->query($sql2);
	}
	else
	{
		$sql3="insert into fines values($loan,(SELECT DATEDIFF('$date','$d') AS days)*0.25,FALSE)";
		$con->query($sql3);
	}
	$con->close();
?>
