<?php
    require 'includes/database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
     
    if ( !empty($_POST)) {
        // Keep track validation errors
        $nameError = null;
        $emailError = null;
        $cellError = null;
         
        // Keep track of posted values
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
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address.';
            $valid = false;
        }
         
        if (empty($cell)) {
            $cellError = 'Only numbers are allowed for the Phone Number.';
            $valid = false;
        }
         
        // Update the data in the database
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE employees  set name = ?, email = ?, cell =? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$email,$cell,$id));
            Database::disconnect();
            header("Location: index.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM employees where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['name'];
        $email = $data['email'];
        $cell = $data['cell'];
        Database::disconnect();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <title>Update - <?php echo $data['name'];?></title>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update <font color="#0404B4"><?php echo $data['name'];?></font>'s record</h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!preg_match("/^[a-zA-Z ]*$/",$name)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!filter_var($email, FILTER_VALIDATE_EMAIL)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($cellError)?'error':'';?>">
                        <label class="control-label">cell Number</label>
                        <div class="controls">
                            <input name="cell" type="number"  placeholder="Cell Number" value="<?php echo !empty($cell)?$cell:'';?>">
                            <?php if (ctype_digit($cell)): ?>
                                <span class="help-inline"><?php echo $cellError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
