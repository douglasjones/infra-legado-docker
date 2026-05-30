var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();  

if(dd<10) {
    dd = '0'+dd
} 
if(mm<10) {
    mm = '0'+mm
}   
var dtAtual = dd+'/'+mm+'/'+yyyy;
function fcCarregarFuncaoColaborador(){
    
    
    
    var objParametros = {
        "pk": pk
    };        

    var arrCarregar = carregarController("colaborador", "listarPk", objParametros);

    if (arrCarregar.result == 'success'){

        $(".ds_colaborador_impr").text(arrCarregar.data[0]['ds_colaborador'])
        $(".ds_re_impr").text(arrCarregar.data[0]['ds_re'])
        $(".ds_secao_impr").text(arrCarregar.data[0]['ds_secao'])
        $(".dt_demissao_imp").text(arrCarregar.data[0]['dt_demissao'])
        $(".dt_admissao_impr").text(arrCarregar.data[0]['dt_admissao'])

    }
    else{
        alert('Falhar ao carregar o registro');
    }
    
    
    
        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("produto_servico", "listarFuncaoColaborador", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_produto_servico_impr").text(arrCarregar.data[0]['ds_produto_servico']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    
    
}
function fcCarregarUsuarioLogado(){
        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_usuario_logado").text(arrCarregar.data[0]['ds_usuario']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    
    
}
function fcCarregarMateriaisImpressao(){
    
    var objParametros = {
       "leads_pk": leads_pk,
       "colaborador_pk": pk,
       "conjunto_material_pk":conjunto_material_pk
    };     

    var v_url = montarUrlController("movimentacao_estoque", "listar_impressao", objParametros);
   
    //Trata a tabela
    tblMaterialImpressao = $('#tblMaterialImpressao').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
           {"targets": -1, "data": "assinatura"}, 
           {"targets": -2, "data": "ds_produtos"},   
           {"targets": -3, "data": "qtde"},
           {"targets": -4, "data": "dt_devolucao"},           
           {"targets": -5, "data": "dt_entrega"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });    
    
    
    return false;
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
function fcVoltar(){
    if(local==1){
        sendPost('menu_colaborador_cad_form.php',{token: token, pk: pk});
    }
    else if(local==2){
        sendPost('movimentar_material_prod_res_form.php',{token: token, pk: pk});
    }
    else{
       
        sendPost('colaborador_cad_form.php',{token: token, colaborador_pk: pk});
    }
    
}
function fcImprimir(){
    window.print();
    
}
$(document).ready(function(){
    $("#exibir_colaborador").hide();
    if(pk!=""){
        $("#exibir_colaborador").show();
        fcCarregarFuncaoColaborador();
    }
    
    fcCarregarMateriaisImpressao();
    fcCarregarUsuarioLogado();
    
   /*document.getElementById("cmdImprimirModal").onclick = function () {
        printElement(document.getElementById("printThis"));
    }*/
    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimirModal', fcImprimir);
    
    
    
    $("#dt_atual").text(dtAtual);
    $("#dt_entrega").text(dtAtual);
});