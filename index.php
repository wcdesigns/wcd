<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <title>Manat Employees List</title>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h2>Manat Employee Contact List</h2>
            </div>
            <div class="row">
                <p><a href="create.php" class="btn btn-success">Create</a></p> 
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email Address</th>
                      <th>Cell Number</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                <tbody>
                  <?php
                   include 'includes/database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM employees ORDER BY id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['cell'] . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                </tbody>
            	</table>
        </div>
    </div> <!-- /container -->
  </body>
</html>
