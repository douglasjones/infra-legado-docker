var tblResultado;

function fcPesquisar(){
    tblResultado.clear().destroy();
    fcCarregarGrid();
}

function fcIncluir(){
    sendPost('faturamento_cad_form.php',{token: token, pk: ''});
}

function fcEditar(v_pk, ic_status){
    if(ic_status == 1){
        sendPost('faturamento_item_res_form.php', {token: token, faturamento_pk: v_pk, acao: 2});
    }else if(ic_status == 2){
        alert('Faturamento já processado')
    }
}

function fcExcluir(v_pk, v_dt_faturamento_ini){

    if (confirm("Deseja realmente excluir o registro '" + v_dt_faturamento_ini + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("faturamento", "excluir", objParametros);

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

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

function fcCarregarGrid(){


    var objParametros = {
        "dt_faturamento_ini": $("#dt_faturamento_ini").val(),
        "ic_status": $("#ic_status").val()
    };

    var v_url = montarUrlController("faturamento", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "ordering": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<i style='font-size: 20px;' class='bi bi-pencil-square function_edit' title='Editar' ></i>&nbsp;&nbsp;&nbsp;&nbsp;<i style='font-size: 20px;' class='bi bi-clipboard-check function_emissoes' title='Listar Emissões'></i>"
            },
            {"targets": -2, "data": "t_ds_status"},
            {"targets": -3, "data": "t_n_emissoes"},
            {"targets": -4, "data": "t_dt_faturamento_fim"},
            {"targets": -5, "data": "t_dt_faturamento_ini"},
            {"targets": -6, "data": "t_pk"}
        ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });


    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcEditar(data['t_pk'], data['t_ic_status']);

    } );
    $('#tblResultado tbody').on('click', '.function_emissoes', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcListarEmissoes(data['t_pk'], data['t_ic_status']);

    } );

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_dt_faturamento_ini']);
    } );

}

function fcCancelar(){
    sendPost("menu_financeiro.php", {token: token});
}

function fcListarEmissoes(v_pk, ic_status){
    if(ic_status == 2){
        sendPost('faturamento_lancamentos_res_form.php', {token: token, faturamento_pk: v_pk});
    }else if(ic_status == 1){
        alert('O Faturamento precisa ser processado')
    }
}



$(document).ready(function(){
    //validações
    $('#dt_faturamento_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_apontamento_ini").keypress(function(){
        mascara(this,mdata);      
        $('#sandbox-container input').datepicker({ minDate: 0});
    });
    
    //Datas
    $('#dt_faturamento_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_faturamento_fim").keypress(function(){
        mascara(this,mdata);      
        $('#sandbox-container input').datepicker({ minDate: 0});
    });  


    //faz a carga inicial do grid.
    fcCarregarGrid();

    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdVoltar', fcCancelar);
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


