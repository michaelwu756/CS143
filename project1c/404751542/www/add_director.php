<?php
  include("./config.php");
  include("./common.php");
  include("./functions.php");
?>
<html>
  <head>
    <?php headerer(); ?>
  </head>
  <body>
    <?php navigation(); ?>
    <?php heading('Add Director'); ?>
    <?php
      function display()
      {
        $res = add_director($_POST["lname"], $_POST["fname"], $_POST["dateb"], $_POST["dated"]);
        notify($res);
      }
      if(isset($_POST['submit']))
      {
        display();
      }
    ?>
    <?php
      form(
        '<form method="POST" action="add_director.php">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" placeholder="John" name="fname" required>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" placeholder="Smith" name="lname" required>
          </div>
          <div class="form-group">
            <label for="DOB">Date of Birth</label>
            <input type="date" class="form-control" placeholder="1998-03-07" name="dateb" required>
          </div>
          <div class="form-group">
            <label for="DOD">Date of Death</label>
            <input type="date" class="form-control" placeholder="(Leave blank if alive)" name="dated">
          </div>
          <button type="submit" name="submit" class="btn btn-default">Add It!</button>
        </form>'); ?>
    <?php footer(); ?>
  </body>
</html>