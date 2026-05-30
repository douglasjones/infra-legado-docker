function GerentesNew(){
	NewWindow("GerentesNew.php", 400, 100)
}
function GerentesEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Gerente.")
		return
	}
	NewWindow("GerentesNew.php?codgerenteconta=" + vlr, 400, 100)
}
function GerentesDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Gerente.")
		return
	}
	NewWindow("GerentesDet.php?codgerenteconta=" + vlr, 500, 600)
}
function GerentesDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Gerente.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('gerentes_cad.php?acao=del&codusuariointerno=' + vlr, 100, 100)
	}
}
function InstaladoresNew(){
	NewWindow("InstaladoresNew.php", 400, 100)
}
function InstaladoresEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Instalador.")
		return
	}
	NewWindow("InstaladoresNew.php?codinstalador=" + vlr, 400, 100)
}
function InstaladoresDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Instalador.")
		return
	}
	NewWindow("InstaladoresDet.php?codinstalador=" + vlr, 500, 600)
}
function InstaladoresDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Instalador.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('instaladores_cad.php?acao=del&codusuariointerno=' + vlr, 100, 100)
	}
}
function AtendentesNew(){
	NewWindow("AtendentesNew.php", 400, 100)
}
function AtendentesEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Atendente.")
		return
	}
	NewWindow("AtendentesNew.php?codatendente=" + vlr, 400, 100)
}
function AtendentesDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Atendente.")
		return
	}
	NewWindow("AtendentesDet.php?codatendente=" + vlr, 500, 600)
}
function AtendentesDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Atendente.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('atendentes_cad.php?acao=del&codusuariointerno=' + vlr, 100, 100)
	}
}
function ProdutosNew(){
	NewWindow("ProdutosNew.php", 800, 600)
}
function ProdutosEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Produto.")
		return
	}
	NewWindow("ProdutosNew.php?codproduto=" + vlr, 800, 600)
}
function ProdutosDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Produto.")
		return
	}
	NewWindow("ProdutosDet.php?codproduto=" + vlr, 800, 600)
}
function ProdutosDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Produto.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('produtos_cad.php?acao=del&codproduto=' + vlr, 100, 100)
	}
}
function ModulosNew(){
	NewWindow("ModulosNew.php", 500, 300)
}
function ModulosEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Modulo.")
		return
	}
	NewWindow("ModulosNew.php?codmodulo=" + vlr, 500, 300)
}
function ModulosDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Modulo.")
		return
	}
	NewWindow("ModulosDet.php?codmodulo=" + vlr, 500, 300)
}
function ModulosDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Modulo.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('modulos_cad.php?acao=del&codmodulo=' + vlr, 100, 100)
	}
}
function ModeloNew(){
	NewWindow("ModeloNew.php", 800, 600)
}
function ModeloEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Modelo.")
		return
	}
	NewWindow("ModeloNew.php?codmodelo=" + vlr, 800, 600)
}
function ModeloDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Modelo.")
		return
	}
	NewWindow("ModeloDet.php?codmodelo=" + vlr, 600, 600)
}
function ModeloDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Modelo.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('modelo_cad.php?acao=del&codmodelo=' + vlr, 100, 100)
	}
}
function MotivoNew(){
	NewWindow("MotivoNew.php", 380, 100)
}
function MotivoEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Motivo.")
		return
	}
	NewWindow("MotivoNew.php?codmotivolead=" + vlr, 380, 100)
}
function MotivoDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Motivo.")
		return
	}
	NewWindow("MotivoDet.php?codmotivolead=" + vlr, 380, 100)
}
function MotivoDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Motivo.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('motivo_cad.php?acao=del&codmotivolead=' + vlr, 100, 100)
	}
}
function TopicoNew(){
	NewWindow("TopicoNew.php", 600, 600)
}
function TopicoEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Tópico.")
		return
	}
	NewWindow("TopicoNew.php?codtopico=" + vlr, 600, 600)
}
function TopicoDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Tópico.")
		return
	}
	NewWindow("TopicoDet.php?codtopico=" + vlr, 600, 600)
}
function TopicoDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Tópico.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('topico_cad.php?acao=del&codtopico=' + vlr, 100, 100)
	}
}
function LeadNew(){
	NewWindow("LeadNew.php", 700, 500)
}
function LeadPesq(){
	NewWindow("LeadPesq.php", 500, 350)
}
function LeadEdit(codlead){
	if(codlead == null){
		alert("Por favor, selecione um Lead.")
		return
	}
	NewWindow("LeadNew.php?codlead=" + codlead, 700, 500)
}
function GerenciamentoLeadPesq(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Lead.")
		return
	}
	top.pagina.location.href = 'LeadGerenciamentoRes.php?codlead=' + vlr
}
function LeadOcorrPesq(){
	NewWindow("LeadOcorrPesq.php?Acao=CONS", 500, 300)
}
function LeadOcorrEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione uma ocorrência.")
		return
	}
	NewWindow("LeadOcorrenciaNew.php?codocorrencialead=" + vlr, 500, 300)
}
function LeadOcorrVDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione uma ocorrência.")
		return
	}
	NewWindow("LeadOcorrDet.php?CodOcorrenciaLead=" + vlr, 500, 300)
}
function AgendasNew(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Lead.")
		return
	}
	NewWindow("LeadsAgendaNew.php?acao=ins&codlead=" + vlr, 590, 560)
}
function PropostaPesq(){
	NewWindow("PropostaPesq.php", 600, 400)
}
function PropostaEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione uma Proposta.")
		return
	}
	var v = vlr.split('.')
	NewWindow("PropostaNew.php?acao=upd&codproposta=" + v[0] + '&versao=' + v[1] + "&codlead=" + v[2], 700, 500)
}
function PropostaImp(vlr){
	if(vlr == null){
		alert("Por favor, selecione uma Proposta.")
		return
	}
	var v = vlr.split('.')
	NewWindow("PropostaImp.php?acao=imp&codproposta=" + v[0] + '&versao=' + v[1] + "&codlead=" + v[2], 800, 600)
}
function UsuariosInternosNew(){
	NewWindow("UsuariosInternosNew.php", 500, 400)
}
function UsuariosInternosEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Usuário.")
		return
	}
	NewWindow("UsuariosInternosNew.php?codusuariointerno=" + vlr, 500, 400)
}
function AlteraSenhaUsuario(){
	NewWindow("AlteraSenhaUsuario.php?codusuariointerno="+getSel(), 400, 150)
}
function UsuariosInternosDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Usuário.")
		return
	}
	NewWindow("UsuariosInternosDet.php?codusuariointerno=" + vlr, 500, 400)
}
function UsuariosInternosDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Usuário.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?")){
		NewWindow('UsuariosInternos_cad.php?acao=del&codusuariointerno=' + vlr, 100, 100)
	}
}
function UsuariosInternosPesq(){
	NewWindow("UsuariosInternosPesq.php?Acao=CONS", 555, 250)
}
function GruposUsuariosInternosNew(){
	NewWindow("GruposUsuariosInternosNew.php", 500, 400)
}
function GruposUsuariosInternosEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Grupo de Usuário.")
		return
	}
	NewWindow("GruposUsuariosInternosNew.php?codgrupousuariointerno=" + vlr, 500, 400)
}
function GruposUsuariosInternosDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Grupo de Usuário.")
		return
	}
	NewWindow("GruposUsuariosInternosDet.php?codgrupousuariointerno=" + vlr, 500, 400)
}
function GruposUsuariosInternosDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Grupo de Usuário.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?"))
		NewWindow('gruposusuariosinternos_cad.php?acao=del&codgrupousuariointerno=' + vlr, 100, 100)
}
function GruposUsuariosInternosPesq(){
	NewWindow("GruposUsuariosInternosPesq.php?Acao=CONS", 300, 100)
}
function PaginasNew(){
	NewWindow("PaginasNew.php", 350, 200)
}
function PaginasEdit(vlr){
	if(vlr == null){
		alert("Por favor, selecione uma Página.")
		return
	}
	NewWindow("PaginasNew.php?codpagina=" + vlr, 350, 200)
}
function PaginasDet(vlr){
	if(vlr == null){
		alert("Por favor, selecione uma Página.")
		return
	}
	NewWindow("PaginasDet.php?codpagina=" + vlr, 350, 200)
}
function PaginasDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione uma Página.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?"))
		NewWindow('Paginas_cad.php?acao=del&codpagina=' + vlr, 100, 100)
}
function PaginasPesq(){
	NewWindow("PaginasPesq.php", 300, 100)
}
function RelPipelineForecast(){
	NewWindow("RelPipelineForecastPesq.php", 450, 150)
}
function RelProposta(){
	NewWindow("RelPropostaPesq.php", 500, 200)
}
function RelOcorrencia(){
	NewWindow("RelOcorrenciaPesq.php", 500, 200)
}
function RelQualidadeMailing(){
	NewWindow("RelQualidadeMailingPesq.php", 400, 140)
}
function RelWinxLoss(){
	NewWindow("RelWinxLossPesq.php", 400, 150)
}
function RelAgendamento(){
	NewWindow("RelAgendamentoPesq.php", 500, 300)
}
function RelProcessoClaro(){
	NewWindow("RelProcessoClaroPesq.php", 500, 200)
}
function RelSemInteresse(){
	NewWindow("RelSemInteressePesq.php", 500, 200)
}
function RelTargetLead0(){
	NewWindow("RelTargetLead0Pesq.php", 500, 150)
}
function RelDatas(){
	NewWindow("RelDatasPesq.php", 400, 150)
}
function getSel(){
	var rd = top.frames['pagina'].document.getElementsByName('rd')
	var retorno = null
	if(rd)
		if(rd.length)
			for(i=0;i<rd.length;i++)
				if(rd[i].checked)
					retorno = rd[i].value
		else
			if(rd.checked)
				retorno = rd.value
	return retorno
}

