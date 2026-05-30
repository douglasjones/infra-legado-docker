var tblMaterial;
function fcCarregarGridMateriais(){
    var objParametros = {
        "polos_pk": pk
    };     
    
    var v_url = montarUrlController("colaboradores_materiais", "listarTodos", objParametros);

    //Trata a tabela
    tblMaterial = $('#tblMaterial').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },              
           {"targets": -2, "data": "dt_devolucao"},
           {"targets": -3, "data": "dt_entrega"},           
           {"targets": -4, "data": "material_pk"},
           {"targets": -5, "data": "tipo_material_pk"},
           {"targets": -6, "data": "pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });   
    
    //Atribui os eventos na coluna ação.
    $('#tblMaterial tbody').on('click', '.function_edit', function () {
        var data;    
     
    } );   
    
    $('#tblMaterial tbody').on('click', '.function_delete', function () {
        var data;
        
    } ); 
    
    return false;
}
function fcValidarForm(){
    $("#form_materiais").validate({
        rules :{
            tipo_material_pk:{
                required:true
            },
            material_pk:{
                required:true
            },
            qtde_material:{
                required:true
            },
            dt_entrega:{
                required:true
            }
        },
        messages:{
            tipo_material_pk:{
                required:"Por favor, selecione o tipo de material"
            },
            material_pk:{
                required:"Por favor, selecione o material"
            },
            qtde_material:{
                required:"Por favor, informe a quantidade de itens"
            },
            dt_entrega:{
                required:"Por favor, informe a data de entrega"
            }

        },
        submitHandler: function(form){
            fcEnviarMateriais(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcEnviarMateriais(){

    if(pk == ""){
       if($("#acao").val() == "ins"){   
           fcIncluirMateriaisSemPk();
       }else if($("#acao").val() == "upd"){
           fcEditarMateriaisSemPk();
       }
   }else{
       fcSalvarMateriais();
   }   
   $("#janela_materiais").modal("hide");
}

function fcIncluirMateriaisSemPk(){
  
    tblMaterial.row.add(        
        {            
            "pk":"",
            "tipo_material_pk":$("#tipo_material_pk option:selected").text(),
            "material_pk":$("#material_pk option:selected").text(),
            "dt_entrega":$("#dt_entrega").val(),
            "dt_devolucao":$("#dt_devolucao").val(),
            "t_functions":""
        }
    ).draw();    
    return false;
}


function fcEnviar(){

    var v_tipo_material_pk = $("#tipo_material_pk").val();
    var v_material_pk = $("#material_pk").val();
    var v_qtde_material = $("#qtde_material").val();
    var v_dt_entrega = $("#dt_entrega").val();
    var v_dt_devolucao = $("#dt_devolucao").val();
    var v_obs = $("#obs").val();
    var v_colaborador_pk = $("#colaborador_pk").val();


    var objParametros = {
        "pk": pk,
        "tipo_material_pk": encodeURIComponent(v_tipo_material_pk),
        "material_pk": encodeURIComponent(v_material_pk),
        "qtde_material": encodeURIComponent(v_qtde_material),
        "dt_entrega": encodeURIComponent(v_dt_entrega),
        "dt_devolucao": encodeURIComponent(v_dt_devolucao),
        "obs": encodeURIComponent(v_obs),
        "colaborador_pk": encodeURIComponent(v_colaborador_pk)        
    };    

    var arrEnviar = carregarController("colaboradores_materiais", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("colaboradores_materiais_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}



function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("colaboradores_materiais", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#tipo_material_pk").val(arrCarregar.data[0]['tipo_material_pk']);
            $("#material_pk").val(arrCarregar.data[0]['material_pk']);
            $("#qtde_material").val(arrCarregar.data[0]['qtde_material']);
            $("#dt_entrega").val(arrCarregar.data[0]['dt_entrega']);
            $("#dt_devolucao").val(arrCarregar.data[0]['dt_devolucao']);
            $("#obs").val(arrCarregar.data[0]['obs']);
            $("#colaborador_pk").val(arrCarregar.data[0]['colaborador_pk']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcAbrirFormNovoMaterial(){

    //limpa os dados de qualquer registro existe
    fcLimparFormMaterial();
    
    $("#janela_materiais").modal();
    $("#acao").val("ins");
    $("#materiais_pk").val("");
}
function  fcLimparFormMaterial(){
    $("#acao").val("");
    $("#tipo_material_pk").val("");
    $("#material_pk").val("");
    $("#dt_entrega").val("");
    $("#dt_devolucao").val("");
    $("#obs").val("");      
}

$(document).ready(function(){
        //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdIncluirMaterial', fcAbrirFormNovoMaterial); 

    $('#dt_entrega').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#dt_entrega").keypress(function(){
       mascara(this,mdata);
    });
    $("#dt_entrega").keypress(function(){
       mascara(this,horamask);
    });

    $('#dt_devolucao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#dt_devolucao").keypress(function(){
       mascara(this,mdata);
    });
    $("#dt_devolucao").keypress(function(){
       mascara(this,horamask);
    });
    fcCarregarGridMateriais();
    
    
    //Atribui a validação do formulário dos campos obrigatórios
    fcValidarForm();
});
