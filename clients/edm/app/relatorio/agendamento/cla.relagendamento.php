<?
function pwcrypt($pass){
	$ret = crypt($pass, "gepros");
	return $ret;
}
?>