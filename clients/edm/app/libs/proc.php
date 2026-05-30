<?
include_once "libs/conectar.php";

$link = conectar("1");

mysqli_select_db($link,'geprosco_demo');

$proc = "teste";

$res = mysqli_multi_query($link,"call ".$proc."('0',@retval,@error);SELECT @retval,@error"); 
//print $res;


  if ($result = mysqli_store_result($link) or die('erro01: ' . mysqli_error($link))) {
    echo "<b>Teams and players</b>:<br/>";
    while( $row = mysqli_fetch_row($result) ) {
      foreach( $row as $cell ) echo $cell, "&nbsp;";
      echo "<br/>";
    }

  }
  echo "<br/>";
  $link->next_result();
  $link->next_result(); // why call this twice? Bug in mysqli?
  if ($result = $link->store_result()) {
    echo "<b>Output parameters</b>:<br/>";
    if ( $row = $result->fetch_row() ) {
      printf( "retval = %d<br/>", $row[0]);
      printf( "error = %s<br/>", $row[1]);
    }
    $result->close();
  }

//	print"erro";



$link->close();



?>
