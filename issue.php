<?php
	$con = new mysqli("localhost","root","root","library");
	$isbn=$_GET["isbn"];
	$card=$_GET["card"];
	$sql = "SELECT max(loan_id) FROM book_loans";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$id = $row["max(loan_id)"];
	$id = $id+1;
	$sql = "SELECT count(*) FROM book_loans WHERE card_id='$card' and date_in is null";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$i = $row["count(*)"];
	if($i>=3)
	{
		echo "Sorry,you have already reached the limit of 3 books!!";
	}
	else
	{
		$sql1 = "INSERT INTO book_loans(loan_id,isbn,card_id,date_out,due_date,date_in) VALUES ('$id','$isbn','$card',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 14 DAY),null)";
		if ($con->query($sql1) === TRUE)
		{
			echo "Book Successfully added to your account.";
		}
		else
		{
			echo "Invalid Card ID or Card ID does not exixt in database!!!";
		}
	}
$con->close();
?>
