
function fcIncluirOcorrencia(){
    sendPost('ocorrencia_cad_form.php',{token: token, pk: ''});
}

function fcExcluirOcorrencia(v_pk){
    var arrCarregar = permissao("ocorrencia", "del");  
    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){
            alert(v_pk)

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("ocorrencia", "excluir", objParametros);

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblOcorrencia.ajax.reload();

            }else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcCarregarGridOcorrencia(){   
    var objParametros = {
        "leads_pk": leads_pk
    };     
    var v_url = montarUrlController("ocorrencia", "listarOcorrenciasLeadPk", objParametros);
    
    //Trata a tabela
    tblOcorrencia = $('#tblOcorrencia').DataTable({
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
            
            {"targets": -2, "data": "t_dt_termino_retorno"}, 
            {"targets": -3, "data": "t_ds_retorno"},
            {"targets": -4, "data": "t_dt_retorno"},
            {"targets": -5, "data": "t_agendado_para"},
            {"targets": -6, "data": "t_dt_fechamento"}, 
            {"targets": -7, "data": "t_nome_usuario_cadastro"},
            {"targets": -8, "data": "t_ds_ocorrencia"},
            {"targets": -9, "data": "t_tipos_ocorrencias_pk" ,"visible":false},
            {"targets": -10, "data": "t_ds_tipo_ocorrencia"},
            {"targets": -11, "data": "t_dt_cadastro"}, 
            {"targets": -12, "data": "t_pk"} 

        ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblOcorrencia tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblOcorrencia.row( $(this).parents('li') ).data()){
            data = tblOcorrencia.row( $(this).parents('li') ).data();
        }
        else if(tblOcorrencia.row( $(this).parents('tr') ).data()){
            data = tblOcorrencia.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirOcorrencia(data['t_pk']);
        }
    } );
    
    $('#tblOcorrencia tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblOcorrencia.row( $(this).parents('li')).data()){
            data = tblOcorrencia.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblOcorrencia.row( $(this).parents('tr')).data()){
            data = tblOcorrencia.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarOcorrencia(data);        
    } ); 
}

function fcEditarOcorrencia(objRegistro){
    var arrCarregar = permissao("ocorrencia", "upd");  
    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    fcAbrirFormNovaOcorrencia();
    $("#contatos_pk").val("");
    $("#acao").val("upd");

    $("#ocorrencias_pk").val(objRegistro['t_pk']); 
    fcCarregarOcorrencia(objRegistro['t_pk'])   
}


function fcAbrirFormNovoOcorrencia(){
    fcAbrirFormNovaOcorrencia();
    $("#acao").val("ins");
    $("#ocorrencias_pk").val("");
}

function fcCarregarInfoOcorrencias(){
    if(leads_pk > 0){
        var objParametros = {
            "pk": leads_pk
        }; 
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        
        $("#ds_lead_titulo_ocorrencia").html("<b>"+arrCarregar.data[0]['ds_lead']+"</b>");
        $("#id_lead_ocorrencia").html("Cód Lead: "+arrCarregar.data[0]['pk']);
        $("#dt_cadastro_lead_ocorrencia").html("Dt de Cad: "+arrCarregar.data[0]['dt_cadastro']);
        $("#dt_ult_atualizacao_lead_ocorrencia").html("Dt Utl atualização: "+arrCarregar.data[0]['dt_ult_atualizacao']);
        $("#ds_usuario_cadastro_ocorrencia").html("Usuário de Cad: "+arrCarregar.data[0]['ds_usuario_cadastro']);
    }
}

$(document).ready(function(){
    var arrCarregar = permissao("ocorrencia", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }

    //faz a carga inicial do grid.
    fcCarregarGridOcorrencia();
    fcCarregarInfoOcorrencias();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdIncluirOcorrencia', fcAbrirFormNovoOcorrencia);

});


