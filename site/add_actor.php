<?php
   include("./config.php");
   include("./common.php");
   include("./functions.php");
?>

<html>

<head>
     <?php headerer(); ?>
</head>



<body >

<?php navigation(); ?>
<?php heading('Add Actor'); ?>

<?php
    function display()
    {
        add_actor($_POST["lname"], $_POST["fname"], $_POST["sex"], $_POST["dateb"], $_POST["dated"]);
        notify_success("Added Actor ".$_POST["fname"].' '.$_POST["lname"]);
    }
    if(isset($_POST['submit']))
    {
       display();
    }
?>

<?php form('<form method="POST" action="add_director.php">
        <label class="radio-inline radio">
            <input type="radio" name="sex" checked="checked" value="male">Male
        </label>
        <label class="radio-inline radio">
            <input type="radio" name="sex" value="female">Female
        </label>

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



