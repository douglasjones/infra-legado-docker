<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/usuario_ponto.dao.php";
require_once "../model/usuario_ponto.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$hr_entrada_dom = $arrRequest['hr_entrada_dom'];
$hr_saida_dom = $arrRequest['hr_saida_dom'];
$hr_entrada_seg = $arrRequest['hr_entrada_seg'];
$hr_saida_seg = $arrRequest['hr_saida_seg'];
$hr_entrada_ter = $arrRequest['hr_entrada_ter'];
$hr_saida_ter = $arrRequest['hr_saida_ter'];
$hr_entrada_qua = $arrRequest['hr_entrada_qua'];
$hr_saida_qua = $arrRequest['hr_saida_qua'];
$hr_entrada_qui = $arrRequest['hr_entrada_qui'];
$hr_saida_qui = $arrRequest['hr_saida_qui'];
$hr_entrada_sex = $arrRequest['hr_entrada_sex'];
$hr_saida_sex = $arrRequest['hr_saida_sex'];
$hr_entrada_sab = $arrRequest['hr_entrada_sab'];
$hr_saida_sab = $arrRequest['hr_saida_sab'];
$ic_dom = $arrRequest['ic_dom'];
$ic_seg = $arrRequest['ic_seg'];
$ic_ter = $arrRequest['ic_ter'];
$ic_qua = $arrRequest['ic_qua'];
$ic_qui = $arrRequest['ic_qui'];
$ic_sex = $arrRequest['ic_sex'];
$ic_sab = $arrRequest['ic_sab'];
$turnos_pk_dom = $arrRequest['turnos_pk_dom'];
$turnos_pk_seg = $arrRequest['turnos_pk_seg'];
$turnos_pk_ter = $arrRequest['turnos_pk_ter'];
$turnos_pk_qua = $arrRequest['turnos_pk_qua'];
$turnos_pk_qui = $arrRequest['turnos_pk_qui'];
$turnos_pk_sex = $arrRequest['turnos_pk_sex'];
$turnos_pk_sab = $arrRequest['turnos_pk_sab'];
$usuarios_pk = $arrRequest['usuarios_pk'];
$ic_registrar_ponto = $arrRequest['ic_registrar_ponto'];


