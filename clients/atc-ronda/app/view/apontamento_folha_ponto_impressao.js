function fcAbrirModalFolha(ponto_folha_pk,dt_periodo_ini,dt_periodo_fim,leads_pk,colaborador_pk){    
    $("#grid").empty();
    $("#grid").append("");
    $("#gridPrint").empty();
    $("#gridPrint").append("");
    var mesAno = dt_periodo_ini;
    var str = "";
    var strP = "";
    var strG = "";
    var arrDatas = dt_periodo_ini.split("/");
    var arrDatasFim = dt_periodo_fim.split("/");
    
    
    var objParametros = {
        "pk": ponto_folha_pk,
        "leads_pk": leads_pk,
        "dt_periodo_ini":dt_periodo_ini,
        "dt_periodo_fim":dt_periodo_fim,
        "colaborador_pk":colaborador_pk,
        "ic_modal_exibicao":1
    };
    var arrCarregar = carregarController("ponto_folha", "listarImpressaoPontoFolhaPostoTrabalho", objParametros);
    
    if (arrCarregar.result == 'success'){
                
        for(t=0;t<arrCarregar.data.length;t++){            
            //PEGA A EMPRESA DO COLABORADOR
            var objParametrosConta = {
                "pk":arrCarregar.data[t]['t_colaborador_pk']
            };    

            var arrCarregarConta = carregarController("colaborador", "listarPk", objParametrosConta); 
            
            if (arrCarregarConta.result == 'success'){
                if(arrCarregarConta.data.length > 0){
                    if(arrCarregarConta.data[0]['ds_razao_social_empresa']!=null){
                        
                        var ds_empresa = arrCarregarConta.data[0]['ds_razao_social_empresa'];
                    }
                    else{
                        var ds_empresa =  " ";
                    }
                    if(arrCarregarConta.data[0]['ds_cpf_cnpj_empresa']!=null){
                        var ds_cnpj = arrCarregarConta.data[0]['ds_cpf_cnpj_empresa'];
                    }
                    else{
                        var ds_cnpj =  " ";
                    }
                    if(arrCarregarConta.data[0]['ds_endereco_empresa']!=null){
                        var ds_endereco = arrCarregarConta.data[0]['ds_endereco_empresa'];
                    }
                    else{
                        var ds_endereco =  " ";
                    }                    
                }
            }
            
            //CASO CONTRARIO PEGA A EMPRESA DO LEAD
            if(arrCarregarConta.data[0]['ds_razao_social_empresa']==null){

            
                var objParametrosContaLead = {
                    "pk":leads_pk
                };    

                var arrCarregarContaLead = carregarController("lead", "listarEmpresaLead", objParametrosContaLead); 
              
                if (arrCarregarContaLead.result == 'success'){
                    if(arrCarregarContaLead.data.length>0){
                        if(arrCarregarContaLead.data[0]['ds_razao_social']!=null){
                            var ds_empresa = arrCarregarContaLead.data[0]['ds_razao_social'];
                        }
                        else{
                            var ds_empresa =  " ";
                        }
                        if(arrCarregarContaLead.data[0]['ds_cpf_cnpj']!=null){
                            var ds_cnpj = arrCarregarContaLead.data[0]['ds_cpf_cnpj'];
                        }
                        else{
                            var ds_cnpj =  " ";
                        }
                        if(arrCarregarContaLead.data[0]['ds_endereco']!=null){
                            var ds_endereco = arrCarregarContaLead.data[0]['ds_endereco'];
                        }
                        else{
                            var ds_endereco =  " ";
                        }
                    }
                }
            }
            
            
            var objParametrosColab = {
                "pk":arrCarregar.data[t]['t_colaborador_pk']
            };    

            var arrCarregarColab = carregarController("colaborador", "listarPorPkEFuncao", objParametrosColab); 
            
            if (arrCarregarColab.result == 'success'){                
                var ds_colaborador = arrCarregarColab.data[0]['ds_colaborador'];
                if(arrCarregarColab.data[0]['ds_ctps']!=null){
                    var ds_ctps = arrCarregarColab.data[0]['ds_ctps']+" / "+arrCarregarColab.data[0]['ds_serie'];
                }
                else{
                    var ds_ctps = "";
                }
                
                var dt_admissao = arrCarregarColab.data[0]['dt_admissao'];
                var ds_produto_servico = arrCarregarColab.data[0]['ds_produto_servico'];
                
            }
            
            //PRINT
            strP +="<div class='row' >";
            
            strP +="<div class='col-md-11'>";
            
            
            //GRID NAVEGADOR
            str +="<div class='row '>";
            str +="<div class='col-md-1'>&nbsp;</div>";
            str +="<div class='col-md-9'>";
            
            str +="<table style='width=100%'>";
            str +="<thead>";
            str +="<tr style='border-style: solid;width=100%' align=center>";
            str +="<th colspan='6' nowrap style='border-style: solid;background-color:cdcdcd'align=center>";
            str +="<b>Dados do Empregador";
            str +="</b>";
            str +="</th>";

            str +="</tr>";
            str +="<tr>";
            str +="<th colspan=4 style='border-style: solid;' align=center>Empregador: Nome/Empresa<br>";
            str+=ds_empresa;
            str +="</th>";
            str +="<th colspan=2 style='border-style: solid;' align=center>CEI/CNPJ Nº<br>";
            str+=ds_cnpj;
            str +="</th>";
            str +="</tr>";
            str +="<tr>";
            str +="<th colspan=6 style='border-style: solid;' align=center>Enderço:<br>";
            str+=ds_endereco;
            str +="</th>";
            str +="</tr>";
            str +="<tr style='border-style: solid;width=100%' align=center>";
            str +="<th colspan='6' nowrap style='border-style: solid;background-color:cdcdcd'align=center>";
            str +="<b>Dados do Empregado";
            str +="</b>";
            str +="</th>";

            str +="</tr>";
            str +="<tr>";
            str +="<th colspan=6 style='border-style: solid;' align=center>Nome<br>";
            str+=ds_colaborador;
            str +="</th>";
            str +="</tr>";

            str +="<tr>";
            str +="<th colspan=4 style='border-style: solid;' align=center>CTPS Nº e Série:<br>";
            str+=ds_ctps;
            str +="</th>";
            str +="<th colspan=2 style='border-style: solid;' align=center>Função:<br>";
            str+=ds_produto_servico;
            str +="</th>";
            str +="</tr>";
            str +="<tr>";
            str +="<th colspan=4 style='border-style: solid;' align=center>Data Admissão:<br>";
            str+=dt_admissao;
            str +="</th>";
            str +="<th  colspan=2 style='border-style: solid;' align=center>Período Folha:<br>";
            str+=dt_periodo_ini+" até "+dt_periodo_fim;
            str +="</th>";
            str +="</tr>";
            str +="<tr>";
            str +="<th colspan=6 style='border-style: solid;' align=center>Posto de Trabalho:<br>";
            str+=arrCarregar.data[t]['t_ds_lead'];
            str +="</th>";
            str +="</tr>";
            
            
            str +="<tr style='border-style: solid;width=100%' align=center>";
            str +="<th rowspan='2' nowrap style='border-style: solid;'align=center>";
            str +="<b>Dia";
            str +="</b>";
            str +="</th>";
            str +="<th rowspan='2' nowrap style='border-style: solid;' align=center>";
            str +="<b>Entrada";
            str +="</b>";
            str +="</th>";
            str +="<th colspan='2' style='border-style: solid;' align=center>";
            str +="<b>Intervalo";
            str +="</b>";
            str +="</th>";
            str +="<th rowspan='2' nowrap style='border-style: solid;' align=center>";
            str +="<b>Saida";
            str +="</b>";
            str +="</th>";
            
            str +="<th class='noprint' rowspan='2' nowrap style='border-style: solid;' align=center> ";
            str +="<b>Ação";
            str +="</b>";
            str +="</th>";
            /*str +="<th rowspan='2' nowrap style='border-style: solid;' align=center> ";
            str +="<b>Hora Extra";
            str +="</b>";
            str +="</th>";*/
            

            str +="</tr>";
            str +="<tr>";
            str +="<th style='border-style: solid;' align=center>Saida";
            str +="</th>";
            str +="<th style='border-style: solid;' align=center>Retorno";
            str +="</th>";


            str +="</tr>";
            str +="</thead>";
            str +="<tbody>";



             var objParametrosEntrada = {
                "pk": ponto_folha_pk,
                "leads_pk": leads_pk,
                "colaborador_pk":arrCarregar.data[t]['t_colaborador_pk'],
                "dt_periodo_ini": arrDatas[0]+"/"+(arrDatas[1])+"/"+arrDatas[2],
                "dt_periodo_fim": arrDatasFim[0]+"/"+(arrDatasFim[1])+"/"+arrDatasFim[2]
                };    

            var arrCarregarEntrada = carregarController("ponto_folha", "listarPontoColaborador", objParametrosEntrada); 

           var dt_periodo_ini1 = dt_periodo_ini;
           
            for(i = 0 ;i< 31;i++){
              
                var dataSplitFim = dt_periodo_fim.split('/');

                var dayFim = dataSplitFim[0]; // 15
                var monthFim = dataSplitFim[1]; // 04
                var yearFim = dataSplitFim[2]; // 2019
                
                var data_fim = new Date(yearFim, monthFim - 1, dayFim);


                var dataSplit = dt_periodo_ini1.split('/');

                var day = dataSplit[0]; // 15
                var month = dataSplit[1]; // 04
                var year = dataSplit[2]; // 2019

                // Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
                var data_inicio = new Date(year, month - 1, day);
                if(data_inicio <= data_fim){
                    
                    if(i< 9){
                        var dia = "0"+(i+1);
                    }
                    else{
                        var dia = (i+1);
                    }

                    var hr_turno ;
                    var hr_turno_saida;
                    var hora_entrada = "";
                    var pk_entrada = "";
                    var ds_legenda = "";
                    var ds_registro_ponto ="";
                    var hora_saida ="";
                    var pk_saida ="";
                    var hora_saida_intervalo = "";
                    var pk_saida_intervalo = "";
                    var hora_entrada_retorno = "";
                    var pk_entrada_retorno = "";
                    
                    var data = new Date(arrDatas[2], arrDatas[1] - 1, dia);
                    var count_ferias ="";
                    var count_afastamento ="";
                    var count_atestado ="";
                    var colaborador_ferias ="";
                    var dt_hora_extra ="";
                    var count_falta ="";
                    var colaborador_falta ="";
                    var dt_hora_ponto ="";
                    var HoraExtra ="";
                    
                    var objParametrosFalta = {
                        "leads_pk": leads_pk,
                        "colaborador_pk":arrCarregar.data[t]['t_colaborador_pk'],
                        "dt_ini": dia+"/"+(dataSplit[1])+"/"+dataSplit[2],
                        "dt_fim": dia+"/"+(dataSplit[1])+"/"+dataSplit[2]
                    };    

                    var arrCarregarFalta = carregarController("colaborador_falta", "listarFaltaParaPonto", objParametrosFalta)
                          
                    if(arrCarregarFalta.data.length > 0){
                        if(arrCarregarFalta.data[0]['count_falta']!=""){
                             count_falta = arrCarregarFalta.data[0]['count_falta'];
                            if(arrCarregarFalta.data[0]['ds_colaborador_falta']!=""){
                                 colaborador_falta = arrCarregarFalta.data[0]['ds_colaborador_falta'];
                            }
                        }
                        else if(arrCarregarFalta.data[0]['count_ferias']!=""){
                             count_ferias = arrCarregarFalta.data[0]['count_ferias'];
                            if(arrCarregarFalta.data[0]['ds_colaborador_ferias']!=""){
                                 colaborador_ferias = arrCarregarFalta.data[0]['ds_colaborador_ferias'];
                            }
                        }
                        else if(arrCarregarFalta.data[0]['count_afastamento']!=""){
                            count_afastamento = arrCarregarFalta.data[0]['count_afastamento'];
                            
                        }
                        else if(arrCarregarFalta.data[0]['count_atestado']!=""){
                            count_atestado = arrCarregarFalta.data[0]['count_atestado'];
                            
                        }
                        
                    }
                    
                    if(arrCarregarEntrada.data.length > 0){
                        
                        for(j=0;j<arrCarregarEntrada.data.length;j++){
                            var dt_hora_ponto = "";
                            
                            if(arrCarregarEntrada.data[j]['dt_hora_ponto']!=null){
                            
                                var dataSplitPonto = dt_hora_ponto.split('/');

                                var dayPonto = dataSplitPonto[0]; // 15
                                var monthPonto = dataSplitPonto[1]; // 04
                                var yearPonto = dataSplitPonto[2]; // 2019

                                var data_ponto = new Date(yearPonto, monthPonto - 1, dayPonto);
                          
                                //if(data_inicio == data_ponto){
                                    var dt_hora_ponto = arrCarregarEntrada.data[j]['dt_hora_ponto'];
                                //}
                            }
                            
                          
                            if(arrCarregarEntrada.data[j]['dt_hora_ponto_entrada']==dt_periodo_ini1){ 

                                hora_entrada = arrCarregarEntrada.data[j]['dt_rh_entratada'];     
                                pk_entrada = arrCarregarEntrada.data[j]['ponto_pk_entratada'];     
                            }
                            if(arrCarregarEntrada.data[j]['dt_hora_ponto_saida']==dt_periodo_ini1){   
                                hora_saida = arrCarregarEntrada.data[j]['dt_rh_saida'];     
                                pk_saida = arrCarregarEntrada.data[j]['ponto_pk_saida'];     
                            }
                            if(arrCarregarEntrada.data[j]['dt_hora_ponto_saida_intervalo']==dt_periodo_ini1){ 
                                hora_saida_intervalo = arrCarregarEntrada.data[j]['dt_rh_saida_intervalo'];     
                                pk_saida_intervalo = arrCarregarEntrada.data[j]['ponto_pk_saida_intervalo'];     
                            }
                            if(arrCarregarEntrada.data[j]['dt_hora_ponto_entrada_retorno']==dt_periodo_ini1){    
                                hora_entrada_retorno = arrCarregarEntrada.data[j]['dt_rh_entratada_retorno'];     
                                pk_entrada_retorno = arrCarregarEntrada.data[j]['ponto_pk_volta_intervalo'];     
                            }
                                  
                        } 
                    }
                   
                    if(hora_entrada!=""){
                      
                       str +="<tr style='border-style: solid;'>";
                        str +="<td style='border-style: solid;' align=center>";
                        str +="<input type='hidden' id='dt_hora_ponto"+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' value='"+dt_periodo_ini1+"'>";
                        str +="<b>"+dt_periodo_ini1;
                        str +="</b>";
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";  
                        if(hora_entrada!=""){
                           str +="<input type='text'  id='hr_entrada"+i+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+hora_entrada+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",1,"+pk_entrada+","+ponto_folha_pk+")'>";

                        }
                        else{
                            str +="<input type='text'  id='hr_entrada"+i+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",1,0,"+ponto_folha_pk+")'>";
                        }
                               
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        
                        if(hora_saida_intervalo!=""){
                            str +="<input type='text'  id='hr_saida_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+hora_saida_intervalo+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",3,"+pk_saida_intervalo+","+ponto_folha_pk+")'>";
                        }
                        else{
                            str +="<input type='text'  id='hr_saida_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",3,0,"+ponto_folha_pk+")'>";
                        }
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        if(hora_entrada_retorno!=""){
                            str +="<input type='text'  id='hr_volta_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+hora_entrada_retorno+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",4,"+pk_entrada_retorno+","+ponto_folha_pk+")'>";
                        
                        }
                        else{
                            str +="<input type='text'  id='hr_volta_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",4,0,"+ponto_folha_pk+")'>";
                        }
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center> ";
                        if(hora_saida!=""){
                            str +="<input type='text'  id='hr_saida"+i+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+hora_saida+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",2,"+pk_saida+","+ponto_folha_pk+")'>";
                        }
                        else{
                            str +="<input type='text'  id='hr_saida"+i+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",2,0,"+ponto_folha_pk+")'>";
                        }
                        str +="</td>";
                        
                        str +="<td class='noprint' style='border-style: solid;' align=center> ";
                        str += "<select id='select"+i+arrCarregar.data[t]['t_colaborador_pk']+"' onchange='fcSelectSalvarFeriasFolgaFalta("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+","+i+","+ponto_folha_pk+")'><option value='1' selected>Hora</option><option value='2'>Falta</option><option value='3'>Férias</option><option value='4'>Afastamento</option><option value='5'>Atestado</option></select>";
                        str +="</td>";
                        
                        
                        /*str +="<td style='border-style: solid;' align=center> ";
                        str += HoraExtra;
                        str +="</td>";*/
 
                        
                        

                        str +="</tr>"; 
                    }
                    else if(count_falta!=""){
                        str +="<tr style='border-style: solid;'>";
                        str +="<td style='border-style: solid;' align=center>";
                        str +="<input type='hidden' id='dt_hora_ponto"+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+dt_periodo_ini1+"'>";
                        str +="<b>"+dt_periodo_ini1;
                        str +="</b>";
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";  
                        str +="<font id='hr_entrada"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=red><b>Falta</b></font>";       
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        str +="<font id='hr_saida_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=red><b>Falta</b></font>"; 
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        str +="<font id='hr_volta_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=red><b>Falta</b></font>"; 
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center> ";
                        str +="<font id='hr_saida"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=red><b>Falta</b></font>"; 
                        str +="</td>";
                        
                        str +="<td class='noprint' style='border-style: solid;' align=center> ";
                        str += "<select id='select"+i+arrCarregar.data[t]['t_colaborador_pk']+"' onchange='fcSelectSalvarFeriasFolgaFalta("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+","+i+","+ponto_folha_pk+")'><option value='1'>Hora</option><option value='2' selected>Falta</option><option value='3'>Férias</option><option value='4'>Afastamento</option><option value='5'>Atestado</option></select>";
                        str +="</td>";
                        
                        /*str +="<td style='border-style: solid;' align=center> ";
                        str +="<font id='hr_extra"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=red><b>Falta</b></font>"; 
                        str +="</td>";*/
                        
                        

                        str +="</tr>";
                    }
                    else if(count_ferias){
                        str +="<tr style='border-style: solid;'>";
                        str +="<td style='border-style: solid;' align=center>";
                        str +="<b>"+dt_periodo_ini1;
                        str +="</b>";
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";  
                        str +="<font id='hr_entrada"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Férias</b></font>";       
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        str +="<font id='hr_saida_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Férias</b></font>";   
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        str +="<font id='hr_volta_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Férias</b></font>";  
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center> ";
                        str +="<font id='hr_saida"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Férias</b></font>";  
                        str +="</td>";
                        
                        str +="<td class='noprint' style='border-style: solid;' align=center> ";
                        str += "<select id='select"+i+arrCarregar.data[t]['t_colaborador_pk']+"' onchange='fcSelectSalvarFeriasFolgaFalta("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+","+i+","+ponto_folha_pk+")'><option value='1'>Hora</option><option value='2'>Falta</option><option value='3' selected>Férias</option><option value='4' >Afastamento</option><option value='5'>Atestado</option></select>";
                        str +="</td>";
                        
                       /* str +="<td style='border-style: solid;' align=center> ";
                        str +="<font id='hr_extra"+i+arrCarregar.data[t]['t_colaborador_pk']+"'  color=blue><b>Férias</b></font>";  
                        str +="</td>";*/
                         str +="</tr>";
                    }
                    else if(count_afastamento){
                        str +="<tr style='border-style: solid;'>";
                        str +="<td style='border-style: solid;' align=center>";
                        str +="<b>"+dt_periodo_ini1;
                        str +="</b>";
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";  
                        str +="<font id='hr_entrada"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Afastamento</b></font>";       
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        str +="<font id='hr_saida_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Afastamento</b></font>";   
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        str +="<font id='hr_volta_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Afastamento</b></font>";  
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center> ";
                        str +="<font id='hr_saida"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Afastamento</b></font>";  
                        str +="</td>";
                        
                        str +="<td class='noprint' style='border-style: solid;' align=center> ";
                        str += "<select id='select"+i+arrCarregar.data[t]['t_colaborador_pk']+"' onchange='fcSelectSalvarFeriasFolgaFalta("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+","+i+","+ponto_folha_pk+")'><option value='1'>Hora</option><option value='2'>Falta</option><option value='3' >Férias</option><option value='4' selected>Afastamento</option><option value='5'>Atestado</option></select>";
                        str +="</td>";
                        
                        /*str +="<td style='border-style: solid;' align=center> ";
                        str +="<font id='hr_extra"+i+arrCarregar.data[t]['t_colaborador_pk']+"'  color=blue><b>Afastamento</b></font>";  
                        str +="</td>";*/
                        
                        str +="</tr>";
                    }
                    else if(count_atestado){
                        str +="<tr style='border-style: solid;'>";
                        str +="<td style='border-style: solid;' align=center>";
                        str +="<b>"+dt_periodo_ini1;
                        str +="</b>";
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";  
                        str +="<font id='hr_entrada"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Atestado</b></font>";       
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        str +="<font id='hr_saida_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Atestado</b></font>";   
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        str +="<font id='hr_volta_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Atestado</b></font>";  
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center> ";
                        str +="<font id='hr_saida"+i+arrCarregar.data[t]['t_colaborador_pk']+"' color=blue><b>Atestado</b></font>";  
                        str +="</td>";
                        
                        str +="<td class='noprint' style='border-style: solid;' align=center> ";
                        str += "<select id='select"+i+arrCarregar.data[t]['t_colaborador_pk']+"' onchange='fcSelectSalvarFeriasFolgaFalta("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+","+i+","+ponto_folha_pk+")'><option value='1'>Hora</option><option value='2'>Falta</option><option value='3' >Férias</option><option value='4' >Afastamento</option><option value='5' selected>Atestado</option></select>";
                        str +="</td>";
                        
                      
                        str +="</tr>";
                    }
                    else{
                        
                        str +="<tr style='border-style: solid;'>";
                        str +="<td style='border-style: solid;' align=center>";
                        str +="<input type='hidden' id='dt_hora_ponto"+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' value='"+dt_periodo_ini1+"'>";
                        str +="<b>"+dt_periodo_ini1;
                        str +="</b>";
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";  
                        if(hora_entrada!=""){
                           str +="<input type='text'  id='hr_entrada"+i+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+hora_entrada+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",1,"+pk_entrada+","+ponto_folha_pk+")'>";

                        }
                        else{
                            str +="<input type='text'  id='hr_entrada"+i+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",1,0,"+ponto_folha_pk+")'>";
                        }
                               
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        if(hora_saida_intervalo!=""){
                            str +="<input type='text'  id='hr_saida_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+hora_saida_intervalo+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",3,"+pk_saida_intervalo+","+ponto_folha_pk+")'>";
                        }
                        else{
                            str +="<input type='text'  id='hr_saida_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",3,0,"+ponto_folha_pk+")'>";
                        }
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center>";
                        if(hora_entrada_retorno!=""){
                            str +="<input type='text'  id='hr_volta_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+hora_entrada_retorno+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",4,"+pk_entrada_retorno+","+ponto_folha_pk+")'>";
                        
                        }
                        else{
                            str +="<input type='text'  id='hr_volta_intervalo"+i+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",4,0,"+ponto_folha_pk+")'>";
                        }
                        str +="</td>";

                        str +="<td style='border-style: solid;' align=center> ";
                        if(hora_saida!=""){
                            str +="<input type='text'  id='hr_saida"+i+arrCarregar.data[t]['t_colaborador_pk']+"' value='"+hora_saida+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",2,"+pk_saida_intervalo+","+ponto_folha_pk+")'>";
                        }
                        else{
                            str +="<input type='text'  id='hr_saida"+i+arrCarregar.data[t]['t_colaborador_pk']+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+",2,0,"+ponto_folha_pk+")'>";
                        }
                        str +="<td class='noprint' style='border-style: solid;' align=center> ";
                        str += "<select id='select"+i+arrCarregar.data[t]['t_colaborador_pk']+"' onchange='fcSelectSalvarFeriasFolgaFalta("+'"'+dt_periodo_ini1+'"'+",this.value,"+arrCarregar.data[t]['t_colaborador_pk']+","+i+","+ponto_folha_pk+")'><option value='1' selected>Hora</option><option value='2'>Falta</option><option value='3'>Férias</option><option value='4'>Afastamento</option><option value='5'>Atestado</option></select>";
                        str +="</td>";
                        
                        /*str +="</td>";
                        str +="<td style='border-style: solid;' align=center> ";
                        str += HoraExtra;
                        str +="</td>";*/
                        

                        str +="</tr>";  
                    }
                } 
                    
                    
                var p_nova_dt_agenda = dt_periodo_ini1.split("/");


                //pega a data que ja passou pelo for 
                var nova_dt_agenda_dia_anterior = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                var nova_dt_agenda_dia_proximo = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                //a cada looping acrescenta mais um dia 
                nova_dt_agenda_dia_proximo.setDate(nova_dt_agenda_dia_anterior.getDate() + 1);

                var dt_periodo_ini1 = 0;
                var dia = 0;
                var mes = 0;
                var ano = 0;
                if(nova_dt_agenda_dia_proximo.getDate()<10){
                    dia = "0"+nova_dt_agenda_dia_proximo.getDate();
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                }
                else{
                    dia = nova_dt_agenda_dia_proximo.getDate();
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                }

                if((nova_dt_agenda_dia_proximo.getMonth()+1)<10){
                    mes = "0"+(nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();

                }
                else{
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();

                }                
                dt_periodo_ini1 = dia+"/"+mes+"/"+ano;
            }  
            str +="<tr style='border-style: solid;'>";
            str +="<td style='border-style: solid;' colspan=6>";
            
            str +="&nbsp;<p><b>Assinatura:________________________________</b></p>";
            str +="</td>";
            str +="</tr>";
            str +="</tbody>";
            str +="</table>";        
            str +="</div>";
            str +="</div>";   
            str +="</div>";   
            str +="</div>";   
            str +="</div>";   
            str +="</div>";   
     
            str +="</div>";   
            str +="</div>"; 
            str +="<br>";
            

            if(t < (arrCarregar.data.length-1)){

                 str +="<div class='article' style='page-break-after: always'></div>";  
             }
           
           //str +="</page>";  
            
            
            
        }
       
    }
    $("#grid").append(str);
    $("#gridPrint").append(str);
    
    //$("#janela_impressao").modal();
    
}

