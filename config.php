<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL^E_NOTICE);

   $g_pagetitle   = "Ultra Cool Programming Contest";
   $g_timezone    = "America/Los_Angeles";

   // if (!function_exists('setGlobalPaths')) {
   // function setGlobalPaths() {
   // This configuration file sets up paths, files, and users.
   
   $g_problempath = "problems/";
   $g_submitpath  = "judge/";

   // Now, g_sessionsfile is the only config file in /judge
   // We will read contest name and fileid from it, and load
   // the appropriate resources from the fileid.
   
   $g_sessionsfile = $g_submitpath . "sessions.txt";

   // read the current session's id
   $tmp_fp = fopen($g_sessionsfile, "r");
   flock($tmp_fp, LOCK_EX);
   $line = fgets($tmp_fp);
   $g_contestid = trim($line);
   fclose($tmp_fp);

   $g_sessiondir = $g_submitpath . "sessions/";
   $g_sessionpath = $g_sessiondir . $g_contestid . "/";
   $g_problempath = $g_problempath . $g_contestid . "/";

   // from now on, all requests will be redirected to g_sessionpath

   $g_testcasepath = $g_sessionpath . "data/";
   $g_submitfile  = $g_sessionpath . "submissions.txt";
   $g_judgefile   = $g_sessionpath . "judgements.txt";
   $g_clarfile    = $g_sessionpath . "clarifications.txt";
   $g_creqfile    = $g_sessionpath . "crequests.txt";
   $g_teamfile    = $g_sessionpath . "teams.txt";
   $g_configfile  = $g_sessionpath . "config.txt";
   $g_iplogfile   = $g_sessionpath . "iplog.txt";
   $g_pvfile = $g_sessionpath . "pv.txt";
   $g_pv = array();
   $tmp_pv = array_map('intval', file($g_pvfile));
   foreach ($tmp_pv as $idx => $pv) {
       $g_pv[chr(ord('A') + $idx)] = $pv;
   }
   // setGlobalPaths();

   // whether or not to log contestant IP address (for security tracking)
   $g_logIPs   = true;
   
   // judging lag or delay in seconds, for the virtual teams
   $g_judgelag = 0;
   
   $g_extension = array(
      "C"      => ".c",
      "C++"    => ".cc",
      "Java"   => ".java",
      "Python"   => ".py"
   );
   
   $g_verdicts = array(
      "U" => "<i>Not Yet Judged</i>",
      "A" => "<b>Accepted</b>",
      "R" => "Run-Time Error",
      "T" => "Time Limit Exceeded",
      "W" => "Incorrect Output",
      "P" => "Presentation Error",
      "C" => "Compile Error",
      "E" => "Submission Error"
   );
   
   $g_months = array(
      "January", "February", "March",
      "April", "May", "June",
      "July", "August", "September",
      "October", "November", "December"
   );
   
   // number of teams to show on the judge configuration screen
   $g_teamtablesize = 100;
   
   // The following array maps teams to passwords!
   $g_teams = array();

   // The following array maps teams to alternate (scoreboard) team names
   $g_alias = array();

   // The following array defines all "official" teams competing in the contest
   $g_official = array();
    
   // The following array defines teams that are in "invisible" mode (ie. guests)
   $g_invisible = array();

   // The following array maps teams to their members
   $g_members = array();

   // -----------------------------------------------------------------------
   // Global variable initialization code
   // -----------------------------------------------------------------------

   session_start();
   date_default_timezone_set($g_timezone);
   
   // load the page title
   if ($fp = fopen($g_configfile, "r"))
   {
      flock($fp, LOCK_SH);
      $g_pagetitle = trim(fgets($fp));
      fclose($fp);
   }
   
   // load the teams
   if ($fp = fopen($g_teamfile, "r"))
   {
      flock($fp, LOCK_SH);
      while ($line = fgets($fp))
      {
         list($team, $pass, $official, $name, $members) = explode(";", trim($line));
         $g_teams[$team] =  $pass;
         if ($name)         $g_alias[$team] = htmlspecialchars($name);
         if ($members)      $g_members[$team] = htmlspecialchars($members);
         if ($official == 1)    $g_official[] = $team;
         if ($official == -1)   $g_invisible[] = $team;
      }
      fclose($fp);
   }
   
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
?>
