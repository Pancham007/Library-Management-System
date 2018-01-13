<?php
	$name=$_GET["name"];
	$arr = explode(" ", $name);
	$x="";
	for ($i = 0; $i <count($arr); $i++)
	{
		$arr[$i]=trim($arr[$i]);
		if(strcmp($arr[$i],""))
		{
			$x.=" b.isbn  like '%$arr[$i]%' or b.title like '%$arr[$i]%' or a.name like '%$arr[$i]%' ";
			if($i<count($arr)-1)
				$x.=" or ";
		}
	}
	$con = new mysqli("localhost","root","root","library");
	$sql = "select isbn from book_loans where date_in is null";
	$nobooks = $con->query($sql);
	$t="";
	if($nobooks->num_rows > 0)
	{
		while($row = $nobooks->fetch_assoc())
		{
			$t.=$row[isbn];
			$t.="|";
		}
	}
	$sql = "select b.isbn,b.title,GROUP_CONCAT(a.name) from book as b NATURAL JOIN book_authors NATURAL JOIN authors as a where ($x) group by isbn";
	
	$result = $con->query($sql);
	if ($result->num_rows > 0)
	{
		echo "<table class='table table-striped'><thead class='thead-inverse'><tr><th>ISBN</th><th>Title</th><th>Authors</th><th></th></tr></thead><tbody>";
		while($row = $result->fetch_assoc())
		{
			echo "<tr id='" . $row['isbn'] . "'>";
			echo "<td>" . $row['isbn'] . "</td>";
			echo "<td>" . $row['title'] . "</td>";
			echo "<td>" . $row['GROUP_CONCAT(a.name)'] . "</td>";
			if(strpos($t, $row['isbn']) !== false)
				echo "<td><button type='button' class='btn btn-primary' disabled onclick=borrow('$row[isbn]');>Not Available</td>";
			else
				echo "<td><button type='button' class='btn btn-primary' onclick=borrow('$row[isbn]');>Available</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
	}
	else
	{
		echo " Sorry! Could not find anything... ";
	}
	$con->close();
?>
