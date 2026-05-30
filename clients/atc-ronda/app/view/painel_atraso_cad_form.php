<?
require_once "../inc/php/header.php";

?>
<script src="painel_atraso_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
    .titulo_calendario_anterior{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_grid_produto_servico{
        background-color: #c3c3c3;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_atual{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_seguinte{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .subtitulo_calendario{
        text-align: center;
    }
    .corpo{
        border-right-style: dashed;
        border-right-width: thin;        
    }
    .modal-content1{
        width: 1200px;
    }
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
.galeria img:hover {
  -webkit-transform: scale(3.3);
  -moz-transform: scale(3.3);
  -o-transform: scale(3.3);
  -ms-transform: scale(3.3);
  transform: scale(3.3);
}
</style>
<div id="loader"></div>
<div class="container col" id="exibir" style="display:none">
    <div class="container col-md-12">
        <div class="row">
            <div class="col-md-8">
                &nbsp;
            </div>
        </div>   
        <div class="row ">
            <div class="col-md-12 col-lg-12 d-flex align-items-stretch">
                <div class="widthfull card card-shadow mb-12">
                    <div class="card-header">
                        <div class="card-title">
                            <b>Acompanhamento Pontos/Atrasos</b>
                        </div>
                        <div class="card-title">
                            <div id="dt_emissao"></div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form id="ocorrenciaForm" method="GET" style="margin-top: 1%">
                                    <div class="row mb-5">
                                        
                                        <div class="col-3" style="background-color: #63ed83;text-align: center">
                                            <b>Ponto Registrado</b>
                                        </div>
                                        <div class="col-3" style="background-color: #e6df55;text-align: center">
                                            <b>Atraso de 10 Min até 14:59 Min</b></div>
                                        <div class="col-3" style="background-color: #f99856;text-align: center">
                                            <b>Atraso de 15 Min até 24:59 Min</b></div>
                                        <div class="col-3" style="background-color: #ec1c24;text-align: center">
                                            <b>Atraso acima de 25 Min</b></div>

                                    </div>
                                    <div class="row">
                                        <div class="col-11 d-flex align-items-center">
                                            <input type="hidden" id="dt_ini">
                                            <input type="hidden" id="dt_fim">
                                            <div class="form-group m-0 p-0">
                                                <button type="button" id="cmdAtualizar"
                                                        class="btn btn-sm btn-primary btn-fill btn-finish">
                                                    Atualizar
                                                </button>
                                
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                            <table class="table no-wrap" id="tblResultado" width='1270px'>
                                <thead>
                                <tr>
                                        <th >
                                            <input style="width: 150px;" type='text' id='rxtPostoTrabalho' placeholder='Pesquisar por'/>
                                        </th>
                                        <th>
                                            <input style="width: 150px;" type='text' id='txtColaborador' placeholder='Pesquisar por'/>
                                        </th>
                                        <th>
                                            <input style="width: 150px;" type='text' id='txtRE' placeholder='Pesquisar por'/>
                                        </th>
                                        <th>
                                            <input style="width: 150px;" type='text' id='txtDsPin' placeholder='Pesquisar por'/>
                                        </th>
                                        <th>
                                            <input style="width: 150px;" type='text' id='txtEscala' placeholder='Pesquisar por'/>  
                                        </th> 
                                        <th>
                                            <input style="width: 150px;" type='text' id='txtAtraso' placeholder='Pesquisar por'/>
                                        </th>    
                                        
                                    </tr>

                                    <tr role="row">
                                        <th  align=center>Posto Trabalho</th>
                                        <th  align=center>Tel. Posto</th>
                                        <th >Colaborador</th>
                                        <th >Cel. Colaborador</th>
                                        <th >Horário Escala</th>
                                        <th >Tempo Atraso</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?
require_once "../inc/php/footer.php";
?>
