<?
    require_once "pre_header.php";
?>
<html>
    <head>

    <?require_once PATH.'inc/php/scripts.php';?>
    <script>

        <?        
            criarConstantesPost();     
        ?>

var span = document.querySelector("#time");

countDown(0);
function countDown(counter) {
    
    var interval = setInterval(function() {
    var minutes = ((counter / 60) | 0) + "";
    var seconds = (counter % 60) + "";
    var format = "" +

    new Array(3 - minutes.length).join("0") + minutes + ":" + new Array(3 - seconds.length).join("0") + seconds;
    
    //span.innerHTML = format;
    counter++;
    
        if (seconds == 599) {
            // Verifica se exite Retorno em aberto    
            var url = "../controller/retorno.controller.php?job=listarRerornoPopUp&token="+token; 

            //pega as informações
            $.getJSON(url, function(result) {
                for(i = 0; i < result.data.length; i++){
                   if(result.data[i]['t_qtde_retorno']>0){               

                        var width = 1100;
                        var height = 600;

                        var left = 250;
                        var top = 150;
                        var URL = "../view/retorno_popup.php?token="+token;
                        window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

                   }
                }
             });
             
            var url_whats = "../controller/retorno.controller.php?job=listarDataTablePopupWhats&token="+token; 

            //pega as informações
            $.getJSON(url_whats, function(result) {
                for(i = 0; i < result.data.length; i++){
                   if(result.data[i]['t_qtde_retorno']>0){
                       
                       var str =  result.data[i]['t_ds_cel'];
                        var telefone = str.replace(/[^\d]+/g,'');
                        var text = result.data[i]['t_ds_retorno'];
                        if(text==null){
                            text = "Retorno Pendente";
                        }
                        var urlw = "https://api.whatsapp.com/send?phone=55"+telefone+"&text="+text

                        window.open(urlw, '_blank');
                        
                   }
                }
             }); 
        }
    }, 1e3)
}

function timerReset() {
countDown(0);

}