$usuario_pontodao = new usuario_pontodao();
$usuario_pontodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $usuario_ponto = $usuario_pontodao->carregarPorPk($pk);
        if($usuario_ponto->getpk()>0){
            
            $usuario_pontodao->excluir($usuario_ponto);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'usuario_ponto nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $usuario_ponto = $usuario_pontodao->carregarPorPk($pk);
        $usuario_ponto->sethr_entrada_dom($hr_entrada_dom);
        $usuario_ponto->sethr_saida_dom($hr_saida_dom);
        $usuario_ponto->sethr_entrada_seg($hr_entrada_seg);
        $usuario_ponto->sethr_saida_seg($hr_saida_seg);
        $usuario_ponto->sethr_entrada_ter($hr_entrada_ter);
        $usuario_ponto->sethr_saida_ter($hr_saida_ter);
        $usuario_ponto->sethr_entrada_qua($hr_entrada_qua);
        $usuario_ponto->sethr_saida_qua($hr_saida_qua);
        $usuario_ponto->sethr_entrada_qui($hr_entrada_qui);
        $usuario_ponto->sethr_saida_qui($hr_saida_qui);
        $usuario_ponto->sethr_entrada_sex($hr_entrada_sex);
        $usuario_ponto->sethr_saida_sex($hr_saida_sex);
        $usuario_ponto->sethr_entrada_sab($hr_entrada_sab);
        $usuario_ponto->sethr_saida_sab($hr_saida_sab);
        $usuario_ponto->setic_dom($ic_dom);
        $usuario_ponto->setic_seg($ic_seg);
        $usuario_ponto->setic_ter($ic_ter);
        $usuario_ponto->setic_qua($ic_qua);
        $usuario_ponto->setic_qui($ic_qui);
        $usuario_ponto->setic_sex($ic_sex);
        $usuario_ponto->setic_sab($ic_sab);
        $usuario_ponto->setturnos_pk_dom($turnos_pk_dom);
        $usuario_ponto->setturnos_pk_seg($turnos_pk_seg);
        $usuario_ponto->setturnos_pk_ter($turnos_pk_ter);
        $usuario_ponto->setturnos_pk_qua($turnos_pk_qua);
        $usuario_ponto->setturnos_pk_qui($turnos_pk_qui);
        $usuario_ponto->setturnos_pk_sex($turnos_pk_sex);
        $usuario_ponto->setturnos_pk_sab($turnos_pk_sab);
        $usuario_ponto->setusuarios_pk($usuarios_pk);
        $usuario_ponto->setic_registrar_ponto($ic_registrar_ponto);

        
        $pk = $usuario_pontodao->salvar($usuario_ponto);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $usuario_pontodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "hr_entrada_dom"=>$query[$i]['hr_entrada_dom'],
                    "hr_saida_dom"=>$query[$i]['hr_saida_dom'],
                    "hr_entrada_seg"=>$query[$i]['hr_entrada_seg'],
                    "hr_saida_seg"=>$query[$i]['hr_saida_seg'],
                    "hr_entrada_ter"=>$query[$i]['hr_entrada_ter'],
                    "hr_saida_ter"=>$query[$i]['hr_saida_ter'],
                    "hr_entrada_qua"=>$query[$i]['hr_entrada_qua'],
                    "hr_saida_qua"=>$query[$i]['hr_saida_qua'],
                    "hr_entrada_qui"=>$query[$i]['hr_entrada_qui'],
                    "hr_saida_qui"=>$query[$i]['hr_saida_qui'],
                    "hr_entrada_sex"=>$query[$i]['hr_entrada_sex'],
                    "hr_saida_sex"=>$query[$i]['hr_saida_sex'],
                    "hr_entrada_sab"=>$query[$i]['hr_entrada_sab'],
                    "hr_saida_sab"=>$query[$i]['hr_saida_sab'],
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "turnos_pk_dom"=>$query[$i]['turnos_pk_dom'],
                    "turnos_pk_seg"=>$query[$i]['turnos_pk_seg'],
                    "turnos_pk_ter"=>$query[$i]['turnos_pk_ter'],
                    "turnos_pk_qua"=>$query[$i]['turnos_pk_qua'],
                    "turnos_pk_qui"=>$query[$i]['turnos_pk_qui'],
                    "turnos_pk_sex"=>$query[$i]['turnos_pk_sex'],
                    "turnos_pk_sab"=>$query[$i]['turnos_pk_sab'],
                    "usuarios_pk"=>$query[$i]['usuarios_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $usuario_pontodao->listar_por_hr_entrada_dom($hr_entrada_dom);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "hr_entrada_dom"=>$query[$i]['hr_entrada_dom'],
                    "hr_saida_dom"=>$query[$i]['hr_saida_dom'],
                    "hr_entrada_seg"=>$query[$i]['hr_entrada_seg'],
                    "hr_saida_seg"=>$query[$i]['hr_saida_seg'],
                    "hr_entrada_ter"=>$query[$i]['hr_entrada_ter'],
                    "hr_saida_ter"=>$query[$i]['hr_saida_ter'],
                    "hr_entrada_qua"=>$query[$i]['hr_entrada_qua'],
                    "hr_saida_qua"=>$query[$i]['hr_saida_qua'],
                    "hr_entrada_qui"=>$query[$i]['hr_entrada_qui'],
                    "hr_saida_qui"=>$query[$i]['hr_saida_qui'],
                    "hr_entrada_sex"=>$query[$i]['hr_entrada_sex'],
                    "hr_saida_sex"=>$query[$i]['hr_saida_sex'],
                    "hr_entrada_sab"=>$query[$i]['hr_entrada_sab'],
                    "hr_saida_sab"=>$query[$i]['hr_saida_sab'],
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "turnos_pk_dom"=>$query[$i]['turnos_pk_dom'],
                    "turnos_pk_seg"=>$query[$i]['turnos_pk_seg'],
                    "turnos_pk_ter"=>$query[$i]['turnos_pk_ter'],
                    "turnos_pk_qua"=>$query[$i]['turnos_pk_qua'],
                    "turnos_pk_qui"=>$query[$i]['turnos_pk_qui'],
                    "turnos_pk_sex"=>$query[$i]['turnos_pk_sex'],
                    "turnos_pk_sab"=>$query[$i]['turnos_pk_sab'],
                    "usuarios_pk"=>$query[$i]['usuarios_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $usuario_pontodao->listar_por_hr_entrada_dom($hr_entrada_dom);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_hr_entrada_dom"=>$query[$i]['hr_entrada_dom'],
                    "t_hr_saida_dom"=>$query[$i]['hr_saida_dom'],
                    "t_hr_entrada_seg"=>$query[$i]['hr_entrada_seg'],
                    "t_hr_saida_seg"=>$query[$i]['hr_saida_seg'],
                    "t_hr_entrada_ter"=>$query[$i]['hr_entrada_ter'],
                    "t_hr_saida_ter"=>$query[$i]['hr_saida_ter'],
                    "t_hr_entrada_qua"=>$query[$i]['hr_entrada_qua'],
                    "t_hr_saida_qua"=>$query[$i]['hr_saida_qua'],
                    "t_hr_entrada_qui"=>$query[$i]['hr_entrada_qui'],
                    "t_hr_saida_qui"=>$query[$i]['hr_saida_qui'],
                    "t_hr_entrada_sex"=>$query[$i]['hr_entrada_sex'],
                    "t_hr_saida_sex"=>$query[$i]['hr_saida_sex'],
                    "t_hr_entrada_sab"=>$query[$i]['hr_entrada_sab'],
                    "t_hr_saida_sab"=>$query[$i]['hr_saida_sab'],
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    "t_turnos_pk_dom"=>$query[$i]['turnos_pk_dom'],
                    "t_turnos_pk_seg"=>$query[$i]['turnos_pk_seg'],
                    "t_turnos_pk_ter"=>$query[$i]['turnos_pk_ter'],
                    "t_turnos_pk_qua"=>$query[$i]['turnos_pk_qua'],
                    "t_turnos_pk_qui"=>$query[$i]['turnos_pk_qui'],
                    "t_turnos_pk_sex"=>$query[$i]['turnos_pk_sex'],
                    "t_turnos_pk_sab"=>$query[$i]['turnos_pk_sab'],
                    "t_usuarios_pk"=>$query[$i]['usuarios_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    default:{
        break;
    }
}

$usuario_pontodao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
