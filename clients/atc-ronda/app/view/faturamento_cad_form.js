
function fcEnviar(){

    var v_dt_faturamento_ini = $("#dt_faturamento_ini").val();
    var v_dt_faturamento_fim = $("#dt_faturamento_fim").val();
    var v_ic_contrato_fixo = "";
    if($("#ic_contrato_fixo").is(":checked")==true ){
        v_ic_contrato_fixo = 1;
    } 
    
    var v_ic_contrato_aditivo = "";
    if($("#ic_contrato_aditivo").is(":checked")==true ){
        v_ic_contrato_aditivo = 1;
    } 

    var v_ic_contrato_servico_extra = "";
    if($("#ic_contrato_servico_extra").is(":checked")==true ){
        v_ic_contrato_servico_extra = 1;
    } 

    var v_ic_gerar_boleto = "";
    if($("#ic_gerar_boleto").is(":checked")==true ){
        v_ic_gerar_boleto= 1;
    } 

    var v_ic_gerar_nota_fiscal = "";
    if($("#ic_gerar_nota_fiscal").is(":checked")==true ){
        v_ic_gerar_nota_fiscal = 1;
    } 

    var v_ic_gerar_nota_fatura = "";
    if($("#ic_gerar_nota_fatura").is(":checked")==true ){
        v_ic_gerar_nota_fatura = 1;
    } 
    //var v_ic_processar_faturamento = $("#ic_processar_faturamento").val();
    var v_obs = $("#obs").val();
    var v_ic_status = $("#ic_status").val();

    var v_faturamento_pk = ""; 
    if($("#faturamento_pk").val()!=""){
        v_faturamento_pk = $("#faturamento_pk").val();
    }
      
    var objParametros = {
        "pk": v_faturamento_pk,
        "dt_faturamento_ini": v_dt_faturamento_ini,
        "dt_faturamento_fim": v_dt_faturamento_fim,
        "ic_contrato_fixo": v_ic_contrato_fixo,
        "ic_contrato_aditivo": v_ic_contrato_aditivo,
        "ic_contrato_servico_extra": v_ic_contrato_servico_extra,
        "ic_gerar_boleto": v_ic_gerar_boleto,
        "ic_gerar_nota_fiscal": v_ic_gerar_nota_fiscal,
        "ic_gerar_nota_fatura": v_ic_gerar_nota_fatura,
        //"ic_processar_faturamento": encodeURIComponent(v_ic_processar_faturamento),
        "obs": v_obs,
        "ic_status": v_ic_status        
    };    

    var arrEnviar = carregarController("faturamento", "salvar", objParametros);           
    
    if (arrEnviar.result == 'success'){
        
        var v_faturamento_pk = arrEnviar.data[0]['pk'];
        $("#faturamento_pk").val(v_faturamento_pk); 
         //EXCLUIR EMPRESAS FATURAMENTO
        var objParametros = {
            "pk": v_faturamento_pk
        };            
        carregarController("faturamento", "excluirFaturamentoContas", objParametros);

        //CADASTRA EMRPESAS FATURAMENTO

        for (i = 0; i < $("#qtde_contas").val(); i++) { 
            var v_contas_pk = ""
            if($("#conta"+i).is(":checked") == true){
                
                v_contas_pk = $("#conta"+i).val();
                
                var objParametros = {
                    "faturamento_pk":v_faturamento_pk,
                    "contas_pk": v_contas_pk
                };           
           
                carregarController("faturamento", "salvarFaturamentoContas", objParametros);      
              
            }    
        }
        // Reload datable
        alert(arrEnviar.message);
        fcListarDadosFaturamento(v_faturamento_pk)
        //fcCarregarFaturamentoItens(v_faturamento_pk)
        //$("#dados_faturamento_div").show();

    }else{
        alert('Falhou a requisição para salvar o registro');
    }
}
function fcListarDadosFaturamento(v_pk){
    sendPost('faturamento_item_res_form.php', { token: token, faturamento_pk: v_pk, acao: 1});
}