function fcSalvarPonto(dt_ponto,hr_ponto,colaborador_pk,tipo_ponto,pk,ponto_folha_pk){
    if(hr_ponto.length==5){
        var objParametros = {
            "pk": pk,
            "colaborador_pk": colaborador_pk,
            "tipo_ponto_pk":tipo_ponto,
            "dt_hora_ponto":dt_ponto,
            "ponto_folha_pk":ponto_folha_pk,
            "hr_ponto":hr_ponto+":00"
        };    

        var arrEnviar = carregarController("ponto_folha", "salvarApontamentoPontoEPontoFolha", objParametros);   

      
        if (arrEnviar.result == 'success'){

        }
        else{

        }
    }
    else if(hr_ponto.length==0){
        if(pk!=undefined){
            fcExcluirPonto(dt_ponto,colaborador_pk,pk);
        }
        else{
            fcExcluirPonto(dt_ponto,colaborador_pk,"");
        }
    }
    
}


function fcExcluirPonto(dt_inicio,colaborador_pk,pk){
    var objParametros = {
        "pk": pk,
        "colaborador_pk": colaborador_pk,
        "dt_hora_ponto":dt_inicio
    };              

    var arrExcluir = carregarController("ponto_folha", "excluir_apontamento", objParametros);   

    if (arrExcluir.result == 'success'){

    }
}
function fcExcluirFerias(dt_inicio,colaborador_pk){
    var objParametros = {
        "colaboradores_pk": colaborador_pk,
        "dt_inicio_pausa":dt_inicio,
        "dt_fim_pausa":dt_inicio
    };              

    var arrExcluir = carregarController("agenda_colaborador_pausa", "excluirColaboradorFerias", objParametros);  
    if (arrExcluir.result == 'success'){

    }
}
function fcExcluirFalta(dt_inicio,colaborador_pk){
    var objParametros = {
        "colaborador_pk": colaborador_pk,
        "dt_escala":dt_inicio,
        "leads_pk": leads_pk
    };              

    var arrExcluir = carregarController("colaborador_falta", "excluirColaborador", objParametros);   
    
    if (arrExcluir.result == 'success'){

    }
}
function fcExcluirAfastamento(dt_inicio,colaborador_pk){
    var objParametros = {
        "colaborador_pk": colaborador_pk,
        "dt_inicio":dt_inicio,
        "tipo_apontamento":1
    };              

    var arrExcluir = carregarController("afastamento_ferias_colaborador", "excluirColaborador", objParametros);   
    
    if (arrExcluir.result == 'success'){

    }
}
function fcExcluirAtestado(dt_inicio,colaborador_pk){
    var objParametros = {
        "colaborador_pk": colaborador_pk,
        "dt_inicio":dt_inicio,
        "tipo_apontamento":2
    };              

    var arrExcluir = carregarController("afastamento_ferias_colaborador", "excluirColaborador", objParametros);   
    
    if (arrExcluir.result == 'success'){

    }
}

