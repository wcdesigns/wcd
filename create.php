<?php
	include_once 'includes/database.php';

	if (!empty($_POST)) {
		// Keep track of validation errors
		$nameError = null;
		$emailError = null;
		$cellError = null;

		// Keep track of the posted values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$cell = $_POST['cell'];

		// Validate the input for these fields, basic validation
		$valid = true;
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			$nameError = 'Please enter only letters for the employee&#146;s name.';
			$valid = false;
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailError = 'Please enter the employee&#146;s email address.';
			$valid = false;
		}
		if (ctype_digit($cell)) {
			$cellError = 'Please enter the employee&#146;s cell phone number.';
			$valid = false;
		}
		// Insert the data into the database
		if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO employees (name,email,cell) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$email,$cell));
            Database::disconnect();
            header("Location: index.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h2>Create an Employee</h2>
                    </div>
             
                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($cellError)?'error':'';?>">
                        <label class="control-label">Cell Number</label>
                        <div class="controls">
                            <input name="cell" type="number" placeholder="Cell Number" value="<?php echo !empty($cell)?$cell:'';?>">
                            <?php if (!empty($cellError)): ?>
                                <span class="help-inline"><?php echo $cellError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
