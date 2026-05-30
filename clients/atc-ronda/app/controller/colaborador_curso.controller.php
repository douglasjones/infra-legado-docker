<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/colaborador_curso.dao.php";
require_once "../model/colaborador_curso.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$colaboradores_pk = $arrRequest['colaboradores_pk'];
$cursos_pk = $arrRequest['cursos_pk'];
$dt_execucao = $arrRequest['dt_execucao'];
$dt_validacao = $arrRequest['dt_validacao'];


$colaborador_cursodao = new colaborador_cursodao();
$colaborador_cursodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $colaborador_curso = $colaborador_cursodao->carregarPorPk($pk);
        if($colaborador_curso->getpk()>0){
            
            $log_exclusaodao->salvar("colaborador_curso",$colaborador_curso->getpk());
            
            $colaborador_cursodao->excluir($colaborador_curso);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'colaborador_curso nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $colaborador_curso = $colaborador_cursodao->carregarPorPk($pk);
        $colaborador_curso->setcolaboradores_pk($colaboradores_pk);
        $colaborador_curso->setcursos_pk($cursos_pk);
        $colaborador_curso->setdt_execucao($dt_execucao);
        $colaborador_curso->setdt_validacao($dt_validacao);

        
        $pk = $colaborador_cursodao->salvar($colaborador_curso);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaborador_cursodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "cursos_pk"=>$query[$i]['cursos_pk'],
                    "dt_execucao"=>$query[$i]['dt_execucao'],
                    "dt_validacao"=>$query[$i]['dt_validacao']
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
        $query = $colaborador_cursodao->listar_por_colaboradores_pk($colaboradores_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "cursos_pk"=>$query[$i]['cursos_pk'],
                    "dt_execucao"=>$query[$i]['dt_execucao'],
                    "dt_validacao"=>$query[$i]['dt_validacao']
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
        $query = $colaborador_cursodao->listar_por_colaboradores_pk($colaboradores_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_cursos_pk"=>$query[$i]['cursos_pk'],
                    "t_dt_execucao"=>$query[$i]['dt_execucao'],
                    "t_dt_validacao"=>$query[$i]['dt_validacao'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarCursoColaboradores':{
        
        
        $resultado = "";
        $query = $colaborador_cursodao->listarCursoColaboradores($colaboradores_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "cursos_pk"=>$query[$i]['cursos_pk'],
                    "dt_execucao"=>$query[$i]['dt_execucao'],
                    "dt_validacao"=>$query[$i]['dt_validacao'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'RelatorioColaboradorCurso':{
        
        $dt_execucao_ini = $_REQUEST['dt_execucao_ini'];
        $dt_execucao_fim = $_REQUEST['dt_execucao_fim'];
        $dt_validacao_ini = $_REQUEST['dt_validacao_ini'];
        $dt_validacao_fim = $_REQUEST['dt_validacao_fim'];
        $resultado = "";
        $query = $colaborador_cursodao->RelatorioColaboradorCurso($colaboradores_pk,$cursos_pk,$dt_execucao_ini,$dt_execucao_fim,$dt_validacao_ini,$dt_validacao_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_curso"=>$query[$i]['ds_curso'],
                    "dt_execucao"=>$query[$i]['dt_execucao'],
                    "dt_validacao"=>$query[$i]['dt_validacao'],

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

$colaborador_cursodao = null;

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