function fcSalvarFalta(dt_inicio,colaborador_pk){
    
    var objParametros = {
        "pk": "",
        "motivo_falta_pk": 1,
        "colaborador_pk": colaborador_pk,
        "dt_escala": dt_inicio,
        "leads_pk": leads_pk

    }; 

    var arrEnviar = carregarController("colaborador_falta", "salvar", objParametros);
    if (arrEnviar.result == 'success'){

    }
    else{

    }
}
function fcSalvarFerias(dt_inicio,colaborador_pk){
    
    var objParametros = {
        "ds_agenda_colaborador_pausa": "Férias",
        "turnos_pk": 1,
        "dt_inicio_pausa": dt_inicio,
        "dt_fim_pausa": dt_inicio,
        "colaboradores_pk": colaborador_pk
    }; 


    var arrEnviar = carregarController("agenda_colaborador_pausa", "salvar", objParametros);
    if (arrEnviar.result == 'success'){

    }
    else{

    }
}
function fcSalvarAfastamento(dt_inicio,colaborador_pk){
    
    var objParametros = {
        "tipo_apontamento": 1,
        "dt_inicio": dt_inicio,
        "dt_fim": dt_inicio,
        "colaborador_pk": colaborador_pk
    }; 


    var arrEnviar = carregarController("afastamento_ferias_colaborador", "salvar", objParametros);
    if (arrEnviar.result == 'success'){

    }
    else{

    }
}
function fcSalvarAtestado(dt_inicio,colaborador_pk){
    
    var objParametros = {
        "tipo_apontamento": 2,
        "dt_inicio": dt_inicio,
        "dt_fim": dt_inicio,
        "colaborador_pk": colaborador_pk
    }; 


    var arrEnviar = carregarController("afastamento_ferias_colaborador", "salvar", objParametros);
    if (arrEnviar.result == 'success'){

    }
    else{

    }
}

