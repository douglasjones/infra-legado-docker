var tblEscala;
var strComboNova = "";



function fcCarregarGridEscala() {
    
        var objParametros = {
            "colaborador_pk": colaborador_pk
        };
        
        var v_url = montarUrlController("agenda_colaborador_padrao", "lisarEscalasResPadraoColaborador", objParametros);
        //NewWindow(v_last_url)
        
        //Trata a tabela
        tblEscala = $('#tblEscala').DataTable({
            
            "ajax": { "url": v_url, "type": "POST" },
            "responsive": false,
            "scrollX": true,
            "searching": true,
            "paging": true,
            "bFilter": true,
            "bInfo": true,
            "columnDefs": [{
                "targets": -1, 
                "data": null, 
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
            

            { "targets": -2, "data": "t_leads_pk", "visible": false },
            { "targets": -3, "data": "t_contratos_pk", "visible": false },
            { "targets": -4, "data": "t_dt_inicio_agenda", "visible": false },
            { "targets": -5, "data": "t_dt_fim_agenda", "visible": false },
            { "targets": -6, "data": "t_produtos_servicos_pk", "visible": false },
            { "targets": -7, "data": "t_processos_etapas_pk", "visible": false },
            { "targets": -8, "data": "t_contratos_itens_pk", "visible": false },
            { "targets": -9, "data": "t_turnos_pk", "visible": false },
            { "targets": -10, "data": "t_hr_inicio_expediente", "visible": false },
            { "targets": -11, "data": "t_hr_termino_expediente", "visible": false },
            { "targets": -12, "data": "t_hr_saida_intervalo", "visible": false },
            { "targets": -13, "data": "t_hr_retorno_intervalo", "visible": false },
            { "targets": -14, "data": "t_ic_folga_inverter", "visible": false },
            { "targets": -15, "data": "t_tipo_escala", "visible": false },
            { "targets": -16, "data": "t_ic_intrajornada", "visible": false },
            { "targets": -17, "data": "t_ic_dom", "visible": false },
            { "targets": -18, "data": "t_ic_seg", "visible": false },
            { "targets": -19, "data": "t_ic_ter", "visible": false },
            { "targets": -20, "data": "t_ic_qua", "visible": false },
            { "targets": -21, "data": "t_ic_qui", "visible": false },
            { "targets": -22, "data": "t_ic_sex", "visible": false },
            { "targets": -23, "data": "t_ic_sab", "visible": false },
            { "targets": -24, "data": "t_ic_dom_folga", "visible": false },
            { "targets": -25, "data": "t_ic_seg_folga", "visible": false },
            { "targets": -26, "data": "t_ic_ter_folga", "visible": false },
            { "targets": -27, "data": "t_ic_qua_folga", "visible": false },
            { "targets": -28, "data": "t_ic_qui_folga", "visible": false },
            { "targets": -29, "data": "t_ic_sex_folga", "visible": false },
            { "targets": -30, "data": "t_ic_sab_folga", "visible": false },
            { "targets": -31, "data": "t_dom_turnos_pk", "visible": false },
            { "targets": -32, "data": "t_seg_turnos_pk", "visible": false },
            { "targets": -33, "data": "t_ter_turnos_pk", "visible": false },
            { "targets": -34, "data": "t_qua_turnos_pk", "visible": false },
            { "targets": -35, "data": "t_qui_turnos_pk", "visible": false },
            { "targets": -36, "data": "t_sex_turnos_pk", "visible": false },
            { "targets": -37, "data": "t_sab_turnos_pk", "visible": false },
            { "targets": -38, "data": "t_hr_turno_dom", "visible": false },
            { "targets": -39, "data": "t_hr_turno_seg", "visible": false },
            { "targets": -40, "data": "t_hr_turno_ter", "visible": false },
            { "targets": -41, "data": "t_hr_turno_qua", "visible": false },
            { "targets": -42, "data": "t_hr_turno_qui", "visible": false },
            { "targets": -43, "data": "t_hr_turno_sex", "visible": false },
            { "targets": -44, "data": "t_hr_turno_sab", "visible": false },
            { "targets": -45, "data": "t_hr_turno_dom_saida", "visible": false },
            { "targets": -46, "data": "t_hr_turno_seg_saida", "visible": false },
            { "targets": -47, "data": "t_hr_turno_ter_saida", "visible": false },
            { "targets": -48, "data": "t_hr_turno_qua_saida", "visible": false },
            { "targets": -49, "data": "t_hr_turno_qui_saida", "visible": false },
            { "targets": -50, "data": "t_hr_turno_sex_saida", "visible": false },
            { "targets": -51, "data": "t_hr_turno_sab_saida", "visible": false },
            { "targets": -52, "data": "t_hr_intervalo_dom", "visible": false },
            { "targets": -53, "data": "t_hr_intervalo_seg", "visible": false },
            { "targets": -54, "data": "t_hr_intervalo_ter", "visible": false },
            { "targets": -55, "data": "t_hr_intervalo_qua", "visible": false },
            { "targets": -56, "data": "t_hr_intervalo_qui", "visible": false },
            { "targets": -57, "data": "t_hr_intervalo_sex", "visible": false },
            { "targets": -58, "data": "t_hr_intervalo_sab", "visible": false },
            { "targets": -59, "data": "t_hr_intervalo_saida_dom", "visible": false },
            { "targets": -60, "data": "t_hr_intervalo_saida_seg", "visible": false },
            { "targets": -61, "data": "t_hr_intervalo_saida_ter", "visible": false },
            { "targets": -62, "data": "t_hr_intervalo_saida_qua", "visible": false },
            { "targets": -63, "data": "t_hr_intervalo_saida_qui", "visible": false },
            { "targets": -64, "data": "t_hr_intervalo_saida_sex", "visible": false },
            { "targets": -65, "data": "t_hr_intervalo_saida_sab", "visible": false },
            { "targets": -66, "data": "t_ic_preenchimento_automatico", "visible": false },
            { "targets": -67, "data": "t_ic_nao_repetir", "visible": false } ,
            //{ "targets": -68, "data": "t_ds_combo_contrato", "visible": false },

            { "targets": -68, "data": "t_ds_motivo_cancelamento" },
            { "targets": -69, "data": "t_dt_cancelamento" },
            { "targets": -70, "data": "t_dt_periodo_escala" },
            { "targets": -71, "data": "t_status" },
            { "targets": -72, "data": "t_n_qtde_dias_semana" },
            { "targets": -73, "data": "t_ds_produto_servico" },
            { "targets": -74, "data": "t_ds_identificacao_area" },
            { "targets": -75, "data": "t_ds_lead" },
            { "targets": -76, "data": "t_pk" }
            ],
            "language": {
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
            }
        });
        //Atribui os eventos na coluna ação.
        $('#tblEscala tbody').on('click', '.function_edit', function () {
            var data;
            rLinhaSelecionada = null;
            if (tblEscala.row($(this).parents('li')).data()) {
                data = tblEscala.row($(this).parents('li')).data();
                rLinhaSelecionada = $(this).parents('li');
            }
            else if (tblEscala.row($(this).parents('tr')).data()) {
                data = tblEscala.row($(this).parents('tr')).data();
                rLinhaSelecionada = $(this).parents('tr');
            }

            fcEditarAgenda(data);
           

        });
    
        $('#tblEscala tbody').on('click', '.function_delete', function () {
            var data;
            if (tblEscala.row($(this).parents('li')).data()) {
                data = tblEscala.row($(this).parents('li')).data();
            }
            else if (tblEscala.row($(this).parents('tr')).data()) {
                data = tblEscala.row($(this).parents('tr')).data();
            }
    
            if (data['t_pk'] != "") {
                fcExcluirAgenda(data['t_pk']);
            }
            tblEscala.row($(this).parents('tr')).remove().draw();
        });
    return false;
}

function recarregarGridEscala(){
    setTimeout(function(){
        tblEscala.ajax.reload(); 
    }, 100);  
}

$(document).ready(function () {
    //carregar table escala
    fcCarregarGridEscala();


});