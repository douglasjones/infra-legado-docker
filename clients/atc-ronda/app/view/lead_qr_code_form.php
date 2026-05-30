
<?require_once "../inc/php/header.php";?>
<script src="lead_qr_code_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
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
.qr-code-generator {
    width: 500px;
    margin: 0 auto;
}

.qr-code-generator * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

#qrcode {
    width: 128px;
    height: 128px;
    margin: 0 auto;
    text-align: center;
}

#qrcode a {
    font-size: 0.8em;
}

.qr-url, .qr-size {
    padding: 0.5em;
    border: 1px solid #ddd;
    border-radius: 2px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.qr-url {
    width: 79%;
}

.qr-size {
width: 20%;
}

.generate-qr-code {
    display: block;
    width: 100%;
    margin: 0.5em 0 0;
    padding: 0.25em;
    font-size: 1.2em;
    border: none;
    cursor: pointer;
    background-color: #e5554e;
    color: #fff;
}

</style>
<div id="loader"></div>
<div class="container-fluid" id="exibir" style="display:none">
    <div class="container col-sm-12">
        <div id="noprint">
            <br>
            <div class="row" >
                <br>
                <div class="col-md-12" align="center" >
                    <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" id="cmdImprimir" data-dismiss="modal">Imprimir</button>

                </div>

            </div>
            <br>
            <div class='row'>

                <div class='col-md-12' align='center'>
                    <h4>QR Code Colaboradores</h4>
                </div>
            </div>
            <div class='row'>
                <div class="col-sm-2">
                    &nbsp;
                </div>
                <div >
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;<b> Posto de Trabalho:</b> </label>
                </div>
                <div class='col-md-2'>
                    <div class='ds_lead_qr_code'></div>
                </div>
            </div>
            <div class='row'>
                <div class="col-sm-2">
                    &nbsp;
                </div>
                <div class="">
                    <label class="col-xs-2 control-label"><b>&nbsp;&nbsp;&nbsp;&nbsp;Endereço:</b> </label>
                </div>
                <div class='col-md-8'>
                    <div class='ds_endereco_qr_code'></div>
                </div>
            </div>
            <div class='row'>
                <div class="col-sm-2">
                    &nbsp;
                </div>
                <div class="">
                    <label class="col-xs-2 control-label"><b>&nbsp;&nbsp;&nbsp;&nbsp;Telefone:</b> </label>
                </div>
                <div class='col-md-2'>
                    <div id="ds_tel_qr_code"></div>
                </div>
            </div>
        </div>
        <br>
         
        <div id="grid"></div>
        </div>
        

        
</div>

<script type="text/javascript">

/*$(document).ready(function(){
    try {
        let website = "PR01-1";

        if (website) {
            let qrcodeContainer = $("qr_codePR01-1")
                qrcodeContainer.innerHTML = "";
                new QRCode(qrcodeContainer, website);
        } else {
            alert("Colaborador Invalido");
        }
            
    } catch (error) {
        alert(error)
    }
});*/
</script>
<?
require_once "../inc/php/footer.php";
?>
