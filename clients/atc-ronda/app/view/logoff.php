<?
	session_start();
	session_destroy();
    echo "<script>";
    echo "top.location.href = '../index.php'";
    echo "</script>";

?>
