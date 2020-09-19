<?php 
	
	$errors = "";

	// connect to database
	$db = mysqli_connect("http://db4free.net/", "my_local", "12345678", "mydb_11");
	// select all tasks if page is visited or refreshed
	$tasks = mysqli_query($db, "SELECT * FROM users");
	if(isset($_GET['del'])){
		$s="TRUNCATE TABLE users";
		mysqli_query($db,$s);
	}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Calculated</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<table>
		<thead>
			<tr>
				<th>No.</th>
				<th>Participants</th>
				<th>Amount</th>
				<th style="width: 60px;">Owes</th>
			</tr>
		</thead>

		<tbody>
			<?php $i = 1;
			$nu=mysqli_num_rows($tasks);
			$myfile = fopen("newfile.txt", "r");
			$total=fread($myfile,filesize("newfile.txt"));
			if($nu>0){
			$avg=$total/$nu;}
			while ($rows = mysqli_fetch_array($tasks)) { 
						$a=$rows['amt'];
						$owe=$a-$avg;
						$id=$rows['id'];
						$sq="UPDATE users SET owes=$owe WHERE id=$id";
						mysqli_query($db,$sq);
						//header('location:calc.php');
			?>
				<tr>
					<td> <?php echo $i; ?> </td>
					<td class="split"> <?php echo $rows['name']; ?> </td>
					<td class="split"> <?php echo $rows['amt'];?></td>
					<td class="split"> <?php echo $rows['owes']?></td>
				</tr>
			<?php $i++; }?>
		</tbody>
	</table>
	<a href="calc.php?del" class="add_btn" id="add_btn">Clear All Records</a>

</body>
</html>