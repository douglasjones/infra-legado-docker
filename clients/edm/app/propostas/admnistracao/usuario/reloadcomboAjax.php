<?
header('Content-Type: text/html; charset=ISO-8859-1');
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";
switch($_REQUEST['tipo']){	
	case 1:
		if(!empty($_REQUEST['cod_polo'] )){
		$sql  = " Select 
					e.cod_empresa
					,case  when e.bairro is null then
						e.razao_social
					else
						concat(e.razao_social, '- ',e.bairro)
					end as empresa	
					from empresa e
					where e.cod_polo=".$_REQUEST['cod_polo'];
		combo($sql, "cod_empresa", @$_REQUEST['cod_empresa'], null, " ");
		}else{
				?>
				<select>
					<option></option>
				</select>
				<?
		}												
	break;
}
?>