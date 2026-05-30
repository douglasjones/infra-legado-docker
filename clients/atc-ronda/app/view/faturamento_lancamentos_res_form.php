<?
require_once "../inc/php/header.php";
?>
<script src="faturamento_lancamentos_res_form.js?   <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<body>

        <br>
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class='row'>
                        <div class='col-md-9'>
                            <h6 class="font-weight-bold text-primary">Lançamentos Faturamento</h6>
                        </div>
                        <div align='right' class='col-md-3'>
                            <button class="btn btn-secondary btn-sm" id='cmdVoltar'>Voltar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="card-body">
                    <form id="form_colaborador">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblFaturamentoLancamentos">
                            <thead>
                                <tr>
                                    <th><input type='text' id='txtLead' /></th>
                                    <th><input type='text' id='txtContato' /></th>
                                    <th><input type='text' id='txtTipoContato' /></th>
                                    <th><input type='text' id='txtCodLancamento' /></th>
                                    <th><input type='text' id='txtDtLancamento' /></th>
                                    <th><input type='text' id='txtDtFaturamento' /></th>
                                    <th><input type='text' id='txtDtVencimento' /></th>
                                    <th><input type='text' id='txtValor' /></th>
                                    <th><input type='text' id='txtNTF' /></th>                                    
                                </tr>
                                <tr>
                                    <th>Lead</th>
                                    <th>Contrato</th>
                                    <th>Tipo Contrato</th>
                                    <th>Cód Lançamento</th>
                                    <th>Dt. Lançamento</th>
                                    <th>Dt. Faturamento</th>
                                    <th>Dt. Vencimento</th>
                                    <th>Valor</th>
                                    <th>Núm NTF-s</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div align='right'>
                <button class="btn btn-secondary btn-sm" id='cmdVoltar'>Voltar</button>
            </div>
        </div>
    </div>
</body>

<?
    require_once "../inc/php/footer.php";
?>