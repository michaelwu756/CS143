<?php
// This line is edited remotedly!
?>
<?php
   include("./config.php");
   include("./common.php");
?>

<html>

<head>
     <?php headerer(); ?>
</head>


<body >
      <?php navigation("index"); ?>

<div class="container text-center" style='padding-top:5em;'>
<h1>Contest</h1>


<?php
   // just make sure the submitfile and judgefile are there
   if (!file_exists($g_submitfile))
   {
      $fp = fopen($g_submitfile, "w");
      fclose($fp);
      chmod($g_submitfile, 0660);
   }
   if (!file_exists($g_judgefile))
   {
      $fp = fopen($g_judgefile, "w");
      fclose($fp);
      chmod($g_judgefile, 0660);
   }

?><?php

?>

</div>

<?php footer(); ?>

</body>

</html>
