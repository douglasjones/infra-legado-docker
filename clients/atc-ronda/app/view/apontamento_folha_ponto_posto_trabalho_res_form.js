var tblResultado;


function fcPesquisar(){

    tblResultado.clear().destroy();
    fcCarregarGrid();

}



function fcAbrirModal(pk,leads_pk,dt_periodo_ini,dt_periodo_fim){
    $("#janela").modal();
    $("#grid_informativo_colaboradores").empty();
    var str = ""; 
    $("#periodo").text(dt_periodo_ini+" até "+dt_periodo_fim);
    
    var objParametros = {
        "pk": pk,
        "leads_pk": leads_pk,
        "dt_periodo_ini":dt_periodo_ini,
        "dt_periodo_fim":dt_periodo_fim,
        "ic_modal_exibicao":1
    };
    var arrCarregar = carregarController("ponto_folha", "listarModalPontoFolhaPostoTrabalho", objParametros);
        
        
        str +="<table style='border-style: solid;width=100%' width=100%>";
        str +="<thead>";
        str +="<tr style='border-style: solid;width=100%' align=center>";
        
        str +="<th style='border-style: solid;' align=center>";
        str +="<b>Colaborador";
        str +="</b>";
        str +="</th>";
        str +="<th  style='border-style: solid;' align=center>";
        str +="<b>Ação";
        str +="</b>";
        str +="</th>";
        
        str +="</tr>";
        str +="</thead>";
        str +="<tbody>";
    
    
    
    
        for(j=0;j<arrCarregar.data.length;j++){
            $("#ds_lead").text(arrCarregar.data[0]['t_ds_lead'])
            str +="<tr style='border-style: solid;'>";            
            str +="<td style='border-style: solid;' align=center>";  
            str += arrCarregar.data[j]['t_ds_colaborador'];       
            str +="</td>";
            str +="<td style='border-style: solid;' align=center>";  
            str += "<a class='function_edit' onclick='fcImprimir("+'"'+dt_periodo_ini+'"'+","+'"'+dt_periodo_fim+'"'+","+leads_pk+","+arrCarregar.data[j]['t_colaborador_pk']+","+pk+")'><span><img width=16 height=16 src='../img/copiar.png'></span></a>";       
            str +="</td>";
            
            str +="</tr>";   
        

        } 
        str +="</tbody>";
        str +="</table>";
        $("#grid_informativo_colaboradores").append(str);
   
}

function fcCarregarGrid(){
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "colaborador_pk": $("#colaborador_pk_pesq").val(),
        "dt_periodo_ini": $("#dt_periodo_ini_pesq").val(),
        "dt_periodo_fim": $("#dt_periodo_fim_pesq").val()
    };

    var v_url = montarUrlController("ponto_folha", "listarGridPontoFolhaPostoTrabalho", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/impressora.png'></span></a>"
            },
            {"targets": -2, "data": "t_dt_periodo_fim"},
            {"targets": -3, "data": "t_dt_periodo_ini"},
            {"targets": -4, "data": "t_dt_cadastro"},
            {"targets": -5, "data": "t_ds_lead"},
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
        fcAbrirModal(data['t_pk'],data['t_leads_pk'],data['t_dt_periodo_ini'],data['t_dt_periodo_fim']);

    } );
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcImprimir(data['t_dt_periodo_ini'],data['t_dt_periodo_fim'],data['t_leads_pk'],'',data['t_pk']);

    } );
}

function fcCarregarGenero(){
    //Carrega os grupos
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("genero", "listarTodos", objParametros); 
    carregarComboAjax($("#generos_pk"), arrCarregar, " ", "pk", "ds_genero");
    
}

