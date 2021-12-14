<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "test");

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
			$sql = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
	}	
    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];
    
        mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
        header('location: index.php');
    }
    
?>

<?php 
	if (isset ($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);

		if (count($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$name = $n['task'];
			header('location: index.php');
		}
	}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo-List</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
</head>
<body>

<!-- =======================================
------------------Header---------------
======================================= -->

    <header class="header">

        <nav class="nav">
            <ul>
                <li><a href="http://localhost/todo-list/index.php">To Do</a></li>
                <li class="border" style="
                padding-left: 163px;
                "><a href="#">In progress</a></li>
                <li class="border" style="
    padding-left: 163px;
"><a href="#">Done</a></li>
            </ul>
        </header>
    </nav>
<div class="main">
    <!-- =======================================
------------------form---------------
======================================= -->
    <form method="post" action="index.php" class="input_form" >
    <?php if (isset($errors)) { ?>
	<p><?php echo $errors; ?></p>
<?php } ?>
		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
		
	</form>
    <!-- =======================================
------------------Todo List Tabel---------------
======================================= -->
    <table>
	<thead>
		<tr>
			<th>N</th>
			<th>Tasks</th>
			<th style="width: 80px;">Edit</th>
			<th>Delete</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($db, "SELECT * FROM tasks");

		$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['task']; ?> </td>
				<td style="
    height: 56px;
">
				<a href="index.php?edit=<?php echo $row['id']; ?>" class="edit_btn" id="btn" >Edit</a>
			</td>
				<td class="delete"> 
					<a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>
    </div>
</body>
</html>