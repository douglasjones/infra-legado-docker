<?
require_once "../inc/php/header.php";
?>
<script src="agenda_retorno_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
</style>

<form id="form">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h2><div class="" >Agenda de Retorno</div></h2>
            </div>
        </div>
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-2" align="center">
                    <label for="ic_mes">Mês:&nbsp;</label>
                    <select id="ic_mes" class="form-control form-control-sm col-md-6" name="ic_mes">
                        <option value=""></option>
                        <option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for='ds_ano'>Ano:&nbsp;</label>
                    <input type='text' class='form-control form-control-sm col-md-4' id='ds_ano' maxlength="4" name='ds_ano' required >
                </div>
                   
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-2">                    
                    <label for='agenda_equipes_pk'>Equipes&nbsp;</label>
                    <select class='form-control form-control-sm'  id='agenda_equipes_pk' name='agenda_equipes_pk' />
                        <option></option>
                    </select>  
                </div>
                <div class="col-md-2">                    
                    <label for='agenda_responsavel_pk'>Responsável&nbsp;</label>
                     <select class='form-control form-control-sm'  id='agenda_responsavel_pk' name='agenda_responsavel_pk' />
                         <option></option>
                     </select>         
                </div> 
            </div>  
            <br>
             <div class="row">
                <div class="col-md-12" align="center">

                    <button type="button" class="btn btn-primary"id="cmdEnviar">Carregar</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12" align="center">
                    Legenda
                 </div>
            </div>
            <div class="row">      
                <div class="col-md-4">
                    &nbsp;
                </div>    
                <div class="col-md-2"  style="background-color:#DFF0D8">
                    <div class="text-center">
                    Concluído
                    </div>
                </div> 
                <div class="col-md-2" style="background-color:#FF7373">
                    <div class="text-center">
                    Atrasado
                    </div>
                </div>                              
            </div>
            <br>
            <div class="row">
                <div class="col-md-12" align="center">

                </div>
            </div>
            <!-- 1º SEMANA--> 
            <div class="row">
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_anterior'>
                        <div class='col-xl-12'>
                            <div class='col-xl-12 dom'>Dom</div>                            
                        </div>                        
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_dom1"></div>                              
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_dom1_val" value="">
                            <div class="ds_lead_dom1"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_anterior'>
                        <div class='col-xl-12 seg'>Seg</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_seg1"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_seg1_val" value="">
                            <div class="ds_lead_seg1"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_anterior'>
                        <div class='col-xl-12 ter'>Ter</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                           <div id="dt_agenda_ter1"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_ter1_val" value="">
                            <div class="ds_lead_ter1"></div><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_anterior'>
                        <div class='col-xl-12 qua'>Qua</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            
                            <div id="dt_agenda_qua1"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qua1_val" value="">
                            <div class="ds_lead_qua1"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_anterior'>
                        <div class='col-xl-12 qui'>Qui</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qui1"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qui1_val" value="">
                           <div class="ds_lead_qui1"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">

                    <div class='row titulo_calendario_anterior'>
                        <div class='col-xl-12 sex'>Sex</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sex1"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sex1_val" value="">
                            <div class="ds_lead_sex1"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_anterior'>
                        <div class='col-xl-12 sab'>Sab</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sab1"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sab1_val" value="">
                            <div class="ds_lead_sab1"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
            </div>



            <!--2º Semana-->
            <div class="row">
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12'>
                            <div class='col-xl-12 dom'>Dom</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_dom2"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_dom2_val" value="">
                            <div class="ds_lead_dom2"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 seg'>Seg</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_seg2"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                            <input type="hidden" id="dt_agenda_seg2_val" value="">
                            <div class="ds_lead_seg2"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 ter'>Ter</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                           <div id="dt_agenda_ter2"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>                  
                            <input type="hidden" id="dt_agenda_ter2_val" value="">
                            <div class="ds_lead_ter2"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qua'>Qua</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qua2"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qua2_val" value="">
                           <div class="ds_lead_qua2"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qui'>Qui</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qui2"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qui2_val" value="">
                            <div class="ds_lead_qui2"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">

                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sex'>Sex</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sex2"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sex2_val" value="">
                            <div class="ds_lead_sex2"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sab'>Sab</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sab2"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sab2_val" value="">
                            <div class="ds_lead_sab2"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>  


            <!--3º Semana-->
            <div class="row">
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12'>
                            <div class='col-xl-12 dom'>Dom</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_dom3"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_dom3_val" value="">
                            <div class="ds_lead_dom3"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 seg'>Seg</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_seg3"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_seg3_val" value="">    
                            <div class="ds_lead_seg3"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 ter'>Ter</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                           <div id="dt_agenda_ter3"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_ter3_val" value="">
                            <div class="ds_lead_ter3"></div><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qua'>Qua</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qua3"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qua3_val" value="">
                           <div class="ds_lead_qua3"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qui'>Qui</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qui3"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qui3_val" value="">
                            <div class="ds_lead_qui3"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">

                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sex'>Sex</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sex3"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sex3_val" value="">
                            <div class="ds_lead_sex3"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sab'>Sab</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sab3"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sab3_val" value="">
                            <div class="ds_lead_sab3"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>  

            <!--4º Semana-->
            <div class="row">
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12'>
                            <div class='col-xl-12 dom'>Dom</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_dom4"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_dom4_val" value="">
                            <div class="ds_lead_dom4"></div><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 seg'>Seg</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_seg4"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_seg4_val" value="">
                            <div class="ds_lead_seg4"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 ter'>Ter</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                           <div id="dt_agenda_ter4"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                          <br>
                          <input type="hidden" id="dt_agenda_ter4_val" value="">
                            <div class="ds_lead_ter4"></div><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qua'>Qua</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qua4"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_quar4_val" value="">
                           <div class="ds_lead_qua4"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qui'>Qui</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qui4"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qui4_val" value="">
                            <div class="ds_lead_qui4"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">

                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sex'>Sex</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sex4"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sex4_val" value="">
                            <div class="ds_lead_sex4"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sab'>Sab</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sab4"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sab4_val" value="">
                            <div class="ds_lead_sab4"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>  

            <!--5º Semana-->
            <div class="row">
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12'>
                            <div class='col-xl-12 dom'>Dom</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_dom5"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_dom5_val" value="">
                            <div class="ds_lead_dom5"></div><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 seg'>Seg</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_seg5"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_seg5_val" value="">
                            <div class="ds_lead_seg5"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 ter'>Ter</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                           <div id="dt_agenda_ter5"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_ter5_val" value="">
                            <div class="ds_lead_ter5"></div><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qua'>Qua</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qua5"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qua5_val" value="">
                           <div class="ds_lead_qua5"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qui'>Qui</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qui5"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_qui5_val" value="">
                            <div class="ds_lead_qui5"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">

                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sex'>Sex</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sex5"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sex5_val" value="">
                            <div class="ds_lead_sex5"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sab'>Sab</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sab5"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sab5_val" value="">
                            <div class="ds_lead_sab5"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>  

            <!--6º Semana-->
            <div class="row">
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12'>
                            <div class='col-xl-12 dom'>Dom</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_dom6"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_dom6_val" value="">
                            <div class="ds_lead_dom6"></div><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 seg'>Seg</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_seg6"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_seg6_val" value="">
                            <div class="ds_lead_seg6"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 ter'>Ter</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                           <div id="dt_agenda_ter6"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_ter6_val" value="">
                            <div class="ds_lead_ter6"></div><br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qua'>Qua</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qua6"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                           <br>
                           <input type="hidden" id="dt_agenda_qua6_val" value="">
                           <div class="ds_lead_qua6"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 qui'>Qui</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_qui6"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_qui6_val" value="">
                            <div class="ds_lead_qui6"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">

                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sex'>Sex</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sex6"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sex6_val" value="">
                            <div class="ds_lead_sex6"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>

                </div>
                <div class="col-lg corpo">
                    <div class='row titulo_calendario_atual'>
                        <div class='col-xl-12 sab'>Sab</div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12 subtitulo_calendario'>
                            <div id="dt_agenda_sab6"></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-12'>
                            <br>
                            <input type="hidden" id="dt_agenda_sab6_val" value="">
                            <div class="ds_lead_sab6"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
    </div>
</form>
<?php  include("inc_ocorrencia_cad_form.php"); ?> 
<?
require_once "../inc/php/footer.php";
?>
