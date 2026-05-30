var tblContatos;

function fcIncluirContato(){
    sendPost('contato_cad_form.php',{token: token, pk: ''});
}

function fcExcluirContato(v_pk){
    var arrCarregar = permissao("contato", "del"); 
    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    if (confirm("Deseja realmente excluir o registro ?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("contato", "excluir", objParametros);

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblContatos.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcCarregarGridContato(){
    var leads_pk = $("#leads_pk").val();

    var objParametros = {
        "leads_pk":leads_pk
    };     
    
    var v_url = montarUrlController("contato", "carregarPorLeadsPk", objParametros);

    //Trata a tabela
    tblContatos = $('#tblContatos').DataTable({
        "scrollX": false,
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
            {"targets": -2, "data": "t_cargos_pk","visible":false},
            {"targets": -3, "data": "t_ds_cargos_pk"},
            {"targets": -4, "data": "t_ds_tel"},
            {"targets": -5, "data": "t_ic_whatsapp","visible":false},
            {"targets": -6, "data": "t_ds_whatsapp"},           
            {"targets": -7, "data": "t_ds_cel"},
            {"targets": -8, "data": "t_ds_email"},
            {"targets": -9, "data": "t_ds_contato"},
            {"targets": -10, "data": "t_pk"}

        ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblContatos tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblContatos.row( $(this).parents('li')).data()){
            data = tblContatos.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblContatos.row( $(this).parents('tr')).data()){
            data = tblContatos.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarContato(data);
        
    } );   
    
    $('#tblContatos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblContatos.row( $(this).parents('li') ).data()){
            data = tblContatos.row( $(this).parents('li') ).data();
        }
        else if(tblContatos.row( $(this).parents('tr') ).data()){
            data = tblContatos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirContato(data['t_pk']);
        }
        //tblContatos.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;

}

function fcAbrirFormNovoContato(){
    
    //limpa os dados de qualquer registro existe
    fcLimparFormContato();
    
    $("#janela_contatos").modal();
    $("#acao").val("ins");
    $("#contatos_pk").val("");
}

function fcEditarContato(objRegistro){ 
    var arrCarregar = permissao("contato", "upd");
    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    fcLimparFormContato();
    $("#janela_contatos").modal();
    $("#contatos_pk").val("");
    $("#acao").val("upd");
    
    //Carrega as informações da linha selecionada.
    $("#contatos_pk").val(objRegistro['t_pk']);
    $("#ds_contato").val(objRegistro['t_ds_contato']);
    $("#ds_email").val(objRegistro['t_ds_email']);
    $("#ds_cel").val(objRegistro['t_ds_cel']);
    $("#ic_whatsapp").val(objRegistro['t_ic_whatsapp']);
    $("#ds_tel_contato").val(objRegistro['t_ds_tel']);
    $("#cargos_pk").val(objRegistro['t_cargos_pk']);  
    
}

function fcLimparFormContato(){
    $("#acao").val("");
    $("#contatos_pk").val("");
    $("#ds_contato").val("");
    $("#ds_email").val("");
    $("#ds_cel").val("");
    $("#ic_whatsapp").val("");
    $("#ds_tel_contato").val("");
    $("#cargos_pk").val("");        
}

function fcCarregarInfoContatos(){
    if(leads_pk > 0){
        var objParametros = {
            "pk": leads_pk
        }; 
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        
        $("#ds_lead_titulo_contatos").html("<b>"+arrCarregar.data[0]['ds_lead']+"</b>");
        $("#id_lead_contatos").html("Cód Lead: "+arrCarregar.data[0]['pk']);
        $("#dt_cadastro_lead_contatos").html("Dt de Cad: "+arrCarregar.data[0]['dt_cadastro']);
        $("#dt_ult_atualizacao_lead_contatos").html("Dt Utl atualização: "+arrCarregar.data[0]['dt_ult_atualizacao']);
        $("#ds_usuario_cadastro_contatos").html("Usuário de Cad: "+arrCarregar.data[0]['ds_usuario_cadastro']);
    }
}

$(document).ready(function(){

    $(document).on('click', '#cmdIncluirContato', fcAbrirFormNovoContato);

     //faz a carga inicial do grid.
    fcCarregarGridContato();
    fcCarregarInfoContatos();

    //Atribui os eventos dos demais controles

});


