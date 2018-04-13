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
    echo $response.'='.$sol;
    
    }
  ?>
</html>
