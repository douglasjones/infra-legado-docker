<?

require_once "../inc/php/public.php";

require_once "../inc/classes/bestflow/DataBase.php";

require_once "../model/usuario.dao.php";
require_once "../model/usuario.class.php";

require_once "../model/usuario_ponto.dao.php";
require_once "../model/usuario_ponto.class.php";

include_once "../model/enviar_email.dao.php";

include_once "../controller/layout.controller.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_usuario = $arrRequest['ds_usuario'];
$ds_login = $arrRequest['ds_login'];
$ds_senha = $arrRequest['ds_senha'];
$ds_email = $arrRequest['ds_email'];
$ds_cel = $arrRequest['ds_cel'];
$ic_status = $arrRequest['ic_status'];
$grupos_pk = $arrRequest['grupos_pk'];
$leads_pk = $arrRequest['leads_pk'];
$contas_pk = $arrRequest['contas_pk'];

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
$usuario_ponto_pk = $arrRequest['usuario_ponto_pk'];


$usuariodao = new usuariodao();
$usuariodao->setToken($token);

$usuario_pontodao = new usuario_pontodao();
$usuario_pontodao->setToken($token);


$enviar_emaildao = new enviar_emaildao();
$enviar_emaildao->setToken($token); 


switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $usuario = $usuariodao->carregarPorPk($pk);
        if($usuario->getpk()>0){
            
            $usuariodao->excluir($usuario);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'usuario nao encontrado';
        }
        break;
    }
    case 'salvar':{
 
        $usuario = $usuariodao->carregarPorPk($pk);
        $usuario->setds_usuario($ds_usuario);
        $usuario->setds_login($ds_login);
        $usuario->setds_senha($ds_senha);
        $usuario->setds_email($ds_email);
        $usuario->setds_cel($ds_cel);
        $usuario->setic_status($ic_status);
        $usuario->setgrupos_pk($grupos_pk);
        $usuario->setleads_pk($leads_pk);
        $usuario->setcontas_pk($contas_pk);
        
        $pk = $usuariodao->salvar($usuario);
        
        if($pk==""){
            $usuarios_pk = $usuario->getpk();
        }
        else{
            $usuarios_pk = $pk;
        }
                       
        $tags = 'canais,proteses,implantes';
        $tagsArray = explode(',', $ds_login);
        $termo = '@';
        
        if (in_array($termo, $tagsArray)) {
            if($pk!=""){
                $html =   layout::layoutUsuário($ds_usuario,$ds_email,$ds_senha); 

                $enviar_emaildao->enviaEmailAutenticado($html, /*De*/'gepros@gepros.com.br', /*Para*/$ds_login, "Login e Senha Novo Usuário","");

            }
        } 
                
        $mysql_data[] = array(
                "pk" => $pk
        );
        
        
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
     case 'listarTodosSemAdm':{
        
        $resultado = "";
        $query = $usuariodao->listarTodosSemAdm($ds_usuario);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_senha"=>$query[$i]['ds_senha'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "grupos_pk"=>$query[$i]['grupos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        
        break;
    }
    case 'listarAdmSistema':{      
        $resultado = "";
        $query = $usuariodao->listarAdmSistema();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "usuario_aprovacao_pk" => $query[$i]["usuario_aprovacao_pk"],
                    "ds_usuaario_aprovacao"=>$query[$i]['ds_usuaario_aprovacao']
                );
            }
        }
        else{
            $mysql_data = [];
        }
	
        
        break;
    }
    
    //antigo
    case 'listarPk':{
        
        $resultado = "";
        $query = $usuariodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_senha"=>$query[$i]['ds_senha'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
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
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "usuario_ponto_pk"=>$query[$i]['usuario_ponto_pk'],
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
        $query = $usuariodao->listar_por_ds_usuario_ativo($ds_usuario);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_senha"=>$query[$i]['ds_senha'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "grupos_pk"=>$query[$i]['grupos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        
        break;
    }
    case 'listarSupervisor':{
        
        $resultado = "";
        $query = $usuariodao->listar_supervisor($ds_usuario);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_senha"=>$query[$i]['ds_senha'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "grupos_pk"=>$query[$i]['grupos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listar_por_equipes':{
        
        $equipes_pk = $_REQUEST['equipes_pk'];
        $resultado = "";
        $query = $usuariodao->listar_supervisor($equipes_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_senha"=>$query[$i]['ds_senha'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "grupos_pk"=>$query[$i]['grupos_pk']
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
        $query = $usuariodao->listar_por_ds_usuario($ds_usuario);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],
                    "t_ds_login"=>$query[$i]['ds_login'],
                    "t_ds_senha"=>$query[$i]['ds_senha'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_grupo"=>$query[$i]['ds_grupo'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_grupos_pk"=>$query[$i]['grupos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarGrid':{
        $contas_pk = $_REQUEST['contas_pk'];         
        $grupos_pk = $_REQUEST['grupos_pk'];         
        $resultado = "";
        $query = $usuariodao->listarGrid($ds_usuario,$ic_status,$contas_pk,$grupos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],
                    "t_ds_login"=>$query[$i]['ds_login'],
                    "t_ds_senha"=>$query[$i]['ds_senha'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_grupo"=>$query[$i]['ds_grupo'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_grupos_pk"=>$query[$i]['grupos_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_conta"=>$query[$i]['ds_conta'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'autenticarUsuario':{

        $ds_login = $_REQUEST['ds_login'];
        $ds_senha = $_REQUEST['ds_senha'];
        
        $query = $usuariodao->listarLogin($ds_login, $ds_senha);
        
        if(count($query)==1){
            
            $tokenLogin = base64_encode(json_encode($query[0]));
            
            $mysql_data[] = array(
                "token" => $tokenLogin
            );
            $result  = 'success';
            $message = 'query success';

        }
        break;
    }    
    case 'verificarPermissao':{
        
        $token = $_REQUEST['token'];
        $ds_dominio_modulo = $_REQUEST['ds_dominio_modulo'];
        $ic_acao = $_REQUEST['ic_acao'];
        $arrToken = tratarToken($token);

	$usuarios_pk = $arrToken['usuarios_pk'];
        
        $total = $usuariodao->verificarPermissao($usuarios_pk,$ds_dominio_modulo,$ic_acao);
        
	if($total > 0){
            $result  = 'success';
            $message = 'query success';
        }else{
            $result  = 'error';
            $message = 'Você não tem permissão';
        }
        break;
    }    

    
    case 'listarUsuarioLogado':{
        
        $resultado = "";
        $query = $usuariodao->listarUsuarioLogado();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk" => $query[$i]["leads_pk"],
                    "grupos_pk" => $query[$i]["grupos_pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario']
                );
            }
        }else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    
    case 'listarPorGrupo':{

        $grupos_pk = $_REQUEST['grupos_pk'];
        $resultado = "";
        //if(permissao("responsavel_listar_todos", "cons", $token)){
            $query = $usuariodao->listar_por_grupos_pk($grupos_pk,$token);
            $result  = 'success';
            $message = 'query success';
        /*}
        else if(!permissao("responsavel_listar_equipes", "cons", $token)){
            $query = $usuariodao->listar_por_grupos_pk_equipes_pk($grupos_pk,$token);
            $result  = 'success';
            $message = 'query success';
        }
        else{          
            $mysql_data = [];
        }*/
        
        
        

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_senha"=>$query[$i]['ds_senha'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']    
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'trocarSenha':{
        
        $ds_login_novo = $_REQUEST['ds_login'];
        $ds_senha_novo = $_REQUEST['ds_nova_senha'];
        $ds_confirar_senha_novo = $_REQUEST['ds_cofirmar_senha'];
        
        
        
        if($ds_senha_novo != $ds_confirar_senha_novo){
            $result  = 'error';
            $message = 'Senhas Diferentes';
        }
        else{
            
            $usuario_pk = $usuariodao->listar_nome_login($ds_login_novo);
            if($usuario_pk==""){
                $result  = 'error';
                $message = 'Usuário não encontrado';
            }
            $query = $usuariodao->trocarSenha($usuario_pk,$ds_senha_novo);
        }
        
        
        //verifica login e senha
        $query = $usuariodao->listarLogin($ds_login_novo, $ds_senha_novo);

        if(count($query)==1){

            $tokenLogin = base64_encode(json_encode($query[0]));

            $mysql_data[] = array(
                "token" => $tokenLogin
            );
            $result  = 'success';
            $message = 'query success';

        }
        
        break;
    }
    
    case 'listarDadosCliente':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        $query = $usuariodao->listarDadosCliente($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_email"=>$query[$i]['ds_email']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }

    case 'listarTodosGestores':{
        
        $resultado = "";
        $query = $usuariodao->listarTodosGestores();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }

    case 'listarTodosAnalistas':{
        
        $resultado = "";
        $query = $usuariodao->listarTodosAnalistas();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }

    case 'listarGruposUsuario':{
        
        $resultado = "";
        $query = $usuariodao->listarGruposUsuario($usuarios_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_grupo"=>$query[$i]['ds_grupo']
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

$usuariodao = null;

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
