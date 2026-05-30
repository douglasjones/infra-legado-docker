var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){

    sendPost('solicitacao_liberacao_app_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_pin){

    if (confirm("Deseja realmente excluir o registro '" + v_ds_pin + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("solicitacao_liberacao_app", "excluir", objParametros);   

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


function fcEditar(){
    
    if($('#ic_status_modal').is(":checked")){  
        var ic_status = 1;
    }else{
        $("#alert_liberacao").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_liberacao").slideUp(500);
        });
        return false;
    }
    
    var objParametros = {
        "pk": $("#ponto_solicitacao_liberacao_app_pk").val(),
        "ic_status": ic_status 
    }; 

    var arrEnviar = carregarController("solicitacao_liberacao_app", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
       alert(arrEnviar.message); 
       tblResultado.ajax.reload();
    }else{
        alert(arrEnviar.result);
    }
    
    $("#janela_liberacao").modal("hide");    
    return false;
    
}

function fcCarregarGrid(){

    var objParametros = {
        "colaborador_pk": $("#colaboradores_pk").val(),
        "ds_pin": $("#ds_pin").val(),
        "ds_re": $("#ds_re").val(),
        "ic_status": $("#ic_status").val()
    };     
    
    var v_url = montarUrlController("solicitacao_liberacao_app", "listar_solicitacoes", objParametros);
    //NewWindow(v_last_url)
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },                    
           {"targets": -2, "data": "t_ds_usuario"},
           {"targets": -3, "data": "t_dt_liberacao"},
           {"targets": -4, "data": "t_status"},  
           {"targets": -5, "data": "t_dt_solit_liberacao"},
           {"targets": -6, "data": "t_ds_imagem",className: "text-center"},
           {"targets": -7, "data": "t_ds_link_imagem",visible:false,className: "text-center"},
           {"targets": -8, "data": "t_ds_re"},
           {"targets": -9, "data": "t_ds_pin"},
           {"targets": -10, "data": "t_ds_colaborador"},
           {"targets": -11, "data": "t_pk"}
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
        fcAbrirFormLiberacao(data);        
    } );   
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_ds_pin']);
    } );            
    
}
function fcCarregarColaborador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("colaborador", "listarTodosRel", objParametros);    
    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");
        
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormLiberacao(objRegistro){

    if(objRegistro['t_status']=='Liberado'){
        alert('Colaborador já liberado!')
        return false;
    }

    //limpa os dados de qualquer registro existe
    fcLimparFormLiberacao();
    
    $("#janela_liberacao").modal();
    $("#acao").val("upd");
    
   //Carrega as informações da linha selecionada.
    $("#ponto_solicitacao_liberacao_app_pk").val(objRegistro['t_pk']);
    $("#ds_colaborador_modal").html(objRegistro['t_ds_colaborador']);
    $("#ds_imagem_modal").html("<img width=70 height=70 src='"+objRegistro['t_ds_link_imagem']+"'>");
    $("#dt_solit_liberacao_modal").html(objRegistro['t_dt_solit_liberacao']);   
    
}

function fcLimparFormLiberacao(){
    $("#acao").val("");
    $("#ponto_solicitacao_liberacao_app_pk").val("");
    $("#ds_colaborador").val("");
    $("#ds_imagem").val("");
    $("#dt_solit_liberacao").val("");
    $("#ic_status").prop('checked', false);
}


$(document).ready(function(){
       
    fcCarregarColaborador();
    
    //faz a carga inicial do grid.
    fcCarregarGrid();
    $(document).on('mouseover', '#tblResultado td:nth-child(5) img', function() {
        $(this).addClass('expanded-image'); // Adiciona a classe ao passar o mouse sobre a imagem
      });
      
      $(document).on('mouseout', '#tblResultado td:nth-child(5) img', function() {
        $(this).removeClass('expanded-image'); // Remove a classe ao remover o mouse da imagem
      });
    $(".chzn-select").chosen({allow_single_deselect: true}); 

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
    $(document).on('click', '#cmdEnviarAprovacaoSolicitacao', fcEditar);
   
});