function fcCancelar(){
    sendPost("faturamento_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){
        var objParametros = {
            "pk": pk
        };  
        var arrCarregar = carregarController("faturamento", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#dt_faturamento_ini").val(arrCarregar.data[0]['dt_faturamento_ini']);
            $("#dt_faturamento_fim").val(arrCarregar.data[0]['dt_faturamento_fim']);
            $("#ic_contrato_fixo").val(arrCarregar.data[0]['ic_contrato_fixo']);
            $("#ic_contrato_aditivo").val(arrCarregar.data[0]['ic_contrato_aditivo']);
            $("#ic_contrato_servico_extra").val(arrCarregar.data[0]['ic_contrato_servico_extra']);
            $("#ic_gerar_boleto").val(arrCarregar.data[0]['ic_gerar_boleto']);
            $("#ic_gerar_nota_fiscal").val(arrCarregar.data[0]['ic_gerar_nota_fiscal']);
            $("#ic_processar_faturamento").val(arrCarregar.data[0]['ic_processar_faturamento']);
            $("#obs").val(arrCarregar.data[0]['obs']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}


function fcListarContas(){
    var objParametros = {
        "pk": pk
    };        
    
    var arrCarregar = carregarController("conta", "listarPk", objParametros);

    if (arrCarregar.result == 'success'){
        var vhtml = "";
        var contador = 0;
        for (i = 0; i < arrCarregar.data.length; i++) {
            contador ++;           
            vhtml += "<input type='checkbox' id='conta"+i+"' name='conta"+i+"' value="+arrCarregar.data[i].pk+"> - "+arrCarregar.data[i].ds_razao_social+"<br>";
        }  
        $("#qtde_contas").val(contador)  
        $("#listar_contas").html(vhtml)          
    }   
}

function fcValidarParametrosFaturamento(){
    if($("#dt_faturamento_ini").val()==''){
        alert('Por favor, preencher a data de inicio do faturamento!');     

        return false;
    }
    if($("#dt_faturamento_fim").val()==''){
        alert('Por favor, preencher a data de fim do faturamento!');
        return false;
    }
    contador = 0;
    for (i = 0; i < $("#qtde_contas").val(); i++) {
        if($("#conta"+i).is(":checked") == true){
            contador++
        }
    }    
    if(contador==0){
        alert('Por favor, selecione uma das empreas !');
        return false;      
    }
    if($("#ic_contrato_fixo").is(":checked") == false && $("#ic_contrato_aditivo").is(":checked") == false && $("#ic_contrato_servico_extra").is(":checked") == false){
        alert('Por favor, selecione um dos tipos de contratos!');
        return false;
    }
    fcEnviar();
}

$(document).ready(function(){
     //Formatações
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

    fcListarContas();
   

    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdGerarFaturamento', fcValidarParametrosFaturamento);


    //Atribui a validação do formulário dos campos obrigatórios
    fcValidarForm();

    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();
});

//==============TEMPLATE FUNÇÃO NEXT WIZARD======================>
(function( $ ) {
	var arrSettings = new Array();
	var easyWizardMethods = {
	
		init : function(options) {
			var settings = $.extend( {
		
				'stepClassName' : 'step',
				'showSteps' : true,
				'stepsText' : '{n} {t}',
				'showButtons' : true,
				'buttonsClass' : '',
				'prevButton' : '&laquo; Back',
				'nextButton' : 'Avençar &raquo;',
				'debug' : false,
				'submitButton': true,
				'submitButtonText': 'Submit',
				'submitButtonClass': '',
				before: function(wizardObj, currentStepObj, nextStepObj) {},
				after: function(wizardObj, prevStepObj, currentStepObj) {},
				beforeSubmit: function(wizardObj) {
					wizardObj.find('input, textarea').each(function() {
						if(!this.checkValidity()) {						
							this.focus();
							step = $(this).parents('.'+thisSettings.stepClassName).attr('data-step');
							easyWizardMethods.goToStep.call(wizardObj, step);

							return false;
						}
					});
				}
			}, options);

			arrSettings[this.index()] = settings;

			return this.each(function() {
				thisSettings = settings;

				$this = $(this); // Wizard Obj
				$this.addClass('easyWizardElement');
				$steps = $this.find('.'+thisSettings.stepClassName);
				thisSettings.steps = $steps.length;
				thisSettings.width = $(this).width();
			
				if(thisSettings.steps > 1) {
					// Create UI
					$this.wrapInner('<div class="easyWizardWrapper" />');
					$this.find('.easyWizardWrapper').width(thisSettings.width * thisSettings.steps);
					$this.css({
						'position': 'relative',
						'overflow': 'hidden'
					}).addClass('easyPager');

					$stepsHtml = $('<ul class="easyWizardSteps">');

					$steps.each(function(index) {
						step = index + 1;
						$(this).css({
							'float': 'left',
							'width': thisSettings.width,
							'height': '1px'
						}).attr('data-step', step);

						if(!index) {
							$(this).addClass('active').css('height', '');
						}

						stepText = thisSettings.stepsText.replace('{n}', '<span>'+step+'</span>');
						stepText = stepText.replace('{t}', $(this).attr('data-step-title'));
						$stepsHtml.append('<li'+(!index?' class="current"':'')+' data-step="'+step+'">'+stepText+'</li>');
					});

					if(thisSettings.showSteps) {
						$this.prepend($stepsHtml);
					}

					if(thisSettings.showButtons) {				
						paginationHtml = '<div class="easyWizardButtons">';
							paginationHtml += '<button class="prev '+thisSettings.buttonsClass+'">'+thisSettings.prevButton+'</button>';
							paginationHtml += '<button class="next '+thisSettings.buttonsClass+'">'+thisSettings.nextButton+'</button>';
							paginationHtml += thisSettings.submitButton?'<button type="submit" class="submit '+thisSettings.submitButtonClass+'">'+thisSettings.submitButtonText+'</button>':'';
						paginationHtml	+= '</div>';
						$paginationBloc = $(paginationHtml);
						$paginationBloc.css('clear', 'both');
						$paginationBloc.find('.prev, .submit').hide();
						$paginationBloc.find('.prev').bind('click.easyWizard', function(e) {
							e.preventDefault();
						
							$wizard = $(this).parents('.easyWizardElement');
							easyWizardMethods.prevStep.apply($wizard);
						});

						$paginationBloc.find('.next').bind('click.easyWizard', function(e) {
                            fcValidarParametrosFaturamento();
                        
                            e.preventDefault();							
                            $wizard = $(this).parents('.easyWizardElement'); 
                            easyWizardMethods.nextStep.apply($wizard);                            				
						});
						
						$this.append($paginationBloc);
					}

					$formObj = $this.is('form')?$this:$(this).find('form');

					// beforeSubmit Callback
					$this.find('[type="submit"]').bind('click.easyWizard', function(e) {
                  
						$wizard = $(this).parents('.easyWizardElement');
						thisSettings.beforeSubmit($wizard);
						return true;
					});
				}else if(thisSettings.debug) {
					console.log('Can\'t make a wizard with only one step oO');
				}
			});
		},
		prevStep : function( ) {
			thisSettings = arrSettings[this.index()];
			$activeStep = this.find('.active');
			if($activeStep.prev('.'+thisSettings.stepClassName).length) {
				prevStep = parseInt($activeStep.attr('data-step')) - 1;
				easyWizardMethods.goToStep.call(this, prevStep);
			}
		},
		nextStep : function( ) {
			thisSettings = arrSettings[this.index()];
			$activeStep = this.find('.active');
			if($activeStep.next('.'+thisSettings.stepClassName).length) {
				nextStep = parseInt($activeStep.attr('data-step')) + 1;
				easyWizardMethods.goToStep.call(this, nextStep);
			}
		},
		goToStep : function(step) {
			thisSettings = arrSettings[this.index()];

			$activeStep = this.find('.active');
			$nextStep = this.find('.'+thisSettings.stepClassName+'[data-step="'+step+'"]');
			currentStep = $activeStep.attr('data-step');

			// Before callBack
			thisSettings.before(this, $activeStep, $nextStep);

			// Define direction for sliding
			if(currentStep < step) { // forward
				leftValue = thisSettings.width * -1;
			}else { // backward
				leftValue = thisSettings.width;
			}

			// Slide !
			$activeStep.animate({
				height: '1px'
			}).removeClass('active');

			$nextStep.css('height', '').addClass('active');

			this.find('.easyWizardWrapper').animate({
				'margin-left': thisSettings.width * (step - 1) * -1
			});

			// Defines steps
			this.find('.easyWizardSteps .current').removeClass('current');
			this.find('.easyWizardSteps li[data-step="'+step+'"]').addClass('current');

			// Define buttons
			$paginationBloc = this.find('.easyWizardButtons');
			if($paginationBloc.length) {
				if(step == 1) {
					$paginationBloc.find('.prev, .submit').hide();
					$paginationBloc.find('.next').show();
				}else if(step < thisSettings.steps) {
					$paginationBloc.find('.submit').hide();
					$paginationBloc.find('.prev, .next').show();
				}else {
					$paginationBloc.find('.next').hide();
					$paginationBloc.find('.submit').show();
				}
			}

			// After callBack
			thisSettings.after(this, $activeStep, $nextStep);
		}
	};

	$.fn.easyWizard = function(method) {
		if ( easyWizardMethods[method] ) {
			return easyWizardMethods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return easyWizardMethods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.easyWizard' );
		}
	};
})(jQuery);
