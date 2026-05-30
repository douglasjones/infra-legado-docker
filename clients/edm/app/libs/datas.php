<?php 
function DataYMD($strData){
	list($day, $month, $year) = split('[/.-]', $strData);
	return $year."-".$month."-".$day;
}
function DataDMY($strData){
	list($year, $month, $day) = split('[/.-]', $strData);
	return $day."-".$month."-".$year;
}

function somar_dias_uteis($str_data,$int_qtd_dias_somar = 7) {
 // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
 // Transforma para DATE - aaaa-mm-dd
 $str_data = substr($str_data,0,10);
 // Se a data estiver no formato brasileiro: dd/mm/aaaa
 // Converte-a para o padrão americano: aaaa-mm-dd
 if ( preg_match("@/@",$str_data) == 1 ) {
  $str_data = implode("-", array_reverse(explode("/",$str_data)));
 }
 $count_days = 0;
 $int_qtd_dias_uteis = 0;
 while ( $int_qtd_dias_uteis < $int_qtd_dias_somar ) {
  $count_days++;
  if ( ( $dias_da_semana = date('w', strtotime('+'.$count_days.' day')) ) != '0' && $dias_da_semana != '6' ) {
   $int_qtd_dias_uteis++;
  }
 }
 return date('d/m/Y',strtotime('+'.$count_days.' day',strtotime($str_data)));
}

function somar_dias($str_data,$int_qtd_dias_somar = 7) {
 // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
 // Transforma para DATE - aaaa-mm-dd
 $str_data = substr($str_data,0,10);
 // Se a data estiver no formato brasileiro: dd/mm/aaaa
 // Converte-a para o padrão americano: aaaa-mm-dd
 if ( preg_match("@/@",$str_data) == 1 ) {
  $str_data = implode("-", array_reverse(explode("/",$str_data)));
 }
 $count_days = 0;
 $int_qtd_dias_uteis = 0;
 while ( $int_qtd_dias_uteis < $int_qtd_dias_somar ) {
  $count_days++;
  $int_qtd_dias_uteis++;
 }
 return date('d/m/Y',strtotime('+'.$count_days.' day',strtotime($str_data)));
}
?>