function fcCarregarQualificacao(){

    var objParametros = {
        "pk": ""

    };

    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);
    carregarComboAjax($("#produtos_servicos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}
function fcCarregarColaboradorPesq(){

    var objParametros = {
       "leads_pk": $("#leads_pk").val()

    };

    var arrCarregar = carregarController("lead", "listarColaboradoresEscala", objParametros);
 
    carregarComboAjax($("#colaborador_pk_pesq"), arrCarregar, " ", "colaboradores_pk", "ds_colaborador");
}

function fcCarregarGridColaborador(){	
    $("#grid_colaboradores").empty();
    if($("#leads_pk_cad").val()!=""){
        var str = ""; 
        var objParametros = {
            "leads_pk": $("#leads_pk_cad").val()
        };
        var arrCarregar = carregarController("lead", "listarColaboradoresEscala", objParametros); 
            str +="<table style='width=100%' width=100% ";
            str +="<tr>";
            str +="         <td>";
            str +="             <table style='width=100%' align=center>";
            str +="                 <tr>";
            str +="                     <td  aling=center>";
            str +="                         <input type='checkbox' name='colaboradores_pk_cad[]' id='colaboradores_pk_cad' onclick='marcarTodos(this.checked)'/>";
            str +="                     </td>";
            str +="                     <td  aling=center>";
            str +="                         <b>Selecionar Todos</b>";
            str +="                     </td>";
            str +="                 </tr>";
            str +="             </table>";
            str +="         </td>";
            str +="      </tr>";
            str +="  </table>";

            str +="<table style='border-style: solid;width=100%' width=100%>";
            str +="<thead>";
            str +="<tr style='border-style: solid;width=100%' align=center>";

            str +="<th colspan=2 style='border-style: solid;' align=center>";
            str +="<b>Colaborador";
            str +="</b>";
            str +="</th>";

            str +="</tr>";
            str +="</thead>";
            str +="<tbody>";




            for(j=0;j<arrCarregar.data.length;j++){

                str +="<tr style='border-style: solid;'>";
                str +="<td style='border-style: solid;' align=center>";
                str +="<input type='checkbox' name='colaboradores_pk_cad[]' id='colaboradores_pk_cad' value='"+arrCarregar.data[j]['colaboradores_pk']+"' >";
                str +="</td>";

                str +="<td style='border-style: solid;' align=center>";  
                str += arrCarregar.data[j]['ds_colaborador'];       
                str +="</td>";

                str +="</tr>";   


            } 
            str +="</tbody>";
            str +="</table>";
    }
    
        $("#grid_colaboradores").append(str);
        
}

function fcValidarForm(){

    $("#form").validate({
        rules :{
            leads_pk_cad:{
                required:true
            },
            dt_periodo_ini:{
                required:true
            },
            dt_periodo_fim:{
                required:true
            }

        },
        messages:{
            leads_pk_cad:{
                required:"Por favor, informe Posto de Trabalho"
              
            },
            dt_periodo_ini:{
                required:"Por favor, informe Data Início"
              
            },
            dt_periodo_fim:{
                required:"Por favor, informe Data Fim"
              
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){
    var itens = document.getElementsByName('colaboradores_pk_cad[]');
    
    if(itens.length==0){
        alert("Por favor, selecione um Colaborador");
        return false;
    }
    
    var strJSONDados = fcFormatarDadosColaborador();
    

    var objParametros = {
        "pk": "",
        "leads_pk": $("#leads_pk_cad").val(),
        "dt_periodo_ini": $("#dt_periodo_ini").val(),
        "dt_periodo_fim": $("#dt_periodo_fim").val(),
        "obs": $("#obs").val(),
        "arrColaborador": strJSONDados
    };    

    var arrEnviar = carregarController("ponto_folha", "salvar", objParametros);   
    
    if (arrEnviar.result == 'success'){
        alert("Registro salvo com sucesso.");
        $("#janela_folha").modal("hide");
        tblResultado.clear().destroy();
        fcCarregarGrid();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
    
    
    
}
function fcMigar(){
    var objParametros = {
        "pk": ""
    };    

    var arrEnviar = carregarController("ponto_folha", "migrarPontoFolha", objParametros);   
   
    if (arrEnviar.result == 'success'){
        alert("Registros Migrados com sucesso.");
        
        tblResultado.clear().destroy();
        fcCarregarGrid();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
    
    
    
}


function fcImprimir(dt_periodo_ini,dt_periodo_fim,leads_pk,colaborador_pk,pk){
    
    //get the modal box content and load it into the printable div
    sendPost('apontamento_folha_ponto_impressao.php',{token: token, ponto_folha_pk:pk,leads_pk: leads_pk,dt_periodo_ini:dt_periodo_ini,dt_periodo_fim:dt_periodo_fim,colaborador_pk:colaborador_pk});
}

function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
   
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");         
    carregarComboAjax($("#leads_pk_cad"), arrCarregar, " ", "pk", "ds_lead");         
}

function marcarTodos(marcar){
    //pega o checkbox pelo name 
    var itens = document.getElementsByName('colaboradores_pk_cad[]');
    //faz um for com todos os checkbox que tem no formulario com o nome que está na variavel itens ,marcando ou desmarcando
    var i = 0;
    for(i=0; i<itens.length;i++){
        itens[i].checked = marcar;
    }
}
function fcGerar(){
    $("#grid_colaboradores").empty();
    $("#grid_colaboradores").append("");
    $("#dt_periodo_ini").val("");
    $("#dt_periodo_fim").val("");
    $("#leads_pk_cad").val("");
    
    
    $(".chzn-select").chosen('destroy');
    
    
    $("#janela_folha").modal();
    
    setTimeout(function(){
        $(".chzn-select").chosen({allow_single_deselect: true}); 
    }, 1000);
}


function fcFormatarDadosColaborador(){  
    
    var itens = document.getElementsByName('colaboradores_pk_cad[]');
    var arrKeys = [];

    arrKeys[0] = "colaborador_pk";
    var  s = '[';
    for(i=0; i<itens.length;i++){
        if(itens[i].checked){
            if(itens[i].value!="on"){
                s += "{";

                    s += '"colaborador_pk":"' + itens[i].value + '"';

                s += "}";
                if (i < (itens.length-1)) {
                    s += ',';
                }

            }
        }
        
    }
   
    s += ']';
    
    return(s);
    
}

$(document).ready(function(){

    //faz a carga inicial do grid.
    fcCarregarLeads();
    
    fcCarregarGenero();

    fcCarregarQualificacao();
    
    fcCarregarColaboradorPesq();

    fcCarregarGrid();
    
    
    


    $('#leads_pk').change(function() {
        $(".chzn-select").chosen('destroy');
        fcCarregarColaboradorPesq();
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    
    $('#leads_pk_cad').change(function() {
        fcCarregarGridColaborador();
    });
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcGerar);
    //$(document).on('click', '#cmdMigrar', fcMigar);


    $('#dt_periodo_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 

    $("#dt_periodo_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_periodo_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 

    $("#dt_periodo_fim").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_periodo_ini_pesq').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_periodo_ini_pesq").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_periodo_fim_pesq').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_periodo_fim_pesq").keypress(function(){
       mascara(this,mdata);
    });

    fcValidarForm();

    

});



