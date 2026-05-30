<script src="agenda_colaborador_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
    .modal-content1{
        width: 1200px;
    }
</style>
<form id="form">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h2><div class="ds_colaborador" ></div></h2>
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
                    <input type='text' class='form-control form-control-sm col-md-3' id='ds_ano' maxlength="4" name='ds_ano' required >
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12" align="center">

                    <button type="button" class="btn btn-secondary" id="cmdEnviar">Carregar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" align="center">
                    &nbsp;
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

<?
require_once "../inc/php/footer.php";
?>
