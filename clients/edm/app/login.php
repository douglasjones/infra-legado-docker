<?session_start();
include "libs/pwcr.php";
include_once "libs/conectar.php";

conectar(0);

if ($_REQUEST['logoff'] <> "") {
	session_destroy();		
?>
	<script type="text/javascript" language="javascript">
		parent.location.href = 'index.php';
	</script>
<?
}
	if(isset($_REQUEST['enviar'])){
		//$bd = $_REQUEST['bd'];
		//$bd = 'demo_claro';
		$bd = $_SESSION['bd'];
		include_once "libs/conectar.php";
		mysql_select_db($bd);

        $bloqueado = 0;
        $sql = "select max(bloqueado) bloqueado from empresa ";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $bloqueado = $row["bloqueado"];
        mysql_free_result($result);
        if($bloqueado == 1){
            $_SESSION['bd'] = null;
            $_SESSION['codusuario'] = null;
            $_SESSION['cod_polo'] = null;
            $_SESSION['cod_empresa'] = null;
            $_SESSION['nomeusuario'] = null;
            $_SESSION['login'] = null;
            ?>
            <script type="text/javascript" language="javascript">
                alert('Acesso desabilitado, por favor, entre em contato com o administrador do sistema de sua revenda')
                parent.location.href = 'index.php'
            </script>
            <?  
            exit(0);
        }

		$sql = "select 
					CodUsuarioInterno
					, Nome
					, Login
					,cod_polo 
					,cod_empresa
					from $bd.usuariosinternos 
					where login = '" . mysql_real_escape_string($_REQUEST['login']) . "' 
					and senha = '" . pwcrypt(mysql_real_escape_string($_REQUEST['senha'])) . "' 
					And Desativado <> 1";
		$result = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($result);
		$num = mysql_num_rows($result);
		if (!$row){
			$_SESSION['bd'] = null;
			$_SESSION['codusuario'] = null;
			$_SESSION['cod_polo'] = null;
			$_SESSION['cod_empresa'] = null;
			$_SESSION['nomeusuario'] = null;
			$_SESSION['login'] = null;
			?>
			<script type="text/javascript" language="javascript">
				alert('usuario/senha inválidos')
				parent.location.href = 'index.php'
			</script>
			<?		
			}else{

				$permitido = 0;
                $horariopermitido = 0;
                $ip = "";
				//Verifica se o horário está dentro da faixa permitida
				$sql ="";
				$sql ="select min(gui.horarioini) horarioini, max(gui.horariofim) horariofim, max(ip) ip ";
				$sql.="  from gruposusuariosinternos gui ";
				$sql.="	inner join gruposusuariosinternos_usuariosinternos guiu on gui.codgrupousuariointerno = guiu.codgrupousuariointerno ";
				$sql.=" where guiu.codusuariointerno = ".$row['CodUsuarioInterno'];
				$sql.="  having sysdate() >= concat(date_format(sysdate(),'%Y-%m-%d'), ' ', min(gui.horarioini)) ";
				$sql.="     and sysdate() <= concat(date_format(sysdate(),'%Y-%m-%d'), ' ', max(gui.horariofim)) ";
		
                                $rs_horario = mysql_query($sql);	
				while($row_horario = mysql_fetch_array($rs_horario)){
					$ip = $row_horario["ip"];
					$horariopermitido = 1;
				}
				mysql_free_result($rs_horario);
				if($horariopermitido == 0){
					?>
					<script type="text/javascript" language="javascript">
						alert('Horário não permitido para acesso ao sistema.')
						parent.location.href = 'index.php'
					</script>
					<?
					exit(0);
				}
				if($permitido == 0){
					if($_SERVER['REMOTE_ADDR'] != ""){
						if(trim($ip) != ""){
						    if(trim($ip) == trim($_SERVER['REMOTE_ADDR'])){
								$permitido = 1;
							}
						}
                        else{
                            $permitido = 1;
                        }
					}
                    else{
                        $permitido = 1;
                    }
				}
				if($permitido == 0){
					?>
					<script type="text/javascript" language="javascript">
						alert('Não é possível acessar o sistema a partir deste IP.')
						parent.location.href = 'index.php'
					</script>
					<?
					exit(0);
				}
				
				$_SESSION['bd'] = $bd;
				$_SESSION['codusuario'] = $row['CodUsuarioInterno'];
				$_SESSION['cod_polo']= $row['cod_polo']; 
                                $_SESSION['polo_pk']= $row['cod_polo']; 
				$_SESSION['cod_empresa']= $row['cod_empresa']; 
				$_SESSION['nomeusuario'] = $row['Nome'];
				$_SESSION['login'] = $row['Login'];
				$_SESSION['tempo'] = date( 'Hi' ) ;
				
				//INCLUI NO LOG O MOENTO DO LOGIN DO USUARIO		
				mysql_query ("insert into log (cod_tipolog,tabela,fk,codusuariointerno,dt_log) values (3,'usuariosinternos','codusuariointerno=".$_SESSION['codusuario']."',".$_SESSION['codusuario'].",SYSDATE())");
                                
				if($_REQUEST['senha'] == 'gepros'){ ?>
				<script type="text/javascript" language="javascript">
					alert('Troque sua senha antes de logar.')
					parent.location.href = "first_login.php?codusuariointerno=<?=$_SESSION['codusuario'];?>"
				</script>
	<?			}else{
                                       
                                        
                                        
					$pagina = 'index.php';
					if(!empty($_REQUEST['redirect']))
						$pagina = $_REQUEST['redirect']; ?>
					<script type="text/javascript" language="javascript">
						parent.location.href = "<?=$pagina;?>"
					</script>
	<?			}
			}

	}?>

