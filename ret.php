<?php
	$keyword=$_GET["keyword"];
	$con = new mysqli("localhost","root","root","library");
	$sql = "select * from book_loans natural join borrower where date_in is null and (isbn like '%$keyword%' or card_id=CAST('$keyword' AS UNSIGNED))";
	$sql1 = "select * from book_loans natural join borrower where date_in is null and bname like '%$keyword%'";
	$result = $con->query($sql);
	$result1 = $con->query($sql1);
	if ($result->num_rows > 0 || $result1->num_rows > 0)
	{
		$sql = "select bw.card_id,b.isbn,b.title from book as b NATURAL JOIN book_loans as bw where date_in is null and isbn in (select isbn from book_loans natural join borrower where isbn like '%$keyword%' or bname like '%$keyword%' or card_id=CAST('$keyword' AS UNSIGNED)) group by isbn";
		$result = $con->query($sql);
		if ($result->num_rows > 0)
		{
			echo "<table class='table table-striped'><thead class='thead-inverse'><tr><th>Card ID</th><th>ISBN</th><th>Title</th><th>Check IN</th></tr></thead><tbody>";
			while($row = $result->fetch_assoc())
			{
				echo "<tr id='" . $row['card_id'] . "'>";
				echo "<td>" . $row['card_id'] . "</td>";
				echo "<td>" . $row['isbn'] . "</td>";
				echo "<td>" . $row['title'] . "</td>";
				echo "<td><button type='button' class='btn btn-primary' onclick='bookreturn(\"" . $row[isbn] . "\", " . $row[card_id] . ")'>Return</td>";
				echo "</tr>";
			}
			echo "</tbody></table>";
		}
	}
	else
	{
		echo " No books have been borrowed !! ";
	}
	$con->close();
?>
