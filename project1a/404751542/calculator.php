<html>
  <p>
    <form method="GET">
      <input type="text" name="expr"><br>
      <input type="submit" value="Calculate">
    </form>
  </p>
  <?php
    set_error_handler("error_handler", E_ALL);
    try {
      if (!empty($_GET['expr'])) {
        if(preg_match('/[^0-9\+\-\*\.\/]+/',$_GET['expr'],$matches, PREG_OFFSET_CAPTURE)===1)
          echo 'Invalid Expression!';
        else {
          $sol= eval('return '.$_GET['expr'].';');
          echo $_GET['expr'].'='.$sol;
        }
      }
    } catch (Exception $e) {
      echo 'Invalid Expression!';
    }
    function error_handler($errno, $errstr) {
      throw new ErrorException('', $errno);
    }
  ?>
</html>
