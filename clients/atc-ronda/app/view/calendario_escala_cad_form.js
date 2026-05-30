var tblAgenda;
//COMBOS
function fcComboLeads() {
    var v_leads_pk = "";
    var objParametros = {
        "leads_pk": v_leads_pk
    };
    var arrCarregar = carregarController("lead", "listarLeadsCombo", objParametros)
    carregarComboAjax($("#leads_pk"), arrCarregar, "", "leads_pk", "ds_lead");
}

function fcColaborador() {

    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };

    var arrCarregar = carregarController("colaborador", "listarColaboradorLeadCalendario", objParametros);

    carregarComboAjax($("#colaborador_calendario"), arrCarregar, " ", "colaborador_pk", "ds_colaborador");
}

function fcQualificacao() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);
    carregarComboAjax($("#produtos_servicos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}

//controles
function fcMesAnoAtualCalendario() {
    var meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    var days = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
    var hoje = new Date();
    var dia = hoje.getDate();
    var mes = hoje.getMonth() + 1;
    var ano = hoje.getFullYear();
    var data = dia + '/' + mes + '/' + ano;
    //var formatData = data.replace(/(\d{2})(\/)(\d{2})/, "$3$2$1");      
    //var newData = new Date(formatData);    
    //console.log(newData.getDate() + ' ' + meses[newData.getMonth()] + ' (' +  days[newData.getDay()]+ ')');   
    //MESES

    $("#mes_pk").val(parseInt(hoje.getMonth()));
    $("#ds_mes").text(meses[hoje.getMonth()]);
    //MES ANTERIO

    $("#cmdPreviousMes").click(function () {
        if (parseInt($("#mes_pk").val()) == 0) {
            $("#ds_mes").text(meses[11])
            $("#mes_pk").val(parseInt(11));
            $("#ds_ano").text(parseInt($("#ano_pk").val()) - 1);
            $("#ano_pk").val(parseInt($("#ano_pk").val()) - 1);
        } else {
            $("#ds_mes").text(meses[parseInt($("#mes_pk").val()) - 1]);
            $("#mes_pk").val(parseInt($("#mes_pk").val()) - 1);
        }
        //fcSemanasEscalas();
        fcListarDados();
    });
    //PROXIMO MES
    $("#cmdNextMes").click(function () {
        if (parseInt($("#mes_pk").val()) == 11) {
            $("#ds_mes").text(meses[0])
            $("#mes_pk").val(parseInt(0));
            $("#ds_ano").text(parseInt($("#ano_pk").val()) + 1);
            $("#ano_pk").val(parseInt($("#ano_pk").val()) + 1);
        } else {
            $("#ds_mes").text(meses[parseInt($("#mes_pk").val()) + 1]);
            $("#mes_pk").val(parseInt($("#mes_pk").val()) + 1);
        }
        //fcSemanasEscalas();
        fcListarDados();
    });
    //ANO
    $("#ano_pk").val(parseInt(hoje.getFullYear()));
    $("#ds_ano").text(parseInt(hoje.getFullYear()));

    //ANO ANTERIOR
    $("#cmdPreviousAno").click(function () {
        $("#ds_ano").text(parseInt($("#ano_pk").val()) - 1);
        $("#ano_pk").val(parseInt($("#ano_pk").val()) - 1);
        //fcSemanasEscalas();
        fcListarDados();
    });
    //PROXIMO MES   
    $("#cmdNextAno").click(function () {
        $("#ds_ano").text(parseInt($("#ano_pk").val()) + 1);
        $("#ano_pk").val(parseInt($("#ano_pk").val()) + 1);
        //fcSemanasEscalas();
        fcListarDados();
    });

    //fcSemanasEscalas();
    fcListarDados();
}

//CONTEUDO
/*function fcListarDados() {

    //Função lista os dados das colunas de dados
    $("#listarDados").html("");

    var semana = ["DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SAB"];
    var primeira_semana_mes = new Date($("#ano_pk").val(), $("#mes_pk").val(), 1, 0, 0, 0);
    var udm = (new Date($("#ano_pk").val(), parseInt($("#mes_pk").val()) + 1, 0, 0, 0, 0)).getDate();

    if ($("#mes_pk").val() == '10') {//correcao mes de novembro
        if (udm == '31') {
            udm = 30;
        }
    }
    var dias_semana = "";
    var dias_semana_li = "";
    var vhtml = "";
    var vhtml0 = "";
    var v_colaborador_pk = "";

    var mes = (parseInt($("#mes_pk").val()) + 1);

    var objParametros = {
        "mes_pk": mes,
        "ano_pk": $("#ano_pk").val(),
        "ultimo_dia_mes": udm,
        "leads_pk": $("#leads_pk").val(),
        "colaborador_pk": $("#colaborador_calendario").val(),
        "produtos_servicos_pk": $("#produtos_servicos_pk").val(),
        "n_qtde_dias_semana": $("#n_qtde_dias_semana").val(),
        "tipo_escala_pk": $("#tipo_escala_pk").val()
    };
    fcSemanasEscalas();
   // var arrCarregar = carregarController("agenda_colaborador_padrao", "calendarioDadosEscala", objParametros);
    var arrCarregar = carregarController("agenda_colaborador_padrao", "calendarioDados", objParametros);
    //NewWindow(v_last_url)
    
    if (arrCarregar.result == 'success') {

        vhtml += "<table class='table' border='1' style='width:800px;'  id='tblEscala' >";

        //Leads / Colaboradores
        if (arrCarregar.data[0]['pk'] != 0) {
            for (i = 0; i < arrCarregar.data.length; i++) {
                vhtml += "<tr style='height:80px;'>";
                //primeira coluna com dados de Postos e Colaboradores
                vhtml += "    <td align='center' style='background-color:#F5F5F5'>";
                vhtml += "        <table style='width:800px;'>";
                vhtml += "<tr style='height:50px;border: 1px solid; background-color:#F5f5f5' >";
                vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
                vhtml += arrCarregar.data[i]['ds_lead'];
                vhtml += "                </td>";
                vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
                vhtml += arrCarregar.data[i]['ds_colaborador'];
                vhtml += "                </td>";
                vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
                vhtml += arrCarregar.data[i]['ds_produto_servico'];
                vhtml += "                </td>";
                vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
                vhtml += arrCarregar.data[i]['n_qtde_dias_semana'];
                vhtml += "                </td>";
                vhtml += "                <td style='text-align:center;width:143px;border: 1px solid'>";
                vhtml += arrCarregar.data[i]['ds_tipo_escala'];
                vhtml += "                </td>";
                vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
                vhtml += "&nbsp;";
                vhtml += "                </td>";
                vhtml += "            </tr>";
                vhtml += "        </table>";
                vhtml += "    </td>";
                //Segunda Coluna Calandario escala
                vhtml += "    <td align='center' >";
                vhtml += "        <table  >";
                vhtml += "            <tr style='border: 1px solid;background-color:#ffffff;' >";


                for (h = 1; h < 7; h++) {
                    vhtml += "<td style='border: 1px solid; background-color:#ffffff'>";
                    vhtml += "    <table id='tblDadosEscala' style='width:600px; '>";
                    vhtml += "        <tr style='border: 1px solid;background-color:#ffffff'>";
                    for (j = 0; j < 7; j++) {
                        if (h == 1) {//verifica o inicio da primeira semana
                            if (semana[j] == semana[primeira_semana_mes.getDay()]) {
                                dias_semana = "1";//compara o primeiro dia da semana do mes
                            }
                        }
                        if (dias_semana <= udm) {//quantidade de dias do mes
                            var DadosDias = "";
                            var v_agenda_colaborador_padrao_pk = 0;
                            var v_colaborador_pk = arrCarregar.data[i]['colaborador_pk'];
                            var v_dt_dia = dias_semana;
                            var v_leads_pk = arrCarregar.data[i]['leads_pk'];

                            if (dias_semana != '') {//verifica se o contador de dias foi iniciado          

                                vhtml += "<td  style='font-size:12px;padding:0px;border: 1px solid silver;width:90px;'>";
                                for (x = 0; x < arrCarregar.data[i].DadosEscalaCalendario.length; x++) {


                                    if (arrCarregar.data[i].DadosEscalaCalendario[x].agenda_colaborador_padrao_pk == arrCarregar.data[i]['agenda_colaborador_padrao_pk']) {

                                        //Verifica se é o colaborador da linha
                                        if (arrCarregar.data[i].DadosEscalaCalendario[x].colaborador_pk == arrCarregar.data[i]['colaborador_pk']) {

                                            //verifica se é a mesma data do calendario
                                            //passa a separar dias impares e pares 

                                            if (arrCarregar.data[i].DadosEscalaCalendario[x].ds_dia == dias_semana) {

                                                //Verifica se tem apontamento
                                                if (arrCarregar.data[i].tipo_apontammento_pk == null) {

                                                    v_agenda_colaborador_padrao_pk = arrCarregar.data[i].DadosEscalaCalendario[x].agenda_colaborador_padrao_pk;
                                                    v_colaborador_pk = arrCarregar.data[i].DadosEscalaCalendario[x].colaborador_pk;
                                                    v_dt_dia = dias_semana;
                                                    v_leads_pk = arrCarregar.data[i]['leads_pk'];

                                                    //DadosDias+= "<div class='row' align='center' style='background-color:#68C39F;'>";
                                                    // DadosDias += "<div  style='font-size:12px;text-align:left;background-color:'>";
                                                    DadosDias += "<div style='padding:2px;font-size:12px;text-align:left;background:" + arrCarregar.data[i].DadosEscalaCalendario[x].ds_background + "'>";
                                                    DadosDias += "   <div class='row' height='1'>";
                                                    DadosDias += "       <div class='col-md-12'>";
                                                    //DadosDias+=          arrCarregar.data[i].DadosEscalaCalendario[x].agenda_colaborador_padrao_pk+"<p>";
                                                    //DadosDias+=             "<i class='fa fa-upload' aria-hidden='true' id='btn_apontamento' onclick='fcAbrirApontamentoDiafcAbrirApontamentoDia("+v_colaborador_pk+","+v_agenda_colaborador_padrao_pk+","+v_dt_dia+")' ></i> - "+arrCarregar.data[i].DadosEscalaCalendario[x].ds_tipo_escala+"<p>";

                                                    //DadosDias += "<i class='fa fa-upload' aria-hidden='true' id='btn_apontamento' onclick='fcAbrirApontamentoDia(" + v_colaborador_pk + "," + v_dt_dia + "," + v_leads_pk + ")' ></i> - " + arrCarregar.data[i].DadosEscalaCalendario[x].ds_tipo_escala + " - " + v_agenda_colaborador_padrao_pk + "<p>";
                                                    DadosDias += "<div style='text-align:left; margin:10px'  title='apontamento' class='abrirApontamento' onclick='fcAbrirApontamentoDia(" + v_colaborador_pk + ',"' + v_dt_dia + '",' + v_leads_pk + ")'><img width=15 height=20 src='../img/apontamento_colaborador.png'></div>";
                                                    //DadosDias += "<span style='text-align:center; margin:10px'>" + arrCarregar.data[i].DadosEscalaCalendario[x].ds_tipo_escala + "</span> - " + v_agenda_colaborador_padrao_pk;
                                                    DadosDias += "<span style='text-align:center; margin:10px'>" + arrCarregar.data[i].DadosEscalaCalendario[x].ds_tipo_escala + "</span>";
                                                    DadosDias += "<br>";

                                                    DadosDias += "       </div>";
                                                    DadosDias += "   </div>";


                                                    DadosDias += "</div>";
                                                }
                                            }
                                        }
                                    }
                                }
                                if (DadosDias == '') {

                                    //v_colaborador_pk = arrCarregar.data[i]['colaborador_pk'];
                                    v_leads_pk = arrCarregar.data[i]['leads_pk'];
                                    //v_dt_dia = dias_semana;
                                    DadosDias += "   <div class='row' >";
                                    DadosDias += "       <div class='col-md-12' style='width:90px;  margin:10px'>";

                                    //DadosDias += "<i class='fa fa-upload' aria-hidden='true' id='btn_apontamento' onclick='fcAbrirApontamentoDia(" + v_colaborador_pk + "," + v_agenda_colaborador_padrao_pk + "," + dias_semana + "," + v_leads_pk + ")' ></i>&nbsp;<p>";
                                    DadosDias += "<div title='apontamento' class='abrirApontamento' onclick='fcAbrirApontamentoDia(" + v_colaborador_pk + ',"' + v_dt_dia + '",' + v_leads_pk + ")'><img width=15 height=20 src='../img/apontamento_colaborador.png'></div>&nbsp;";
                                    DadosDias += "       </div>";
                                    DadosDias += "   </div>";
                                    DadosDias += "</div>";
                                }
                                vhtml += DadosDias;
                                vhtml += " </td>";
                                dias_semana++;
                            } else {
                                //Dias da semana anterior antes do inicio da semana
                                //vhtml += "<td style='font-size:12px;text-align: left;border: 1px solid silver;width:5px'>";
                                vhtml += "<td style='border: 1px solid silver' width:6px>";
                                DadosDias = "";
                                /* DadosDias += "<div  style='font-size:12px;text-align:left'>";
                                DadosDias += "   <div class='row' >";
                                DadosDias += "       <div class='col-md-12' style='width:5px'>";
                                 //DadosDias += "           &nbsp;";
                                DadosDias += "       </div>";
                                DadosDias += "   </div>";
                                DadosDias += "</div>";*/
                               /* vhtml += DadosDias;
                                vhtml += " </td>";
                            }
                        } else {
                            //vhtml += "<td style='font-size:12px;text-align: left;border: 1px solid silver;width:5px'>";
                            vhtml += "<td style='border: 1px solid silver;'  width:6px>";
                            DadosDias = "";
                            /* DadosDias += "<div  style='font-size:12px;text-align:left'>";
                            DadosDias += "   <div class='row' >";
                            DadosDias += "       <div class='col-md-12' style='width:5px'>";
                             //DadosDias += "           &nbsp;";
                            DadosDias += "       </div>";
                            DadosDias += "   </div>";
                            DadosDias += "</div>";*/
                           /* vhtml += DadosDias;
                            vhtml += " </td>";
                        }
                    }
                    vhtml += "        </tr>";
                    vhtml += "    </table>";
                    vhtml += "</td>";
                }
                vhtml += "            </tr>";
                vhtml += "        </table>";
                vhtml += "    </td>";
                vhtml += "</tr>";

            }
            vhtml += "</table>";
            //Carrega lista de dados
            $("#listarDados").html(vhtml);
            //carrega o tirulo do calendario

            vhtml = "";

            $("#listarEscalas").html(vhtml);
            $("#listarDados").show();
        }
    }
}*/


function fcListarDados() {
try{
//Função lista os dados das colunas de dados
$("#listarDados").html("");

var semana = ["DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SAB"];
var primeira_semana_mes = new Date($("#ano_pk").val(), $("#mes_pk").val(), 1, 0, 0, 0);
var udm = (new Date($("#ano_pk").val(), parseInt($("#mes_pk").val()) + 1, 0, 0, 0, 0)).getDate();

if ($("#mes_pk").val() == '10') {//correcao mes de novembro
    if (udm == '31') {
        udm = 30;
    }
}
var dias_semana = "";
var dias_semana_li = "";
var vhtml = "";
var vhtml0 = "";
var v_colaborador_pk = "";

var mes = (parseInt($("#mes_pk").val()) + 1);

var objParametros = {
    "mes_pk": mes,
    "ano_pk": $("#ano_pk").val(),
    "ultimo_dia_mes": udm,
    "leads_pk": $("#leads_pk").val(),
    "colaborador_pk": $("#colaborador_calendario").val(),
    "produtos_servicos_pk": $("#produtos_servicos_pk").val(),
    "n_qtde_dias_semana": $("#n_qtde_dias_semana").val(),
    "tipo_escala_pk": $("#tipo_escala_pk").val()
};
fcSemanasEscalas();
// var arrCarregar = carregarController("agenda_colaborador_padrao", "calendarioDadosEscala", objParametros);
var arrCarregar = carregarController("agenda_colaborador_padrao", "calendarioDados", objParametros);
//NewWindow(v_last_url)

if (arrCarregar.result == 'success') {

    vhtml += "<table class='table' border='1' style='width:800px;'  id='tblEscala' >";

    //Leads / Colaboradores
    if (arrCarregar.data.length > 0) {
        for (i = 0; i < arrCarregar.data.length; i++) {
            vhtml += "<tr style='height:80px;'>";
            //primeira coluna com dados de Postos e Colaboradores
            vhtml += "    <td align='center' style='background-color:#F5F5F5'>";
            vhtml += "        <table style='width:800px;'>";
            vhtml += "<tr style='height:50px;border: 1px solid; background-color:#F5f5f5' >";
            vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
            vhtml += arrCarregar.data[i]['ds_lead'];
            vhtml += "                </td>";
            vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
            vhtml += arrCarregar.data[i]['ds_colaborador'];
            vhtml += "                </td>";
            vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
            vhtml += arrCarregar.data[i]['ds_produto_servico'];
            vhtml += "                </td>";
            vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
            vhtml += arrCarregar.data[i]['n_qtde_dias_semana'];
            vhtml += "                </td>";
            vhtml += "                <td style='text-align:center;width:143px;border: 1px solid'>";
            vhtml += arrCarregar.data[i]['ds_tipo_escala'];
            vhtml += "                </td>";
            vhtml += "                <td style='text-align:center;width:143px;border: 1px solid' >";
            vhtml += "&nbsp;";
            vhtml += "                </td>";
            vhtml += "            </tr>";
            vhtml += "        </table>";
            vhtml += "    </td>";
            //Segunda Coluna Calandario escala
            vhtml += "    <td align='center' >";
            vhtml += "        <table  >";
            vhtml += "            <tr style='border: 1px solid;background-color:#ffffff;' >";


            for (h = 1; h < 7; h++) {
                vhtml += "<td style='border: 1px solid; background-color:#ffffff'>";
                vhtml += "    <table id='tblDadosEscala' style='width:600px; '>";
                vhtml += "        <tr style='border: 1px solid;background-color:#ffffff'>";
                for (j = 0; j < 7; j++) {
                    if (h == 1) {//verifica o inicio da primeira semana
                        if (semana[j] == semana[primeira_semana_mes.getDay()]) {
                            dias_semana = "01";//compara o primeiro dia da semana do mes
                        }
                    }
                    if (dias_semana <= udm) {//quantidade de dias do mes
                        var DadosDias = "";
                        var v_agenda_colaborador_padrao_pk = 0;
                        var v_colaborador_pk = arrCarregar.data[i]['colaborador_pk'];
                        var v_dt_dia = dias_semana;
                        var v_leads_pk = arrCarregar.data[i]['leads_pk'];

                        if (dias_semana != '') {//verifica se o contador de dias foi iniciado          

                            vhtml += "<td  style='font-size:12px;padding:0px;border: 1px solid silver;width:90px;'>";
                                for (x = 0; x < arrCarregar.data[i].dadosEscalaCalendario.length; x++) {
                                    //alert(x);

                                    if (arrCarregar.data[i].agenda_colaborador_padrao_pk == arrCarregar.data[i]['agenda_colaborador_padrao_pk']) {

                                        //Verifica se é o colaborador da linha
                                        if (arrCarregar.data[i].colaborador_pk == arrCarregar.data[i]['colaborador_pk']) {

                                            //verifica se é a mesma data do calendario
                                            //passa a separar dias impares e pares 

                                            if (arrCarregar.data[i].dadosEscalaCalendario[x].ds_dia == dias_semana) {

                                                //Verifica se tem apontamento
                                               // if (arrCarregar.data[i].tipo_apontammento_pk == null) {

                                                    v_agenda_colaborador_padrao_pk = arrCarregar.data[i].agenda_colaborador_padrao_pk;
                                                    v_colaborador_pk = arrCarregar.data[i].colaborador_pk;
                                                    v_dt_dia = dias_semana;
                                                    v_leads_pk = arrCarregar.data[i]['leads_pk'];

                                                    //DadosDias+= "<div class='row' align='center' style='background-color:#68C39F;'>";
                                                    // DadosDias += "<div  style='font-size:12px;text-align:left;background-color:'>";
                                                    DadosDias += "<div style='padding:2px;font-size:12px;text-align:left;background:"+ arrCarregar.data[i].dadosEscalaCalendario[x].ds_background + "'>";
                                                    DadosDias += "   <div class='row' height='1'>";
                                                    DadosDias += "       <div class='col-md-12'>";
                                                    //DadosDias+=          arrCarregar.data[i].dadosEscalaCalendario[x].agenda_colaborador_padrao_pk+"<p>";
                                                    //DadosDias+=             "<i class='fa fa-upload' aria-hidden='true' id='btn_apontamento' onclick='fcAbrirApontamentoDiafcAbrirApontamentoDia("+v_colaborador_pk+","+v_agenda_colaborador_padrao_pk+","+v_dt_dia+")' ></i> - "+arrCarregar.data[i].dadosEscalaCalendario[x].ds_tipo_escala+"<p>";

                                                    //DadosDias += "<i class='fa fa-upload' aria-hidden='true' id='btn_apontamento' onclick='fcAbrirApontamentoDia(" + v_colaborador_pk + "," + v_dt_dia + "," + v_leads_pk + ")' ></i> - " + arrCarregar.data[i].dadosEscalaCalendario[x].ds_tipo_escala + " - " + v_agenda_colaborador_padrao_pk + "<p>";
                                                    DadosDias += "<div style='text-align:left; margin:10px'  title='apontamento' class='abrirApontamento' onclick='fcAbrirApontamentoDia(" + v_colaborador_pk + ',"' + v_dt_dia + '",' + v_leads_pk + ")'><img width=15 height=20 src='../img/apontamento_colaborador.png'></div>";
                                                    if(arrCarregar.data[i].dadosEscalaCalendario[x].ds_tipo_escala  != ''){
                                                        DadosDias += "<span style='text-align:center; margin:10px'>" + arrCarregar.data[i].dadosEscalaCalendario[x].ds_tipo_escala + "</span> - " + v_agenda_colaborador_padrao_pk;
                                                    }else{
                                                        DadosDias += "<span style='text-align:center; margin:10px'></span>";
                                                    
                                                    }
                                                    DadosDias += "<span style='text-align:center; margin:10px'>" + arrCarregar.data[i].ds_tipo_escala + "</span>";
                                                    DadosDias += "<br>";

                                                    DadosDias += "       </div>";
                                                    DadosDias += "   </div>";


                                                    DadosDias += "</div>";
                                               // }
                                            }
                                        }
                                    }
                                }
                            if (DadosDias == '') {

                                //v_colaborador_pk = arrCarregar.data[i]['colaborador_pk'];
                                v_leads_pk = arrCarregar.data[i]['leads_pk'];
                                //v_dt_dia = dias_semana;
                                DadosDias += "   <div class='row' >";
                                DadosDias += "       <div class='col-md-12' style='width:90px;  margin:10px'>";

                                //DadosDias += "<i class='fa fa-upload' aria-hidden='true' id='btn_apontamento' onclick='fcAbrirApontamentoDia(" + v_colaborador_pk + "," + v_agenda_colaborador_padrao_pk + "," + dias_semana + "," + v_leads_pk + ")' ></i>&nbsp;<p>";
                                DadosDias += "<div title='apontamento' class='abrirApontamento' onclick='fcAbrirApontamentoDia(" + v_colaborador_pk + ',"' + v_dt_dia + '",' + v_leads_pk + ")'><img width=15 height=20 src='../img/apontamento_colaborador.png'></div>&nbsp;";
                                DadosDias += "       </div>";
                                DadosDias += "   </div>";
                                DadosDias += "</div>";
                            }
                            vhtml += DadosDias;
                            vhtml += " </td>";
                            dias_semana++;
                        } else {
                            //Dias da semana anterior antes do inicio da semana
                            //vhtml += "<td style='font-size:12px;text-align: left;border: 1px solid silver;width:5px'>";
                            vhtml += "<td style='border: 1px solid silver' width:6px>";
                            DadosDias = "";
                            /* DadosDias += "<div  style='font-size:12px;text-align:left'>";
                            DadosDias += "   <div class='row' >";
                            DadosDias += "       <div class='col-md-12' style='width:5px'>";
                             //DadosDias += "           &nbsp;";
                            DadosDias += "       </div>";
                            DadosDias += "   </div>";
                            DadosDias += "</div>";*/
                            vhtml += DadosDias;
                            vhtml += " </td>";
                        }
                    } else {
                        //vhtml += "<td style='font-size:12px;text-align: left;border: 1px solid silver;width:5px'>";
                        vhtml += "<td style='border: 1px solid silver;'  width:6px>";
                        DadosDias = "";
                        /* DadosDias += "<div  style='font-size:12px;text-align:left'>";
                        DadosDias += "   <div class='row' >";
                        DadosDias += "       <div class='col-md-12' style='width:5px'>";
                         //DadosDias += "           &nbsp;";
                        DadosDias += "       </div>";
                        DadosDias += "   </div>";
                        DadosDias += "</div>";*/
                        vhtml += DadosDias;
                        vhtml += " </td>";
                    }
                }
                vhtml += "        </tr>";
                vhtml += "    </table>";
                vhtml += "</td>";
            }
            vhtml += "            </tr>";
            vhtml += "        </table>";
            vhtml += "    </td>";
            vhtml += "</tr>";

        }
        vhtml += "</table>";
        //Carrega lista de dados
        $("#listarDados").html(vhtml);
        //carrega o tirulo do calendario

        vhtml = "";

        $("#listarEscalas").html(vhtml);
        $("#listarDados").show();
    }
}
}catch(e){
    alert(e)
}
    
}


function fcSemanasEscalas() {
    //Função monta a estrutua de semanas do mes inicio e fim 
    $("#tituloSemanasMesEscala").html('');
    var vhtml = "";
    var dias_semana = "";

    var semana = ["DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SAB"];
    var primeira_semana_mes = new Date($("#ano_pk").val(), $("#mes_pk").val(), 1, 0, 0, 0);
    var udm = (new Date($("#ano_pk").val(), parseInt($("#mes_pk").val()) + 1, 0, 0, 0, 0)).getDate();

    if ($("#mes_pk").val() == '10') {//correcao mes de novembro
        if (udm == '31') {
            udm = 30;
        }
    }
    vhtml += "<table>";
    vhtml += "<tr style=border: 1px solid;background-color:#F5f5f5'>";
    for (h = 1; h < 7; h++) {
        vhtml += "<th style='border: 1px solid; background-color:#F5f5f5;text-align: center'>";
        vhtml += "    <label for='semana'>" + h + " Semana (" + $("#ds_mes").text() + ")</label><p>";
        vhtml += "    <table style='width:600px'>";
        vhtml += "        <tr style='border: 1px solid;background-color:#F5f5f5'>";
        for (j = 0; j < 7; j++) {
            var DadosDias = "";
            if (h == 1) {//verifica o inicio da primeira semana
                if (semana[j] == semana[primeira_semana_mes.getDay()]) {
                    dias_semana = "1";//compara o primeiro dia da semana do mes
                }
            }
            if (dias_semana <= udm) {//quantidade de dias do mes
                if (dias_semana != '') {//verifica se o contador de dias foi iniciado  
                    vhtml += "<td  style='font-size:12px;text-align: center;border: 1px solid silver;width:10px'>";
                    if (semana[j] == 'DOM') {
                        vhtml += "<label style='color:#FF4D4D'><b>" + semana[j] + "</b></label>";
                    } else {
                        vhtml += "<label style='color:#0080FF'>" + semana[j] + "</label>";
                    }
                    vhtml += "<div  style='font-size:11px;text-align:center'>";
                    vhtml += "   <div class='row' >";
                    vhtml += "       <div class='col-md-12' style='width:10px'>";
                    vhtml += dias_semana;
                    vhtml += "       </div>";
                    vhtml += "   </div>";
                    vhtml += "</div>";
                    //vhtml+="<label style='font-size: 18px;'>"+dias_semana+"</label>";
                    vhtml += " </td>";
                    dias_semana++;
                } else {
                    //Dias da semana anterior antes do inicio da semana
                    vhtml += "<td  style='font-size:12px;text-align: center;border: 1px solid silver;width:40px'>";
                    DadosDias = "";
                    /*DadosDias += "<div  style='font-size:12px;text-align:center'>";
                    DadosDias += "   <div class='row' >";
                    DadosDias += "       <div class='col-md-12' style='width:47px'>";
                   // DadosDias += "           &nbsp;";
                    DadosDias += "       </div>";
                    DadosDias += "   </div>";
                    DadosDias += "</div>";*/
                    vhtml += DadosDias;
                    vhtml += " </td>";
                }
            } else {
                vhtml += "<td style='font-size:12px;text-align: center;border: 1px solid silver;width:40px'>";
                DadosDias = "";
                /* DadosDias += "<div  style='font-size:12px;text-align:center'>";
                 DadosDias += "   <div class='row' >";
                 DadosDias += "       <div class='col-md-12' style='width:45px'>";
                // DadosDias += "           &nbsp;";
                 DadosDias += "       </div>";
                 DadosDias += "   </div>";
                 DadosDias += "</div>";*/
                vhtml += DadosDias;
                vhtml += " </td>";
            }
        }
        vhtml += "        </tr>";
        vhtml += "    </table>";
        vhtml += "</th>";
    }
    vhtml += "</tr>";
    vhtml += "</table>";


    $("#tituloSemanasMesEscala").html(vhtml);
    $("#tituloSemanasMesEscala").show();
    //fcListarDados()
    //fcEscalas()
}

function fcAbrirApontamentoDia(colaborador_pk, dia, leads_pk) {

    $("#dv_formulario_ponto").hide();
    $("#dv_formulario_falta").hide();
    $("#dv_formulario_folga").hide();
    $("#dv_formulario_troca_escala").hide();
    $("#dv_formulario_afastamento").hide();
    $("#dv_formulario_ferias").hide();
    $("#dv_formulario_servico_extra").hide();
    $("#tipo_apontamento_pk").val("");

    ano = $("#ano_pk").val();
    var mes = parseInt($("#mes_pk").val());
    mes = mes + 1;
    if ($("#origem").val() == "calendario_escala") {
        dt_apontamento = dia + "/" + mes + "/" + ano;
        $("#dt_apontamento").val(dt_apontamento);
    }
    fcChangeCarregarTabelas(colaborador_pk, dt_apontamento, leads_pk);
    $("#subcategoria").change(function(){

    })
    $("#colaborador_pk_modal").trigger("chosen:updated")
    $("#janela_apontamento_colaborador").modal();

    $("listarDados").keyup(function () {
        var index = $(this).parent().index();
        var nth = "#tabela td:nth-child(" + (index + 1).toString() + ")";
        var valor = $(this).val().toUpperCase();
        $("#tabela tbody tr").show();
        $(nth).each(function () {
            if ($(this).text().toUpperCase().indexOf(valor) < 0) {
                $(this).parent().hide();
            }
        });
    });
    $("listarDados").blur(function () {
        $(this).val("");
    });

    $("#cmdEnviar").on('click', function () {
        $("#listarDados").hide();
        //fcSemanasEscalas();
        fcListarDados();
    });
}

$(document).ready(function () {

    fcComboLeads()//CARREGA COMBO DE POSTOS DE TRABALHO
    fcColaborador()//CARREGA COMBO COLABORADORES        
    fcQualificacao()//CARREGA COMBO DE QUALIFICAÇÃO  

    //    //filtros

    fcMesAnoAtualCalendario();

    $("#leads_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        //tblResultado.clear();    
        fcColaborador();
        $(".chzn-select").chosen({ allow_single_deselect: true });
        fcListarDados();
    });

    $("#colaborador_calendario").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarDados();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });


    $("#produtos_servicos_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarDados();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $("#n_qtde_dias_semana").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarDados();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });

    $("#tipo_escala_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarDados();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });

    //FORMATAÇÃO
    $(".chzn-select").chosen({ allow_single_deselect: true });
});
