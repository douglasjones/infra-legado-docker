<?
//recebe o token 

$token = $_REQUEST['token'];

//Descriptografa o token 
$chaveDescriptografado = base64_decode($token); 
require_once "../inc/php/header.php";

?>  
<script>


$(document).ready(function()
    {
        
    //sendPost("teste.php", {token: token});
    
    var arrCarregarPermissaoAcesso = permissao("menu_tarefas", "cons");    
    if(arrCarregarPermissaoAcesso.result == 'success'){
        
        //sendPost("tarefa_res_form.php", {token: token});
    }
        

    }
);

</script>

<?
require_once "../inc/php/footer.php";
?>