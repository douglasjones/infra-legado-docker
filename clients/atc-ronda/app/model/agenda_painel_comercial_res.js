
var tblPainelAgenda;
var modulos_pk = "";
function fcIncluiragenda(){
    sendPost('agenda_cad_form.php',{token: token, pk: ''});
}

function fcExcluirAgenda(v_pk){
    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){
            alert(v_pk)

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("agenda", "excluir", objParametros);

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblPainelAgenda.ajax.reload();

            }else{
                alert('Falhou a requisição de exclusão.');
            }
        }else{
            alert("Código não encontrado");
        }
    }
}

function fcCarregarAgenda(modulos_pk){
    $("#ds_lead_titulo_agenda").html("");
    $("#id_lead_agenda").html("");
    $("#dt_cadastro_lead_agenda").html("");
    $("#dt_ult_atualizacao_lead_agenda").html("");
    $("#ds_usuario_cadastro_agenda").html("");  
    fcCarregarGridAgenda(modulos_pk)
    fcCarregarInfoAgenda(modulos_pk)
    $("#modulos_pk_agenda_painel").val(modulos_pk)
    $('#agenda_painel_comercial').modal({backdrop: '', keyboard: false});

}

function fcFecharModalAgenda(){    
    $('#agenda_painel_comercial').hide();
    tblPainelAgenda.clear().destroy(); 
}

function fcCarregarGridAgenda(modulos_pk){
    try {   
        var objParametros = {
            "leads_pk": modulos_pk
        };     
        var v_url = montarUrlController("agenda", "listarDataTable", objParametros);
    
        //Trata a tabela
        tblPainelAgenda = $('#tblPainelAgenda').DataTable({
            "scrollX": true,
            "ajax": { "url": v_url, "type": "POST" },
            "ordering": false,
            "responsive": true,
            "searching": true,
            "paging": true,
            "bFilter": true,
            "bInfo": true,
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<a class='function_edit'><span><i class='bi bi-pencil-square' style='font-size:18px; color:black' title='EDITAR O LEAD'></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR O LEAD'></i></span></a>"
                },
                
                {"targets": -2, "data": "t_ds_obs"}, 
                {"targets": -3, "data": "t_ds_status"}, 
                {"targets": -4, "data": "t_dt_cadastro"},
                {"targets": -5, "data": "t_ds_usuario"},
                {"targets": -6, "data": "t_dt_ini_agenda_ini"},
                {"targets": -7, "data": "t_ds_tipo_agendas"},
                {"targets": -8, "data": "t_pk"} 
    
            ],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
            }
        });
        $('#tblPainelAgenda tbody').on('click', '.function_delete', function () {
            var data;
            
            if(tblPainelAgenda.row( $(this).parents('li') ).data()){
                data = tblPainelAgenda.row( $(this).parents('li') ).data();
            }
            else if(tblPainelAgenda.row( $(this).parents('tr') ).data()){
                data = tblPainelAgenda.row( $(this).parents('tr') ).data();
            }
            
            if(data['t_pk'] != ""){
                fcExcluirAgenda(data['t_pk']);
            }
        } );
        
        $('#tblPainelAgenda tbody').on('click', '.function_edit', function () {
            var data;
            
            rLinhaSelecionada = null;
            
            if(tblPainelAgenda.row( $(this).parents('li')).data()){
                data = tblPainelAgenda.row( $(this).parents('li')).data();
                rLinhaSelecionada = $(this).parents('li');
            }
            else if(tblPainelAgenda.row( $(this).parents('tr')).data()){
                data = tblPainelAgenda.row( $(this).parents('tr')).data();
                rLinhaSelecionada = $(this).parents('tr');
            } 
            fcAbrirFormAgenda(data['t_pk'], "", "inserir", leads_pk);  
        } ); 
    } catch (error) {
        alert(error)
    }
  
}

function fcCarregarInfoAgenda(modulos_pk){
    if(modulos_pk > 0){
        var objParametros = {
            "pk": modulos_pk
        }; 
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        
        $("#ds_lead_titulo_agenda").html("<b>"+arrCarregar.data[0]['ds_lead']+"</b>");
        $("#id_lead_agenda").html("Cód Lead: "+arrCarregar.data[0]['pk']);
        $("#dt_cadastro_lead_agenda").html("Dt de Cad: "+arrCarregar.data[0]['dt_cadastro']);
        $("#dt_ult_atualizacao_lead_agenda").html("Dt Utl atualização: "+arrCarregar.data[0]['dt_ult_atualizacao']);
        $("#ds_usuario_cadastro_agenda").html("Usuário de Cad: "+arrCarregar.data[0]['ds_usuario_cadastro']);
    }
}

$(document).ready(function(){
    $(document).on('click', '#cmdFecharModalAgenda', fcFecharModalAgenda);

    //Atribui os eventos dos demais controles
    $("#cmdIncluirAgenda").click(function(){
        $('#agenda_painel_comercial').hide();
        tblPainelAgenda.clear().destroy(); 
        fcAbrirFormAgenda("", "", "inserir", $("#modulos_pk_agenda_painel").val());
    });
});


