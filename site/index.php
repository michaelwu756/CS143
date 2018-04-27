<?php
// This line is edited remotedly!
?>
<?php
   include("./config.php");
   include("./common.php");
?>

<html>

<head>
     <?php headerer($g_pagetitle); ?>
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
   $contest = new Contest($g_configfile, $g_problempath);
   if ($contest->okay)
   {
print '<div style="margin-bottom:2em;">
  <h4 >'.$contest->cname.'</h4>

  <h6 >From '.$contest->ctime.'</br>'
  .$contest->cdate.'</br></h6 >
  <h6>Current time: '.date("g:i:s A").'</h6>
</div>';

      if ( ! session_id() ) @ session_start();

      if ($contest->tnow >= $contest->tstart) {
          $_SESSION["contest_starts"] = 1;
      }
      else {
          $_SESSION["contest_starts"] = 0;
      }

   print '<ul class="list-group" style="max-width:500px;margin:auto;margin-bottom:50px">';

      foreach ($contest->pletters as $letter)
      {
         //$link = $g_problempath."all.php";
         $link = $contest->problemlonglink($letter);
         $name = $contest->pnames[$letter];
         if ($_SESSION["contest_starts"] == 1) {
print <<<END
 <li class="list-group-item d-flex justify-content-between align-items-center">
 <form style='display: none;' id="form$letter" action="view.php?problem=$letter" method="get" > </form>
        <a href="view.php?problem=$letter" target="_blank" style="text-align:left; display:block" >
            Problem $name
        </a>
    <span class="badge badge-primary badge-pill badge-secondary">$g_pv[$letter]</span>
  </li>
END;
         }
         else {
print <<<END

<li class="list-group-item d-flex justify-content-between align-items-center">
    Problem $letter
    <span class="badge badge-primary badge-pill">1</span>
  </li>
END;
         }
      }
      print "</ul>";



      // unlock (or relock) the problem set if necessary
      if ($contest->tnow > $contest->tstart)
      {
         if (file_exists($g_problempath . ".htaccess"))
            rename($g_problempath . ".htaccess", $g_problempath . ".lock");
      }
      else
      {
         if (file_exists($g_problempath . ".lock"))
            rename($g_problempath . ".lock", $g_problempath . ".htaccess");
      }
   }
?>

</div>

<?php footer($contest->chost); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
