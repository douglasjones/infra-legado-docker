var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}


function fcExcluir(v_pk, v_solicitante_pk){

    if (confirm("Deseja realmente excluir o registro '" + v_solicitante_pk + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("compras_solicitacao", "excluir", objParametros);   

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

function fcIncluir(){    
    //sendPost('compras_solicitacao_cad_form.php',{token: token, pk: ''});
    sendPost('compras_solicitacao_cad_form.php', {token: token, compra_solicitacao_pk: '',usuario_aprovacao_pk:0});
}


function fcEditar(v_pk){
    sendPost('compras_solicitacao_cad_form.php', {token: token, compra_solicitacao_pk: v_pk, usuario_aprovacao_pk:0});
}

function fcAprovarSolicitacao(objRegistro){    
    if(objRegistro['t_dt_aprovacao']==null){ 
       
        if($("#usuario_logado_pk").val() != objRegistro['t_usuario_aprovacao_pk']){//Verifica se é a autoriados
            alert('Você não é o Aprovador da Solcitação de Compra!')
        }else{
            sendPost('compras_solicitacao_cad_form.php', {token: token, compra_solicitacao_pk: objRegistro['t_pk'], usuario_aprovacao_pk: objRegistro['t_usuario_aprovacao_pk']});
        }
    }else{
        alert('Solicitação de Compra aprovado, não pode ser editada!');
    }
}

//combos
function fcComboEmpresas(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("conta", "listarPk", objParametros);    
    
    carregarComboAjax($("#empresa_pk"), arrCarregar, " ", "pk", "ds_conta");        
    //carregarComboAjax($("#empresa_pk), arrCarregar, " ", "pk", "ds_conta");        
}

function fcComboSolicitante(){
   var objParametros = {

    };       
    var arrCarregar = carregarController("usuario", "listarTodosSemAdm", objParametros)    

    carregarComboAjax($("#solicitante_pk"), arrCarregar, " ", "pk", "ds_usuario");
}

function fcComboAprovador(){
   var objParametros = {
       "solicitante_pk":$('#solicitante_pk').val()
    };       
 
    var arrCarregar = carregarController("equipe", "listarResponsavelEquipe", objParametros)    
  
    if(arrCarregar.data[0]['usuario_aprovacao_pk']==0){//Se o usuario não estiver em nenhuma equipe lista os ADM dos sistema para a aprovação
        var arrCarregarADM = carregarController("usuario", "listarAdmSistema", objParametros) 

        carregarComboAjax($("#usuario_aprovacao_pk"), arrCarregarADM, " ", "usuario_aprovacao_pk", "ds_usuaario_aprovacao");
        
    }else{    
        carregarComboAjax($("#usuario_aprovacao_pk"), arrCarregar, " ", "usuario_aprovacao_pk", "ds_usuaario_aprovacao");
    }
}

function fcComboGruposCentroCusto(){           
    var objParametros = {
        "tipo_grupo_pk": ""
    };          
    if($("#tipo_grupo_centro_custo_pk").val()==1){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);       
        carregarComboAjax($("#grupo_lancamento_centrocusto_pk"), arrCarregar, " ", "pk", "ds_lead");         
    }else if($("#tipo_grupo_centro_custo_pk").val()==2){        
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centrocusto_pk"), arrCarregar, " ", "pk", "ds_colaborador");           
    }else if($("#tipo_grupo_centro_custo_pk").val()==4){

        var arrCarregar = carregarController("equipe", "listarTodos", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centrocusto_pk"), arrCarregar, " ", "pk", "ds_equipe");   
    }
}  

//grids
function fcCarregarGrid(){
    
    var objParametros = {
        "empresa_pk": $("#empresa_pk").val(),
        "solicitante_pk": $("#solicitante_pk").val(),
        "usuario_aprovacao_pk": $("#usuario_aprovacao_pk").val(),
        "tipo_grupo_centro_custo_pk": $("#tipo_grupo_centro_custo_pk").val(),
        "grupo_lancamento_centrocusto_pk": $("#grupo_lancamento_centrocusto_pk").val(),        
        "ic_status": $("#ic_status").val(),
        "dt_solicitacao_ini": $("#dt_solicitacao_ini").val(),
        "dt_solicitacao_fim": $("#dt_solicitacao_fim").val(),
        "dt_aprovacao_ini": $("#dt_aprovacao_ini").val(),
        "dt_aprovacao_ini": $("#dt_aprovacao_fim").val()
    };         
    var v_url = montarUrlController("compras_solicitacao", "listarDataTable", objParametros);
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "ordering": false,
        "searching": true,
        "paging": true,
        "bFilter": true,
        "bInfo": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png' title='Editar Solicitação de Compra'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                                   <a class='function_aprovar'><span><img width=16 height=16 src='../img/classificacao.png' title='Aprovar Solicitação de Compra'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                                   <a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png' title='Excluir Solcitação de Compra'></span></a>"
            },
           {"targets": -2, "data": "t_ds_grupo_lancamento_centrocusto"},
           {"targets": -3, "data": "t_ds_tipo_grupo_centro_custo"},
           {"targets": -4, "data": "t_dt_aprovacao"},
           {"targets": -5, "data": "t_ds_compra_solicitacao"},
           {"targets": -6, "data": "t_ds_status"},
           {"targets": -7, "data": "t_dt_solicitacao"},
           {"targets": -8, "data": "t_usuario_aprovacao_pk",visible:false},
           {"targets": -9, "data": "t_ds_usuario_aprovacao"},
           {"targets": -10, "data": "t_solicitante_pk",visible:false},
           {"targets": -11, "data": "t_ds_solicitante"},
           {"targets": -12, "data": "t_ds_empresa"},
           {"targets": -13, "data": "t_pk"}
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
        fcEditar(data['t_pk']);
        
    } );   

    $('#tblResultado tbody').on('click', '.function_aprovar', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcAprovarSolicitacao(data);
    } ); 
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_solicitante_pk']);
    } ); 
}


$(document).ready(function(){
    //Grids
    fcComboEmpresas();
    fcComboSolicitante();
    $("#solicitante_pk").change(function(){ 
        $(".chzn-select").chosen('destroy');        
        fcComboAprovador();
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    
    $("#tipo_grupo_centro_custo_pk").change(function(){ 
        $(".chzn-select").chosen('destroy');        
        fcComboGruposCentroCusto()//combo de centros de custo  
        $(".chzn-select").chosen({allow_single_deselect: true});
    });    
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    //mascaras de campos
    $('#dt_solicitacao_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate",  ); 

    $("#dt_solicitacao_ini").keypress(function(){
       mascara(this,mdata);
    }); 
    
    $('#dt_solicitacao_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate",  ); 

    $("#dt_solicitacao_fim").keypress(function(){
       mascara(this,mdata);
    });   
    
    $('#dt_aprovacao_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate",  ); 

    $("#dt_aprovacao_ini").keypress(function(){
       mascara(this,mdata);
    });   
    
    $('#dt_aprovacao_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate",  ); 

    $("#dt_aprovacao_fim").keypress(function(){
       mascara(this,mdata);
    }); 
 
    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


