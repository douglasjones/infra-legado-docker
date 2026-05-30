<?
require_once "../inc/php/header.php";
?>
<script src="lancamento_fatura_impressao.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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

body {
  
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
                    <h4>LANÇAMENTO FATURA</h4>
                </div>
            </div>
        </div>
        
    </div>
    <br>
   
    <div class='row'>
        <div class="col-md-3" >
           &nbsp;
        </div>
        <div class="col-md-7" >
           <div  id="grid"></div> 
        </div>
        <div class="col-md-2" >

        </div>
    </div>
  
</div>

<?
require_once "../inc/php/footer.php";
?>