function fcCarregarUsuario(){
    
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
  
    $("#usuario_login_sessao").text(arrCarregar.data[0]['ds_usuario']);
    
        
}
function fcPesquisarLead(){
    /*var arrCarregar = permissao("lead_pesquisar", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
    sendPost("pesquisar_lead_res.php", {token: token,pesquisar:$("#pesquisar").val()});
}

$(document).ready(function(){ 
   
    fcCarregarUsuario();     
    $(document).on('click', '#cmdPesquisarLead', fcPesquisarLead);
   
});
    </script>
	
	   
<?
//$link = basename($_SERVER['SCRIPT_NAME']);

//$_SESSION['link'] = basename($_SERVER['SCRIPT_NAME']);
?>
	<style>
		
		#ativo{
			color: #ffff66;
		}
	</style>
    </head>
<body>
<!-- MENU -->
<div id="menu_desabilitar_pop">
<nav class="navbar navbar-expand-lg navbar-dark " >
    <a class="navbar-brand" target="_new" href="http://www.gepros.com.br"><img class="img-responsive" src="https://gepros.com.br/comercial/condominios/img/logo_branco.png" > </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample05" >
        <ul class="navbar-nav mr-auto">
          <!--li class="nav-item">
              <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_dashboards.php');">
                  Dashboards
              </a>  
          </li-->
            <?if(permissao("menu_comercial", "cons", $token)){?>
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_leads.php" ? 'id="ativo"' : ''?>  class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_comercial.php');">
                        |&nbsp;&nbsp;&nbsp;Comercial
                    </a> 
                    
                </li>      
            <?}?>  

            
            <?if(permissao("menu_frota", "cons", $token)){?>
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_frota.php" ? 'id="ativo"' : ''?>  class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_frota.php');">
                        |&nbsp;&nbsp;&nbsp;Controle de Frota 
                    </a> 
                    
                </li>      
            <?}?>  

            <?if(permissao("menu_operacional", "cons", $token)){?>
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_operacao.php" ? 'id="ativo"' : ''?>  class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_operacao.php');">
                        |&nbsp;&nbsp;&nbsp;Operacional
                    </a> 
                    
                </li>      
            <?}?>  
          
            <?if(permissao("menu_tarefas", "cons", $token)){?>
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_tarefas.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/tarefas_res_form.php');">
                        |&nbsp;&nbsp;&nbsp;Tarefas
                    </a> 
                </li>      
            <?}?>                  
            <?if(permissao("menu_ocorrencias", "cons", $token)){?>
			
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_ocorrencias.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_ocorrencia_res_form.php');">
                        |&nbsp;&nbsp;&nbsp;Ocorrências
                    </a> 
                </li>      
            <?}?>                  
            <?if(permissao("menu_colaboradores", "cons", $token)){?>
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_colaboradores.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_colaborador_res_form.php');">
                    |&nbsp;&nbsp;&nbsp; Colaboradores
                    </a> 
                </li>      
            <?}?>    
            <?if(permissao("menu_documentos_cliente", "cons", $token)){?>
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_documentos_cliente.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_documentos_cliente.php');">
                    |&nbsp;&nbsp;&nbsp; Documentos
                    </a> 
                </li>      
            <?}?>                  
            <?if(permissao("menu_supervisao", "cons", $token)){?>
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_supervisao.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_supervisao.php');">
                    |&nbsp;&nbsp;&nbsp; Supervisão
                    </a> 
                </li>      
            <?}?>    
            <?if(permissao("menu_cadastros", "cons", $token)){?>    
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_cadastros.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_cadastros.php');">
                    |&nbsp;&nbsp;&nbsp;Compras - Estoque
                    </a> 
                </li>  
            <?}?>  
            <?if(permissao("menu_rh", "cons", $token)){?>    
                <li class="nav-item">
                    <a  <?= $_SESSION['link'] == "menu_rh.php" ? 'id="ativo"' : ""?>  class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_rh.php');">
                    |&nbsp;&nbsp;&nbsp;RH
                    </a> 
                </li>  
            <?}?>                  
            <?if(permissao("menu_financeiro", "cons", $token)){?> 
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_financeiro.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_financeiro.php');">
                    |&nbsp;&nbsp;&nbsp;Financeiro
                    </a> 
                </li>
            <?}?> 
            <?if(permissao("menu_administracao", "cons", $token)){?> 
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_administracao.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_administracao.php');">
                    |&nbsp;&nbsp;&nbsp;Administração
                    </a> 
                </li>  
            <?}?>  
            <?if(permissao("menu_relatorios", "cons", $token)){?>       
                <li class="nav-item">
                    
                    <a <?= $_SESSION['link'] == "menu_relatorios.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_relatorios.php');">
                    |&nbsp;&nbsp;&nbsp;Relatórios
                    </a> 
                </li>   
            <?}?>  
            <?if(permissao("menu_cpainel", "cons", $token)){?> 
                <li class="nav-item">
                    <a <?= $_SESSION['link'] == "menu_cpainel.php" ? 'id="ativo"' : ""?> class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_cpainel.php');">
                        |&nbsp;&nbsp;&nbsp;CPainel&nbsp;&nbsp;&nbsp;|
                    </a> 
                </li>  
            <?}?>    
                  
        </ul>
        <div class="form-inline mt-2 mt-md-0">
                <i class="fa fa-user" aria-hidden="true" style="font-size: 20px;color:white" ></i> 
                &nbsp;
                <div style="color:white" id="usuario_login_sessao"></div>&nbsp;&nbsp;
                 
                <a class="nav-link" style=" color: #ffffff; font-size: 18px "  href="javascript: abrirMenu('<?= PATH;?>view/logoff.php');">
                      Sair <i class="fa fa-power-off" aria-hidden="true" style="font-size: 20px;color:white" ></i> 
                </a>             
          

            <!--<input class="form-control-sm" type="text" id="pesquisar" placeholder="Pesquisar" aria-label="Pesquisar">
            &nbsp;
            <button class="btn btn-outline-warning btn-sm" type="button" id="cmdPesquisarLead">Pesquisar</button>-->

        </div>
    </div>
</nav>
</div>
<!-- FIM DO MENU -->

<main>
