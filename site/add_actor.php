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

<div>


<?php heading('Add Actor'); ?>


<?php form('<form method="GET" action="#">
        <label class="radio-inline radio">
            <input type="radio" name="sex" checked="checked" value="male">Male
        </label>
        <label class="radio-inline radio">
            <input type="radio" name="sex" value="female">Female
        </label>

       <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" class="form-control" placeholder="John" name="fname">
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text" class="form-control" placeholder="Smith" name="lname">
        </div>
        <div class="form-group">
          <label for="DOB">Date of Birth</label>
          <input type="text" class="form-control" placeholder="1998-03-07" name="dateb">
        </div>
        <div class="form-group">
          <label for="DOD">Date of Death</label>
          <input type="text" class="form-control" placeholder="(Leave blank if alive)" name="dated">
        </div>
        <button type="submit" class="btn btn-default">Add It!</button>
    </form>'); ?>

<?php footer(); ?>

</body>

</html>
