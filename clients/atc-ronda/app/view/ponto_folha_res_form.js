var tblResultado;
function fcPesquisar(){
//alert(1);
    tblResultado.clear().destroy();
    fcCarregarGrid();
}
function fcVoltar(){
    sendPost("menu_rh.php", {token: token});
}
function fcIncluir(){

    sendPost('ponto_folha_cad_form.php',{token: token, pk: ''});
}

function fcEditar(v_pk){

    sendPost('ponto_folha_registros_res_form.php', {token: token, pk: v_pk});
}

function fcExcluir(v_pk){

    if (confirm("Deseja realmente excluir o registro ?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("ponto_folha", "excluir", objParametros);   
            NewWindow(v_last_url)
            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                location.reload(true);

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
    "empresas_pk": $("#empresas_pk").val(),
    "leads_pk": $("#leads_pk").val(),
    "dt_periodo_ini": $("#dt_periodo_ini").val(),
    "dt_periodo_fim": $("#dt_periodo_fim").val(),
    "ic_status": $("#ic_status").val()
};  

var arrCarregar = carregarController("ponto_folha", "listarDataTable", objParametros);
if (arrCarregar.result == 'success' && arrCarregar.data[0]['t_pk'] != "") {
    if (arrCarregar.data[0]['t_pk'] != 0) {
        vhtml = "";
        vhtml += "        <div>";
        for(var i=0; i < arrCarregar.data.length; i++){
            vhtml += "          <ul>";
            vhtml += "              <span class='caret'>";
            vhtml +=                    arrCarregar.data[i]['t_ds_lead'];
            vhtml += "              </span>";
            vhtml += "              <ul class='nested'>";
            vhtml += "                  <br><span><b>Ano Folha</b></span><br>";
            for(var l=0; l < arrCarregar.data[i]['t_mesesNoAno'].length; l++){
                vhtml += "                  <span>";
                vhtml +=                       arrCarregar.data[i]['t_mesesNoAno'][l]['ds_ano'];
                vhtml += "                  </span><br>";
                vhtml += "                  <ul>";
                vhtml += "                      <span>";
                vhtml += "                          <b>Folhas Por Mês</b>";
                vhtml += "                      </span><br>";
                    for(var a=0; a < arrCarregar.data[i]['t_mesesNoAno'][l]['ds_meses'].length; a++){
                        vhtml += "                      <span>";
                        vhtml +=                            arrCarregar.data[i]['t_mesesNoAno'][l]['ds_meses'][a]['mes_periodo_ini'] + " - " +arrCarregar.data[i]['t_mesesNoAno'][l]['ds_meses'][a]['ponto_folha_pk']  + " - ";
                        vhtml += "                          <img width=20 height=20 src='../img/copiar.png' class='listaFolha' onclick='fcEditar("+arrCarregar.data[i]['t_mesesNoAno'][l]['ds_meses'][a]['ponto_folha_pk']+")'>";
                        vhtml += "                          <img width=18 height=18 src='../img/excluir.png' class='listaFolha' onclick='fcExcluir("+arrCarregar.data[i]['t_mesesNoAno'][l]['ds_meses'][a]['ponto_folha_pk']+")'>";
                        vhtml += "                        <br>";
                        vhtml += "                     </span>";
                    }
                vhtml += "                  </ul>";
            }
            vhtml += "              </ul>";
            vhtml += "           </ul>";
            vhtml += "           <hr>";
        }
        vhtml += "        </div>";
        $('#tblResultado').append(vhtml);
    }
}

var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("caret-down");
    });
}
   
    
}

//combos
function fcComboEmpresas(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("conta", "listarPk", objParametros);    
    
    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_conta");         
}

function fcCarregarLeads(){
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("lead", "listarLeadsCombo", objParametros); 

    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");    
}

$(document).ready(function(){

    //Combo e mascaras
    fcComboEmpresas();

    fcCarregarLeads();

    $(".chzn-select").chosen({allow_single_deselect: true});
    
    $("#leads_pk").change(function(){
        $(".chzn-select").chosen('destroy');
        fcCarregarColaborador();
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    
    $('#dt_periodo_ini').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();

    $("#dt_periodo_ini").keypress(function(){
       mascara(this,mdata);
    });
    
    $('#dt_periodo_fim').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_periodo_fim").keypress(function(){
       mascara(this,mdata);
    });

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);    
    $(document).on('click', '#cmdVoltar', fcVoltar); 
    //faz a carga inicial do grid.
    fcCarregarGrid();
});