var lastMenu = null

function oninit(){
	var itens = cssQuery("#menu ul")
	for(var i = 0; i < itens.length; i++){
		initmenu(itens[i])
	}
}

function initmenu(item){
	var lis = cssQuery("li", item)
	for(var i = 0; i < lis.length; i++){
		var a = cssQuery("a", lis[i])
		var ul = cssQuery("ul", lis[i])
		if(a.length > 0 && ul.length > 0){
			a = a[0]
			ul = ul[0]
			ul.style.display = 'none'
			if(typeof(a.subMenu) == 'undefined'){
				a.subMenu = ul
				Event.observe(a, 'click', menuexpand, false)
			}
		}
	}
}

function menuexpand(e){
	var source = Event.element(e)
	if(lastMenu){
		var menu = lastMenu
		while(menu){
			if(typeof(menu.tagName) != 'undefined' && menu.tagName == 'UL'){
				menu.style.display = 'none'
			}
			menu = menu.parentNode
		}
		lastMenu.subMenu.style.display = 'none'
	}
	var menu = source
	while(menu){
		if(typeof(menu.tagName) != 'undefined' && menu.tagName == 'UL'){
			menu.style.display = 'block'
		}
		menu = menu.parentNode
	}
	if(source.subMenu.style.display == 'block'){
		source.subMenu.style.display = 'none'
	}else{
		source.subMenu.style.display = 'block'
	}
	lastMenu = source
	if(/\#$/.test(source.href))
		Event.stop(e)
}

Event.observe(window, 'load', oninit)