<?php
   include("config.php");
   include("common.php");

   // process the POST data right away and send refresh header to avoid repost
   $team       = $_SESSION["teamid"];
   $problem    = $_POST["problem"];
   $text       = $_POST["request"];

   if ($problem && $text)
   {
      if ($fp = fopen($g_creqfile, "a"))
      {
         flock($fp, LOCK_EX);
         fputs($fp, "----------------------------------------\n");
         $clar = new Clarification($team, $problem, stripcslashes(rtrim($text)));
         $clar->write($fp);
         fclose($fp);
         $_SESSION["logged"] = True;

         // refresh the page to prevent double POST
         header("Location: clarify.php");
         exit("Clarification logged.");
      }
      else
         $_SESSION["logged"] = False;
   }
?>

<html>

<head>
<?php headerer($g_pagetitle.' - Clarifications'); ?>
</head>


<body >


<?php navigation("clarify"); ?>

<div class='container text-center' style='padding-top:5em;'>



<?php
   $contest = new Contest($g_configfile, $g_problempath);

   // if a clarification request was logged, print an acknowledgement here
   if (isset($_SESSION["logged"]))
   {

      if ($_SESSION["logged"])
      {

         print '<div class="alert alert-success" role="alert">Clarification Request Result: Your request has been successfully logged.<br>';
         print "Please be patient and wait for your response to appear below.</div>";
      }
      else
      {
         print '<div class="alert alert-danger" role="alert">Clarification Request Result: Error processing your request!</div>';
      }

      unset($_SESSION["logged"]);
   }
   ?>

<h1>View Clarifications</h1>



<?php
   // now print out the existing clarifications
   if (file_exists($g_clarfile)) {
      if ($fp = fopen($g_clarfile, "r"))
      {
         flock($fp, LOCK_SH);
         print "<p><b><big>$setname</big></b></p>\n";
         print "<table class='table'>";
         print "<tr ><th width=\"25%\">Problem</th>";
         print "<th>Clarification</th></tr>\n";
         while ($line = fgets($fp))
            if ($line{0} == "-")
            {
               $c = Clarification::read($fp);
               $question = nl2br($c->question);
               $answer = nl2br($c->answer);

               if ($c->responded)
               {
                  print "<tr><td>$c->problem</td>\n";
                  print "<td>\n";
                  if (trim($c->question)) print "$question<br>\n";
                  print "<i>$answer</i></td>\n";
                  print "</td></tr>\n";
               }
            }
         print "</table><br>\n";
         fclose($fp);
      }
      else {
         print "<p>Unable to open clarifications file!</p>\n";
      }
   }
   else {
      print "<p><big><i>There are no clarifications at this time.</i></big></p>\n";
   }
?>

</div>

<?php
// print out a form for requesting clarifications if a team is logged on
if ($team)
{
// ----- HTML -----



print <<<END
<hr>
<form class='border text-left' style='max-width:500px;margin:auto; padding:2em;background:white;' name="view" method="post" action="clarify.php">


<div align="center"><h3 >Request Clarification</h3></div>

 <div class="form-group">
    <label class="form-label">Problem</label>
    <select class="form-control" name="problem">
        <option value="General">General</option>
END;
// ----- END -----
         foreach ($contest->pnames as $name)
            print "<option value=\"$name\">$name</option>";
// ----- HTML -----
print <<<END
   </select>
   </div>
<div class="form-group">
<label class="form-label">Question</label>
   <textarea name="request" class="form-control" placeholder="(type your question in this box)">Type your question in this box!</textarea>
</div>

<div align="center">
<button type="submit" class="btn btn-secondary" value='submit' >Bug the judge...</button>
</div>
</table>
</form>
END;

// ----- END -----
}
?>



<?php footer($contest->chost); ?>

</body>

</html>
