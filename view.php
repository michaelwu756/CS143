<?php
   include("./config.php");
   include("./Parsedown.php");
if (!isset($_GET["problem"])) {  //|| $_SESSION["contest_starts"] == 0) {
    exit("You do not have access to the file.");
}
else {
    $letter = $_GET["problem"];
    $title = Problem . " " . $letter;
    $text = file_get_contents($g_problempath . $letter.".txt");
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/2.4.1/github-markdown.min.css">
  <style>
.markdown-body {
        box-sizing: border-box;
        min-width: 200px;
        max-width: 980px;
        margin: 0 auto;
        padding: 45px;
    }
  </style>

  <script type="text/x-mathjax-config">
MathJax.Hub.Config({tex2jax: {
inlineMath: [['$','$'], ['\\(','\\)']],
    displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
}});
  </script>
  <script type="text/javascript" async
    src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_CHTML">
  </script>

  <?php echo "<title> $title </title>" ?>
</head>
<body>
<div class="markdown-body">
<?php
    $Parsedown = new Parsedown();
    echo $Parsedown->text($text);
?>
</div>

</body>
</html>
