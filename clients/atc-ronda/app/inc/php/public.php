<?

require_once "../model/usuario.dao.php";

function DataYMD($strData){

	list($day, $month, $year) = explode('/', $strData);
	return $year."-".$month."-".$day;
}
function DataDMY($strData){
	list($year, $month, $day) = explode('/', $strData);
	return $day."/".$month."/".$year;
}

function redirecionar($strPagina){
    echo "<script>";
    echo "location.href = '".$strPagina."' ";
    echo "</script>";
}

function criarConstantesPost(){
    foreach(array_keys($_REQUEST) as $key){
        echo "var $key = '".$_REQUEST[$key]."'; ";
    }    
}

function tratar_request(){
    return $_REQUEST;
}

function remover_acentos($palavra){
   return preg_replace(array("/(Ç)/","/(ç)/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","C c a A e E i I o O u U n N"),$palavra);
}

function tratarToken($token){
    
    $arrTitulo = ["usuarios_pk", "ds_usuario", "ds_login", "dt_hora_login","colaboradores_pk","leads_pk"];
    $arrDados = json_decode(base64_decode($token), true);
    $arrRetorno["usuarios_pk"] = $arrDados["par1"];
    $arrRetorno["ds_usuario"] = $arrDados["par2"];
    $arrRetorno["ds_login"] = $arrDados["par3"];
    $arrRetorno["dt_validade_login"] = $arrDados["par4"];
    $arrRetorno["colaboradores_pk"] = $arrDados["par5"];
    $arrRetorno["leads_pk"] = $arrDados["par6"];
    $arrRetorno["contas_pk"] = $arrDados["par7"];
    
    return $arrRetorno;
    
}

function verificarLogin($token){
    
    $arrToken = tratarToken($token);
    
    $usuariodao = new usuariodao();
    $intExpirado = $usuariodao->verificarTempoLogado($arrToken["dt_validade_login"]);
 
    if($intExpirado == 0 || $arrToken['usuarios_pk'] == "" || $arrToken['usuarios_pk'] == "0" || $arrToken['usuarios_pk']==0){
        redirecionar("../index.php");
    }
    
}

function permissao($ds_dominio_modulo, $ic_acao, $token){

        $arrToken = tratarToken($token);
        
	$usuarios_pk = $arrToken['usuarios_pk'];
        
	$usuariodao = new usuariodao();
        $total = $usuariodao->verificarPermissao($usuarios_pk,$ds_dominio_modulo,$ic_acao);
        
	if($total > 0)
            return true;
	else
            return false;

}

function permissao_dados(){
    
}

//Função que verifica a extensão
function extensao($arquivo){
    
    $tam = strlen($arquivo);
    //ext de 3 chars
    if( $arquivo[($tam)-4] == '.' )
    {
    $extensao = substr($arquivo,-3);
    }

    //ext de 4 chars
    elseif( $arquivo[($tam)-5] == '.' )
    {
    $extensao = substr($arquivo,-4);
    }

    //ext de 2 chars
    elseif( $arquivo[($tam)-3] == '.' )
    {
    $extensao = substr($arquivo,-2);
    }

    //Caso a extensão não tenha 2, 3 ou 4 chars ele não aceita e retorna Nulo.
    else
    {
    $extensao = NULL;
    }
    return $extensao;
}
function moeda2float($moeda){
    $moeda = str_replace(".","", $moeda);
    $moeda = str_replace(",",".", $moeda);
    return $moeda;
}

function primeiroDiaMes($data){
	$arrData = explode("/", $data);
	return  "01/".$arrData[1]."/".$arrData[2];
}

function ultimoDiaMes($newData){	
    $usuariodao = new usuariodao();
    $strRetorno = "";
    $strRetorno = $usuariodao->verificarTempoLogado($newData);
    
    return $strRetorno;
}

function pegarDiaMes($n_mes,$n_ano){

    //pegar primeiro dia do mês
    $dt_ini_mes = primeiroDiaMes("01/".$n_mes."/".$n_ano);
    //Pegar ultimo dia do mês
    $dt_fim_mes = ultimoDiaMes($dt_ini_mes);
    
    for ($d = 1; $d <= $dt_fim_mes; $d++ ){
        echo $d."/".$n_mes."/".$n_ano."<br>";
    }
}

