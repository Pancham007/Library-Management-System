<?php
	$con = new mysqli("localhost","root","root","library");
	$card_id=$_GET["card_id"];
	$x = intval($card_id);
	$sql = "select * from book_loans natural join fines where card_id=$x";
	$result = $con->query($sql);
	if ($result->num_rows > 0)
	{
		echo "<table class='table table-striped'><thead class='thead-inverse'><tr><th>Loan_ID</th><th>ISBN</th><th>Card_ID</th><th>Fine_Amount</th><th>Paid</th><th></th></tr></thead><tbody>";
		while($row = $result->fetch_assoc())
		{
			$c=$row['card_id'];
			$f=$row['fine_amt'];
			$l=$row['loan_id'];
			$sql2 = "select date_in from book_loans where loan_id=$l";
			$result2 = $con->query($sql2);
			$row2 = $result2->fetch_assoc();
			$i = $row2['date_in'];
			echo "<tr>";
			echo "<td>" . $row['loan_id'] . "</td>";
			echo "<td>" . $row['isbn'] . "</td>";
			echo "<td>" . $row['card_id'] . "</td>";
			echo "<td>" . $row['fine_amt'] . "</td>";
			if($row['paid']==0 && $i!=null)
				echo "<td><button type='button' class='btn btn-default' onclick='pay($c,$f,$l);'>Pay</td>";
			else if($i==null)
				echo "<td><button type='button' class='btn btn-default' disabled>Pay</td>";
			else
				echo "<td>Paid</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		$sql1="select sum(fine_amt) from fines natural join book_loans where card_id=$x and paid=0 group by card_id";
		$result1 = $con->query($sql1);
		$row = $result1->fetch_assoc();
		$i = $row['sum(fine_amt)'];
		if($i>0)
			echo "<div id='bal'>Balance due = $$i </div>";
		else
			echo "<div id='bal'>Fines Paid</div>";
	}
	else
	{
		echo "<div id='bal'>No fine amounts to show</div>";
	}
	$con->close();
?>
