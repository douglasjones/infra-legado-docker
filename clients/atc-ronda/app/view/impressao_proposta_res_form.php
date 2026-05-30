<?
    require_once "../inc/php/header.php";
?>
<style>
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
.label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 350px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -webkit-appearance:none;
  border-radius:0;
}

.label-float input:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input::placeholder{
  color:transparent;
}

.label-float label{
  pointer-events: none;
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 13px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
}

.label-float input:required:invalid + label{
  color: red;
}
.label-float input:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input:focus + label,
.label-float input:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
    .titulo_calendario_anterior{
        background-color: #DFF0D8;
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
        background-color: #9fd3f6;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_seguinte{
        background-color: #FCF8E3;
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
    .borda{
        width:100px;
        height:100px;
        border:solid 1px;
        
      }
@media print{
   #noprint{
       display:none;
   }
}
page {
  
  display: inline-block;
  margin-top: 100px;
  margin-bottom: 100px;
  margin-left: 450px;
}
page[size="A4"] {
  width: 22cm;
  height: 29.7cm;
}
page[size="A4"][layout="portrait"] {
  width: 29.7cm;
  height: 21cm;
}
@media print {
  body,
  page {
    margin: 0;
    box-shadow: 0;
  }
}
table {
  width: 100%;
  font-size: 100%;
}
th,
tr:nth-child(even) {
  background-color: white
}

</style>
<script src="impressao_proposta_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div id="loader"></div>
<div class="container-fluid" id="exibir" style="display:none">
    <form id="dados" name="dados">
        <input type="hidden" id="vl_total_servicos" value="">
        <input type="hidden" id="vl_total_materiais" value="">
    </form>
    <div class="container col-sm-12">
        <div id="noprint">
            <div class="row" >
                &nbsp;&nbsp;&nbsp;
                <div class="col-md-12" align="center" >
                    <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" id="cmdImprimir" data-dismiss="modal">Imprimir</button>
                </div>
            </div>
            <div class='row'>
                &nbsp;&nbsp;&nbsp;
                <div class='col-md-12' align='center'>
                    <h4>Impressão Proposta</h4>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class='row'>
        <div class="col-md-3" >
           &nbsp;
        </div>
        <br><br><br><br>
        <div class="col-md-12" >
            <div  id="grid">
                <div align="center"  id="ds_info_cliente" style="border:solid 1px #CCCCCC;"> 
                
                </div>
                <p>
                <div class="col-md-12">
                    <div class="row" style="border:solid 1px #CCCCCC; background-color: #e2e2e2;">
                        <div class="col-md-7"  align='right'>
                            <b>
                                ORÇAMENTO Nº 
                                <span id="pk"> </span>
                            </b>
                        </div>
                        <div class="col-md-5"  align='right'>
                            <b>  
                            <span id="dt_proposta"></span>
                            </b>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="col-md-12">
                    <div class="col-md-12" style="background-color: #e2e2e2;border:solid 1px #CCCCCC;">
                        <b>
                            VALIDADE DA PROPOSTA:
                            <span id="dt_validade_proposta"> </span>
                        </b>
                    </div>
                </div>
                <br><br>
                <div class="col-md-12">
                    <table style="border:solid 1px #CCCCCC;">
                        <tr>
                            <th colspan="4" style="background-color: #e2e2e2;">
                                DADOS DO CLIENTE
                            </th> 
                        </tr>
                        <tr>
                            <td style="border:solid 2px #CCCCCC;">
                                <b>Cliente: </b>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <span id="ds_lead"></span>
                                <input type='hidden' id="leads_pk"></input>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                               <b> CNPJ/CPF: </b>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <span id="ds_cpf_cnpj"></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:solid 2px #CCCCCC;">
                                <b> Endereço: </b>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <span id="ds_endereco"></span>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <b> Cep: </b>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <span id="ds_cep"></span>
                            </td>
                        </tr>
                        <tr >
                            <td style="border:solid 2px #CCCCCC;">
                                <b> Cidade: </b>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <span id="ds_cidade"></span>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                               <b> Estado: </b>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <span id="ds_uf"></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:solid 2px #CCCCCC;">
                                <b> Telefone: </b>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <span id="ds_tel"></span>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                 <b> Email: </b>
                            </td>
                            <td style="border:solid 2px #CCCCCC;">
                                <span id="ds_email"></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="col-md-12" id="grid_produtos">
                </div>
                <br>
                <div class="col-md-12" id="grid_servicos">
                </div>
                <br>                
                <div class="col-md-12">
                    <!----------<div class="col-md-12" style="border:solid 1px #CCCCCC; background-color: #e2e2e2; height:2em;" align="right">
                       <b> 
                           PRODUTOS: 
                           <span id="ds_email"></span>
                       </b>
                    </div>-------->
                    <div class="col-md-12" style="border:solid 1px #CCCCCC; background-color: #e2e2e2; height:2em;" align="right">
                        <b> 
                            TOTAL: 
                           <span id="vl_total"></span>
                        </b>
                    </div>
                </div>
                <br><br>
                <div class="col-md-12">
                    <div style="border:solid 1px #CCCCCC; background-color: #e2e2e2; height:2em;">
                        <b>Observações</b>
                    </div>
                    <div>
                        <span id="observacao"></span>
                    </div>
                </div>
                <br><br><br><br><br><br>
                <div class="col-md-12">
                    <div style="border:solid 0.5px" align="center">
                        <br>
                        _________________________________________________________________
                        <br>
                        Assinatura Cliente
                    </div>
                </div>

           </div> 
        </div>
    </div>
</div>

<?
require_once "../inc/php/footer.php";
?>