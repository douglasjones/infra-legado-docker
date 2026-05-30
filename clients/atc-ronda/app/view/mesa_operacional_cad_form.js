var tblResultado;

function fcCarregarGrid() {

    var strRetorno = "";

    strRetorno += "<table id='tabela' class='table table-striped table-bordered nowrap' style='width:100%' id='tblResultado'";
    var segundo_ponto = "";
    strRetorno += "   <thead align='center'>";
    strRetorno += "       <tr>";
    strRetorno += "           <th>Posto Trabalho</th>";
    strRetorno += "           <th>Colaborador</th>";
    strRetorno += "           <th>Telefone Posto de Trabalho</th>";
    strRetorno += "           <th>Horário Escala</th>";
    strRetorno += "           <th>Hora Registro Ponto</th>";
    strRetorno += "           <th>Tempo Atraso</th>";
    strRetorno += "           <th>Status</th>";
    strRetorno += "           <th>Ação</th>";
    strRetorno += "       </tr>";
    strRetorno += "   </thead>";

    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "turnos_pk": $("#turnos_pk").val()
    };

    var arrCarregar = carregarController("ponto", "listarDadosMesaOperacional", objParametros);
    strRetorno += "    <tbody>";
    var ds_background = "";
    var ds_fonte_color = "";

    for (j = 0; j < arrCarregar.data.length; j++) {

        if (arrCarregar.data[j]['ds_lead'] != null) {
            $ds_lead = arrCarregar.data[j]['ds_lead'];
        } else {
            $ds_lead = "";
        }
        if (arrCarregar.data[j]['ds_colaborador'] != null) {
            ds_colaborador = arrCarregar.data[j]['ds_colaborador'];
        } else {
            ds_colaborador = "";
        }

        if (arrCarregar.data[j]['ds_tel'] != null) {
            ds_tel = arrCarregar.data[j]['ds_tel'];
        } else {
            ds_tel = "";
        }
        if (arrCarregar.data[j]['hr_escala'] == null) {
            hr_escala = "";
        } else {
            hr_escala = arrCarregar.data[j]['hr_escala'];
        }
        //DIFERENCA DO HORARIO 
        if (arrCarregar.data[j]['hr_diferenca'] == null) {
            var ds_hr_dif = 'Vazio';
        }
        else {
            if (parseInt(arrCarregar.data[j]['segundos']) < 0) {
                var ds_hr_dif = "Dentro do Horário";
            }
            else if (parseInt(arrCarregar.data[j]['segundos']) == 0) {
                var ds_hr_dif = "";

            }
            else {
                var ds_hr_dif = arrCarregar.data[j]['hr_diferenca'];
                segundo_ponto = parseInt(arrCarregar.data[j]['segundos']);
            }
        }
        //COR DOS HORARIOS
        
        if (parseInt(arrCarregar.data[j]['segundos']) <= 60 && parseInt(arrCarregar.data[j]['segundos']) > 600) {
            ds_background = '#c3c3c1';
        }
        if (parseInt(arrCarregar.data[j]['segundos']) <= 600 && parseInt(arrCarregar.data[j]['segundos']) >= 899) {
            ds_background = '#e6df55';
        }
        if (parseInt(arrCarregar.data[j]['segundos']) <= 900 && parseInt(arrCarregar.data[j]['segundos']) >= 1499) {
            ds_background = '#f99856';
        }
        if (parseInt(arrCarregar.data[j]['segundos']) > 1500) {
            ds_background = '#ec1c24';
            ds_fonte_color = 'white';
        }
        if (arrCarregar.data[j]['tipo_registro_ponto'] == "1") {
            
            ds_background = '#63ed83';
            ds_fonte_color = 'black';
            ds_hr_dif = "00:00:00";

        }


        var leads_pk = arrCarregar.data[j]['leads_pk'];
        var colaboradores_pk = arrCarregar.data[j]['colaboradores_pk'];
        var dt_apontamento = arrCarregar.data[j]['dt_atual'];
        var dt_hora_registro = arrCarregar.data[j]['dt_hora_registro'];
        var ic_status = arrCarregar.data[j]['ic_status'];
        strRetorno += "<tr align=center style='border-color:b4b4b4;border-style: solid;background-color:" + ds_background + ";color:" + ds_fonte_color + "'>";


        strRetorno += "<td  width='15%'>" + $ds_lead + "</td>";
        strRetorno += "<td  width='25%'>" + ds_colaborador + "</td>";
        strRetorno += "<td  width='20%'>" + ds_tel + "</td>";
        strRetorno += "<td  width='20%'>" + hr_escala + "</td>";
        strRetorno += "<td  width='20%'>" + dt_hora_registro + "</td>";

        strRetorno += "<td  width='10%' >" + ds_hr_dif + "</td>";
        strRetorno += "<td  width='10%' >" + ic_status + "</td>";
        strRetorno += "<td  align='center' width='10%' ><a title='apontamento' class='abrirApontamento' onclick='fcAbrirApontamentoDia(" + leads_pk + ',"' + dt_apontamento + '",' + colaboradores_pk + ")'><span><img width=25 height=40 src='../img/apontamento_colaborador.png'></span></a> </td>";
        // strRetorno+="<td  align='center' style='background-color:#ffffff'  width='10%' ><a title='apontamento' class='abrirApontamento' onclick='fcAbrirApontamentoDia("+ leads_pk + ',"' + dt_apontamento + '",' + colaboradores_pk + ")'><span><img width=25 height=25 src='../img/apontamento.png'></span></a> </td>";


        strRetorno += "</tr>";

    }
    strRetorno += "   </tbody>";
    strRetorno += "</table>";
    $("#exibir").show();
    $("#tblMesaOperacional").html(strRetorno);
}

function fcAbrirApontamentoDia(leads_pk, dt_apontamento, colaboradores_pk) {

    $("#dv_formulario_ponto").hide();
    $("#dv_formulario_falta").hide();
    $("#dv_formulario_folga").hide();
    $("#dv_formulario_troca_escala").hide();
    $("#dv_formulario_afastamento").hide();
    $("#dv_formulario_ferias").hide();
    $("#dv_formulario_servico_extra").hide();
    $("#tipo_apontamento_pk").val("");
    $("#dt_apontamento").val(dt_apontamento);

    fcChangeCarregarTabelas(colaboradores_pk, dt_apontamento, leads_pk);
    fcColaboradorModal(colaboradores_pk);
    fcChangeCarregarFormularios();
    $("#janela_apontamento_colaborador").modal();

    $("#tabela input").keyup(function () {
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
    $("#tabela input").blur(function () {
        $(this).val("");
    });

    setInterval(function () {
        $("#exibir").hide();
        fcCarregarGrid();
    }, 6000);
}

$(document).ready(function () {


    fcCarregarGrid();

    $("#tabela input").keyup(function () {
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
    $("#tabela input").blur(function () {
        $(this).val("");
    });

    setInterval(function () {
        $("#exibir").hide();
        fcCarregarGrid();
    }, 60000);


});


