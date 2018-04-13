<html>
  <p>
    <form method="GET">
      <input type="text" name="expr"><br>
      <input type="submit" value="Calculate">
    </form>
  </p>
  <?php
    if (!empty($_GET['expr'])) {
      $response= $_GET['expr'];
      $sol= eval('return '.$response.';');
      if(preg_match('[+-*/.0-9]+',$_GET['expr']))
        echo 'Invalid Expression!';
      else
        echo $response.'='.$sol;
    }
  ?>
</html>
