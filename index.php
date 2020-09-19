<?php 
	
	$errors = "";

	// connect to database
	$db = mysqli_connect("http://db4free.net/", "my_local", "12345678", "mydb_11");

	// insert a quote if submit button is clicked
	if (isset($_POST['add'])) {

		if (empty($_POST['part']) or empty($_POST['amt'])) {
			$errors = "You must fill in the vlaues";
		}else{
			$name = $_POST['part'];
			$amt=$_POST['amt'];
			$query = "INSERT INTO users (name,amt) VALUES ('$name',$amt)";
			mysqli_query($db, $query);
			header('location: index.php');
		}
	}	

	// delete task
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM users WHERE id=".$id);
		header('location: index.php');
	}
	
	

	// select all tasks if page is visited or refreshed
	
$tasks = mysqli_query($db, "SELECT * FROM users");

?>
<!DOCTYPE html>
<html>

<head>
	<title>Split your BILL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Split your BILL</h2>
	</div>


	<form method="post" action="index.php" class="input_form">
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
		<input type="text" name="part" class="split_input" placeholder="Participant name">
		<input type="number" name="amt" class="split_input" placeholder="Amount">
		<button type="submit" name="add" id="add_btn" class="add_btn">Add</button>
	


	<table>
		<thead>
			<tr>
				<th>No.</th>
				<th>Participants</th>
				<th>Amount</th>
				<th style="width: 60px;">Delete</th>
			</tr>
		</thead>

		<tbody>
			<?php $i = 1;
			$total=0;
			while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr>
					<td> <?php echo $i; ?> </td>
					<td class="split"> <?php echo $row['name']; ?> </td>
					<td class="split"> <?php echo $row['amt'];?></td>
					<td class="delete"> 
						<a href="index.php?del_task=<?php echo $row['id']; ?>">x</a> 
					</td>
				</tr>
			<?php	$total+=$row['amt'];
					$i++; } 
			$myfile = fopen("newfile.txt", "w");
			fwrite($myfile,$total);
			fclose($myfile);?>
			<tr>
				<td></td>
				<td class="split">TOTAL</td>
				<td class="split"><?php echo $total; ?></td>
				<td></td>
			</tr>
			
		</tbody>
	</table>
	<a href="calc.php" class="add_btn" id="add_btn">Calculate</a>
	</form>
	

</body>
</html>