function pegarDiasSemana($dt_periodo_ini,$dt_periodo_fim) {

    list($ano1,$mes1,$dia1) = explode("-",$dt_periodo_ini);
    list($ano2,$mes2,$dia2) = explode("-",$dt_periodo_fim);

    $fimMK = mktime(0,0,0,$mes2,$dia2,$ano2);

    for ($i=0;$i>=0;$i++) {
        $calcula = mktime(0,0,0,$mes1,$dia1+$i,$ano1);
        if (date('w',$calcula) == 0) {
                $dom++;
        }
        if (date('w',$calcula) == 1) {
                $seg++;
        }
        if (date('w',$calcula) == 2) {
                $ter++;
        }
        if (date('w',$calcula) == 3) {
                $qua++;
        }
        if (date('w',$calcula) == 4) {
                $qui++;
        }
        if (date('w',$calcula) == 5) {
                $sex++;
        }
        if (date('w',$calcula) == 6) {
                $sab++;
        }
        if ($calcula == $fimMK) {
                break;
        }
    }

    return array('0' => $dom,'1' => $seg,'2' => $ter,'3' => $qua,'4' => $qui,'5' => $sex,'6'=> $sab);
}
function pegarDiasSemanaDia($dt_base) {

    list($ano1,$mes1,$dia1) = explode("-",$dt_base);

    
        $calcula = mktime(0,0,0,$mes1,$dia1+$i,$ano1);
        
        if (date('w',$calcula) == 0) {
                $dia_semana = 0;
        }
        if (date('w',$calcula) == 1) {
                $dia_semana = 1;
        }
        if (date('w',$calcula) == 2) {
                $dia_semana = 2;
        }
        if (date('w',$calcula) == 3) {
                $dia_semana = 3;
        }
        if (date('w',$calcula) == 4) {
                $dia_semana = 4;
        }
        if (date('w',$calcula) == 5) {
                $dia_semana = 5;
        }
        if (date('w',$calcula) == 6) {
                $dia_semana = 6;
        }
    

    return $dia_semana;
}

function formatCnpjCpf($value){
  $cnpj_cpf = preg_replace("/\D/", '', $value);
  
  if (strlen($cnpj_cpf) === 11) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } 
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function calculaTempo($hora_inicial, $hora_final) {
    $i = 1;
    $tempo_total;

    
   $tempos = array($hora_final, $hora_inicial);

   foreach($tempos as $tempo) {
    $segundos = 0;

    list($h, $m, $s) = explode(':', $tempo);

    $segundos += $h * 3600;
    $segundos += $m * 60;
    $segundos += $s;

    $tempo_total[$i] = $segundos;
 
    $i++;
    }
    $segundos = $tempo_total[1] - $tempo_total[2];

    $horas = floor($segundos / 3600);
    $segundos -= $horas * 3600;
    $minutos = str_pad((floor($segundos / 60)), 2, '0', STR_PAD_LEFT);
    $segundos -= $minutos * 60;
    $segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);

    return "$horas:$minutos:$segundos";
}
function converterHoraPMinuto($hora_inicial) {
    
    $i = 1;
    $tempo_total;


   $tempos = array($hora_inicial, $hora_inicial);

   foreach($tempos as $tempo) {
    $segundos = 0;

    list($h, $m, $s) = explode(':', $tempo);

    $segundos += $h * 3600;
    $segundos += $m * 60;
    $segundos += $s;
 
    $i++;
    }

    return $segundos;
}



//DISTANCIA
function fcCalcularDistanciaEntrePontos($lat1, $lon1, $lat2, $lon2) {

$lat1 = deg2rad($lat1);
$lat2 = deg2rad($lat2);
$lon1 = deg2rad($lon1);
$lon2 = deg2rad($lon2);

$latD = $lat2 - $lat1;
$lonD = $lon2 - $lon1;

$dist = 2 * asin(sqrt(pow(sin($latD / 2), 2) +
cos($lat1) * cos($lat2) * pow(sin($lonD / 2), 2)));
$dist = $dist * 6371;
return number_format($dist, 2, '.', '');
}

//echo distancia(-23.74166343862528, -46.69030168842569, -23.612536242949325, -46.68306438656564) . " Km<br />";



function fcTransformarCoordenadasEmEndereco($lat,$lon){
    $geo= array();


    // Daqui em diante é o seu código original
    $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lon.'&key=AIzaSyDPW_otpl6OaPuRTTnrLUP0-NiKm1Pb6OA');
   
    $output = json_decode($geocode);
    $endereco_completo = $output->results[1]->address_components[1]->long_name.",".$output->results[1]->address_components[2]->long_name." - ".$output->results[1]->address_components[3]->long_name;

    $geo['endereco'] = $endereco_completo;
    
    return ($geo['endereco']);
}

//echo fcTransformarCoordenadasEmEndereco(-23.74166343862528, -46.69030168842569) ;

function fcTransformarEnderecoEmCoordenadas($endereco){
    $addr = str_replace(" ", "+", $endereco); // Substitui os espaços por + "Rua+Paulo+Guimarães,+São+Paulo+-+SP" conforme padrão 'maps.google.com'
    $address = utf8_encode($addr); // Codifica para UTF-8 para não dar 'pau' no envio do parâmetro


    $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyDPW_otpl6OaPuRTTnrLUP0-NiKm1Pb6OA');
    $output = json_decode($geocode);
    $lat = $output->results[0]->geometry->location->lat;
    $long = $output->results[0]->geometry->location->lng;
    $geo['lat'] = $lat;
    $geo['long'] = $long;

    return $geo['lat'].",".$geo['long'];
}






?>