function fcSelectSalvarFeriasFolgaFalta(dt_inicio,tipo_opcao,colaborador_pk,int,ponto_folha_pk){
    
    //HORA
    if(tipo_opcao==1){
        
        fcExcluirFalta(dt_inicio,colaborador_pk);
        fcExcluirFerias(dt_inicio,colaborador_pk);
        fcExcluirAfastamento(dt_inicio,colaborador_pk);
        fcExcluirAtestado(dt_inicio,colaborador_pk);
        
        $("#hr_saida"+int+colaborador_pk).replaceWith("<input type='text' id='hr_saida"+int+colaborador_pk+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_inicio+'"'+",this.value,"+colaborador_pk+",2,0,"+ponto_folha_pk+")'>");
        $("#hr_volta_intervalo"+int+colaborador_pk).replaceWith("<input type='text'  id='hr_volta_intervalo"+int+colaborador_pk+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_inicio+'"'+",this.value,"+colaborador_pk+",4,0,"+ponto_folha_pk+")'>");
        $("#hr_saida_intervalo"+int+colaborador_pk).replaceWith("<input type='text'  id='hr_saida_intervalo"+int+colaborador_pk+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_inicio+'"'+",this.value,"+colaborador_pk+",3,0,"+ponto_folha_pk+")'>");
        $("#hr_entrada"+int+colaborador_pk).replaceWith("<input type='text'  id='hr_entrada"+int+colaborador_pk+"' maxlength='5' onkeypress='mascara(this,horamask)' onchange='fcSalvarPonto("+'"'+dt_inicio+'"'+",this.value,"+colaborador_pk+",1,0,"+ponto_folha_pk+")'>");
        //$("#hr_extra"+int+colaborador_pk).replaceWith("<font></font>");
    }
    //FALTA
    else if(tipo_opcao==2){
        
        
        fcExcluirPonto(dt_inicio,colaborador_pk,"");
        fcExcluirFerias(dt_inicio,colaborador_pk);
        fcExcluirAfastamento(dt_inicio,colaborador_pk);
        fcExcluirAtestado(dt_inicio,colaborador_pk);
        
        fcSalvarFalta(dt_inicio,colaborador_pk);
        
        
        $("#hr_saida"+int+colaborador_pk).replaceWith("<font id='hr_saida"+int+colaborador_pk+"' color=red><b>Falta</b></font>");
        $("#hr_volta_intervalo"+int+colaborador_pk).replaceWith("<font id='hr_volta_intervalo"+int+colaborador_pk+"' color=red><b>Falta</b></font>");
        $("#hr_saida_intervalo"+int+colaborador_pk).replaceWith("<font id='hr_saida_intervalo"+int+colaborador_pk+"' color=red><b>Falta</b></font>");
        $("#hr_entrada"+int+colaborador_pk).replaceWith("<font id='hr_entrada"+int+colaborador_pk+"' color=red><b>Falta</b></font>");
       // $("#hr_extra"+int+colaborador_pk).replaceWith("<font color=red><b>Falta</b></font>");
    }
    /*//FOLGA
    else if(tipo_opcao==3){
        
    }*/
    //FERIAS
    else if(tipo_opcao==3){
        
        fcExcluirPonto(dt_inicio,colaborador_pk,"");
        fcExcluirFalta(dt_inicio,colaborador_pk);
        fcExcluirAfastamento(dt_inicio,colaborador_pk);
        fcExcluirAtestado(dt_inicio,colaborador_pk);
        
        fcSalvarFerias(dt_inicio,colaborador_pk);
        
        
        $("#hr_saida"+int+colaborador_pk).replaceWith("<font id='hr_saida"+int+colaborador_pk+"' color=blue><b>Férias</b></font>");
        $("#hr_volta_intervalo"+int+colaborador_pk).replaceWith("<font id='hr_volta_intervalo"+int+colaborador_pk+"' color=blue><b>Férias</b></font>");
        $("#hr_saida_intervalo"+int+colaborador_pk).replaceWith("<font id='hr_saida_intervalo"+int+colaborador_pk+"' color=blue><b>Férias</b></font>");
        $("#hr_entrada"+int+colaborador_pk).replaceWith("<font id='hr_entrada"+int+colaborador_pk+"' color=blue><b>Férias</b></font>");
        //$("#hr_extra"+int+colaborador_pk).replaceWith("<font color=blue><b>Férias</b></font>");
        
    }
    //AFASTAMENTO
    else if(tipo_opcao==4){
        
        fcExcluirPonto(dt_inicio,colaborador_pk,"");
        fcExcluirFalta(dt_inicio,colaborador_pk);
        fcExcluirFerias(dt_inicio,colaborador_pk);
        fcExcluirAtestado(dt_inicio,colaborador_pk);
        
        fcSalvarAfastamento(dt_inicio,colaborador_pk);
        
        
        $("#hr_saida"+int+colaborador_pk).replaceWith("<font id='hr_saida"+int+colaborador_pk+"' color=blue><b>Afastamento</b></font>");
        $("#hr_volta_intervalo"+int+colaborador_pk).replaceWith("<font id='hr_volta_intervalo"+int+colaborador_pk+"' color=blue><b>Afastamento</b></font>");
        $("#hr_saida_intervalo"+int+colaborador_pk).replaceWith("<font id='hr_saida_intervalo"+int+colaborador_pk+"' color=blue><b>Afastamento</b></font>");
        $("#hr_entrada"+int+colaborador_pk).replaceWith("<font id='hr_entrada"+int+colaborador_pk+"' color=blue><b>Afastamento</b></font>");
       // $("#hr_extra"+int+colaborador_pk).replaceWith("<font color=blue><b>Afastamento</b></font>");
        
    }
    //ATESTADO
    else if(tipo_opcao==5){
        
        fcExcluirPonto(dt_inicio,colaborador_pk,"");
        fcExcluirFalta(dt_inicio,colaborador_pk);
        fcExcluirFerias(dt_inicio,colaborador_pk);
        fcExcluirAfastamento(dt_inicio,colaborador_pk);
        
        fcSalvarAtestado(dt_inicio,colaborador_pk);
        
        
        $("#hr_saida"+int+colaborador_pk).replaceWith("<font id='hr_saida"+int+colaborador_pk+"' color=blue><b>Atestado</b></font>");
        $("#hr_volta_intervalo"+int+colaborador_pk).replaceWith("<font id='hr_volta_intervalo"+int+colaborador_pk+"' color=blue><b>Atestado</b></font>");
        $("#hr_saida_intervalo"+int+colaborador_pk).replaceWith("<font id='hr_saida_intervalo"+int+colaborador_pk+"' color=blue><b>Atestado</b></font>");
        $("#hr_entrada"+int+colaborador_pk).replaceWith("<font id='hr_entrada"+int+colaborador_pk+"' color=blue><b>Atestado</b></font>");
       // $("#hr_extra"+int+colaborador_pk).replaceWith("<font color=blue><b>Afastamento</b></font>");
        
    }
    
    
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
    setTimeout(function(){
        sendPost('apontamento_folha_ponto_posto_trabalho_res_form.php',{token: token});
    }, 1000);
    
}
function fcGerarFolha(){
     sendPost('folha_ponto_impressao.php',{token: token, leads_pk: leads_pk,dt_periodo_ini:dt_periodo_ini,dt_periodo_fim:dt_periodo_fim});
}

function fcImprimir(){
    $("#grid").hide();
    $("#gridPrint").show();
    window.print();
    
    $("#grid").show();
    $("#gridPrint").hide();
    
}
function fcFinalizar(){
    $("#loader").show();
    $("#exibir").hide();
    fcAbrirModalFolha(ponto_folha_pk,dt_periodo_ini,dt_periodo_fim,leads_pk,colaborador_pk);
    $("#grid").show();
    $("#gridPrint").hide();
    $("#loader").hide();
    $("#exibir").show();
    
    $("#grid").hide();
    $("#gridPrint").show();
    window.print();
    
    $("#grid").show();
    $("#gridPrint").hide();
    
}
$(document).ready(function(){
    fcAbrirModalFolha(ponto_folha_pk,dt_periodo_ini,dt_periodo_fim,leads_pk,colaborador_pk);

    $("#grid").show();
    $("#gridPrint").hide();
    $("#loader").hide();
    $("#exibir").show();
    

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);
    $(document).on('click', '#cmdFinalizar', fcFinalizar);
   
    
    
});