<?
require_once "../inc/php/header.php";
?>
<script src="calendario_escala_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<style>
    
@import "bourbon";
      .label-float{
  position: relative;
  padding-top: 13px;
}

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
}

.label-float input[type=text]{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 300px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  
  border-radius:0;
}

.label-float input[type=text]:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input[type=text]:placeholder{
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

.label-float input[type=text]:required:invalid + label{
  color: red;
}
.label-float input[type=text]:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input[type=text]:focus + label,
.label-float input[type=text]:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
.oc_modal{
    cursor:pointer;
}
.doc_modal{
    cursor:pointer;
}
.processo_modal{
    cursor:pointer;
}
</style>
<div id="loader">
    <p> 
    <div class="row">
        <div class="col-md-12" align="left">&nbsp;
            <h5> <font color="007bff"> &nbsp;Calendário de Escala(s) </font> </h5>
        </div>
    </div>
    <hr>
    <div class="row" align="center">
        <div class="col-md" >
            <button type="button" class="btn btn-light" id="cmdPreviousMes"  name="cmdPreviousMes"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
            &nbsp;<label id="ds_mes" style=" font-size: 20px"></label>&nbsp;
            <input type="hidden" id="mes_pk" value="mes_pk" >
            <button type="button" class="btn btn-light" id="cmdNextMes"  name="cmdNextMes"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>                    
            &nbsp;&nbsp; - &nbsp;&nbsp;
            <button type="button" class="btn btn-light" id="cmdPreviousAno"  name="cmdPreviousAno"><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
            &nbsp;<label id="ds_ano" style=" font-size: 20px" ></label>&nbsp;            
            <input type="hidden" id="ano_pk" value="ano_pk" >
            <button type="button" class="btn btn-light" id="cmdNextAno"  name="cmdNextAno"><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></button>                       
        </div> 
    </div>
    <p>
    <br>
        <div class="row col-md-12" align="center">
            <div class="col-md-4">
                &nbsp;
            </div> 
            <div class="col-md-4">
                <h6>Legenda</h6>
            </div> 
        </div>
        <br>
    <div class="row col-md-12" align="center">
           
       <div class="col-md-4">
            &nbsp;
        </div> 
        <!---- <div class="col-md-2 " style="background-color:e6df55">
            <div class="text-center" >
                <font> <b>Atraso de 10 Min até 14:59 Min</b></font> 
            </div>
        </div> 
        <div class="col-md-2 "  style="background-color:f99856;">
            <div class="text-center">
                    <font><b>Atraso de 15 Min até 24:59 Min</b></font> 
            </div>
        </div> ---->
        <div class="col-md-2 "  style="background-color:63ed83;">
            <div class="text-center">
                <font><b>Ponto registrado</b></font> 
            </div>
        </div>
        <div class="col-md-2 "  style="background-color:#FFFF73;">
            <div class="text-center">
                <font><b>Falta</b></font> 
            </div>
        </div>
        
        <div class="col-md-1">
            &nbsp;
        </div> 
    </div>

    <!--<div class="row" align="left">
        <div class="col-md-1">
            &nbsp;
        </div>
        <div class="col-md-10">
            <button type="submit" class="btn btn-primary" id="cmdEnviarAgenda"   name="cmdEnviarAgenda" >Salvar</button>
        </div>
    </div>    -->
    <!--<div class="row" align="left">
        <div class="col-md-1">
            &nbsp;
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-3 ">
                    Legenda de Status
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 " style="background-color:#68C39F;">
                    <div class="text-center" >
                        <font color="white">PONTO REGISTRADO</font> 
                        
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-3 " style="background-color:#D9A300;">
                    <div class="text-center" >
                        <font color="white">FOLGA</font> 
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-3" style="background-color:#00238C;">
                    <div class="text-center" >
                        <font color="white">FOLGA TRABALHADA</font> 
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-3 " style="background-color:#FF4D4D;">
                    <div class="text-center" >
                        <font color="white">FALTA</font> 
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-3 " style="background-color:#FFFF99;">
                    <div class="text-center" >
                        <font color="black">TROCA DE HORÁRIO</font> 
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-3" style="background-color:#EEEEEE;">
                    <div class="text-center" >
                        <font color="black">AFASTAMENTO</font> 
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-3 " style="background-color:#0080FF;">
                    <div class="text-center" >
                        <font color="white">FÉRIAS</font> 
                    </div>
                </div> 
            </div>
        </div>
    </div>-->
    <br>

    <div class='row'>    
        <div class="col-xl-12">   
            <form id="form" class="form">
                <input type="hidden" id="agenda_colaborador_padrao_pk" name="agenda_colaborador_padrao_pk" value="">
                <input type="hidden" id="colaborador_apontamento_pk" name="colaborador_apontamento_pk" value="">
                <input type="hidden" id="dt_dia_apontamento" name="dt_dia_apontamento" value="">
                <input type="hidden" id="origem" name="origem" value="calendario_escala">
                <table class="table table-striped table-bordered nowrap " style="width:100%;" id="tblResultado">
                    <thead>
                        <tr >     
                            <td>
                                <table style='width:800px'>
                                    <tr style='text-align:center; border: 1px solid silver;height:95px'>
                                        <th width='143'>
                                            <label for='agenda_contratos_pk'>Posto de Trabalho: </label><p>
                                            <select class='form-control form-control-sm chzn-select'  id='leads_pk' name='leads_pk' >
                                                 <option><option>
                                            </select> 
                                        </th>
                                        <th width='143'>
                                            <label for='colaboradores_pk_agenda'>Colaboradores: </label><p>
                                            <select class="form-control form-control-sm chzn-select" id="colaborador_calendario" name="colaborador_calendario">
                                                 <option></option>
                                            </select>
                                        </th >
                                        <th width='143'>
                                            <label for="produtos_servicos_pk">Qualificação:</label><p>
                                            <select id="produtos_servicos_pk" class="form-control form-control-sm chzn-select" name="produtos_servicos_pk">
                                                 <option value=""></option>
                                            </select>
                                        </th>
                                       <th width='143'>
                                           <label for="ds_caonta">Escala:</label><p>
                                            <select class='form-control form-control-sm chzn-select'  id='n_qtde_dias_semana' name='n_qtde_dias_semana' >
                                                <option value=''></option>
                                                <option value='1D'>1D</option>
                                                <option value='2D'>2D</option>
                                                <option value='3D'>3D</option>
                                                <option value='4D'>4D</option>
                                                <option value='4x1'>4x1</option>
                                                <option value='4x2'>4x2</option>
                                                <option value='5x1'>5x1</option>
                                                <option value='5x2'>5x2</option>
                                                <option value='6X1'>6X1</option>
                                                <option value='12x36'>12x36</option>
                                             </select>  
                                        </th>
                                        <th width='143'>
                                            <label for="ds_caonta">Tipo Escala:</label><p>
                                            <select class='form-control form-control-sm chzn-select'  id='tipo_escala_pk' name='tipo_escala_pk' />
                                                <option></option>
                                                <option value="1">Impar</option>
                                                <option value="2">Par</option>
                                            </select> 
                                        </th>                    
                                        <th width='143'>
                                            <label for="ds_caonta">Apontamento:</label><p>
                                            <select class='form-control form-control-sm chzn-select'  id='escala_pesq_agenda' name='escala_pesq_agenda' >
                                                <option value=''></option>
                                                <option value='1'>PONTO REGISTRADO</option>
                                                <option value='2'>FOLGA</option>
                                                <option value='3'>FOLGA TRABALHDA</option>
                                                <option value='4'>FALTA</option>
                                                <option value='5'>TROCA DE HORÁRIO</option>
                                                <option value='6'>AFASTAMENTO</option>
                                                <option value='7'>FÉRIAS</option>
                                             </select>
                                        </th>                                    
                                    </tr>
                                </table>
                            </td>
                            <td>
                                  <div id="tituloSemanasMesEscala"></div>         
                            </td>

                        </tr>
                    </thead>
                    <tbody id="listarDados">

                    </tbody>
                </table>
            </form>    
        </div>
        <!--<div class="col-xl-6" style="max-width: 100%;overflow-x: scroll;" >
            <table class="table" border="1"  style="width:100%;" id="tblEscala">
                <thead idth='200px' height='110px'>
                    <div id="tituloSemanasMesEscala"></div>
                </thead>
                <tbody >
                    <div id="listarEscalas"></div>              
                </tbody> 
            </table>    
        </div>   -->
    </div> 

<?include_once("apontamento_colaborador_cad_form.php")?>

<?
require_once "../inc/php/footer.php";
?>

