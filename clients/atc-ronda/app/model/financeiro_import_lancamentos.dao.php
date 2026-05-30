<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/financeiro_import_lancamentos.class.php';


class financeiro_import_lancamentosdao{

    private $db;
    private $arrToken;

    public function __construct(){

        $this->db = new DataBase();
        $this->db->conectar();

    }

    public function __destruct() {
        $this->db->desconectar();
    }


    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }
    public function abrirArquivoOfx($file){
        
        $content = file_get_contents($file['tmp_name']);
        
        $line = strpos($content, "<OFX>");
        $ofx = substr($content, $line - 1);
        $buffer = $ofx;
        
        $count = 0;

        while ($pos = strpos($buffer, '<'))
        {
            $count++; $pos2 = strpos($buffer, '>');
            $element = substr($buffer, $pos + 1, $pos2 - $pos - 1);

            if (substr($element, 0, 1) == '/')
                $sla[] = substr($element, 1);
            else $als[] = $element;
            $buffer = substr($buffer, $pos2 + 1);
        }
        $adif = array_diff($als, $sla);
        


        $adif = array_unique($adif);
        $ofxy = $ofx;
        
        foreach ($adif as $dif)
        {
            $dpos = 0;
            while ($dpos = strpos($ofxy, $dif, $dpos + 1))
            {
                $npos = strpos($ofxy, '<', $dpos + 1);
                $ofxy = substr_replace($ofxy, "</$dif>".chr(10)."<", $npos, 1);
                $dpos = $npos + strlen($element) + 3;
            }
        }
        $ofxy = str_replace('&', '&', $ofxy);

        $buffer = '';
        $source = fopen($file['tmp_name'], 'r') or die("Unable to open file!");
        while(!feof($source)) {
            $line = trim(fgets($source));
            if ($line === '') continue;

            if (substr($line, -1, 1) !== '>') {
                list($tag) = explode('>', $line, 2);
                $line .= '</' . substr($tag, 1) . '>';
            }
            $buffer .= $line ."\n";
        }


        $xmlOut =   explode("<OFX>", $buffer);
        
        $params = isset($xmlOut[1])?"<OFX>".$xmlOut[1]:$buffer;
        
        $retorno =  new SimpleXMLElement(utf8_encode($params));
       
        $codBanco = $retorno->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKACCTFROM->BANKID;
        $agenciaEConta =$retorno->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKACCTFROM->ACCTID;
        $dtPeridoIniExtrato = $retorno->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKTRANLIST->DTSTART;
        if($dtPeridoIniExtrato){
            $yyyyIni = substr($dtPeridoIniExtrato,0,4);
            $mmIni= substr($dtPeridoIniExtrato,4,2);
            $ddIni =  substr($dtPeridoIniExtrato,6,2);

            $dtPeridoIniExtratoFormat = $ddIni.'/'.$mmIni.'/'.$yyyyIni;
        }
        $dtPeriodoFimExtrato = $retorno->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKTRANLIST->DTEND;
        if($dtPeriodoFimExtrato){
            $yyyyFim = substr($dtPeriodoFimExtrato,0,4);
            $mmFim= substr($dtPeriodoFimExtrato,4,2);
            $ddFim =  substr($dtPeriodoFimExtrato,6,2);

            $dtPeriodoFimExtratoFormat = $ddFim.'/'.$mmFim.'/'.$yyyyFim;
        }

        $arrDadosAnalitico = $retorno->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKTRANLIST->STMTTRN;
        $arrDados = [];
        foreach($arrDadosAnalitico as $v ){
            
            $tipoTransacao = $v->TRNTYPE;
            $dtTransacao = $v->DTPOSTED;

            if($dtTransacao){
                $yyyyT = substr($dtTransacao,0,4);
                $mmT= substr($dtTransacao,4,2);
                $ddT =  substr($dtTransacao,6,2);
    
                $dtTransacaoFormat = $ddT.'/'.$mmT.'/'.$yyyyT;
            }
            $valor = $v->TRNAMT;
            $codTransacao = $v->CHECKNUM;
            $NomeEstabelcimentoPessoa = $v->MEMO;

            $arrExtrato[] = [
                "tipoTransacao"=>strval($tipoTransacao),
                "dtTransacao"=>strval($dtTransacaoFormat),
                "valor"=>strval($valor),
                "nomeEstabelecimento"=>strval($NomeEstabelcimentoPessoa),
                "codTransacao"=>strval($codTransacao)
            ];  
        }
        $saldo = $retorno->BANKMSGSRSV1->STMTTRNRS->STMTRS->LEDGERBAL->BALAMT;
        $dataSaldo = $retorno->BANKMSGSRSV1->STMTTRNRS->STMTRS->LEDGERBAL->DTASOF;


        if($dataSaldo){
            $yyyyS = substr($dataSaldo,0,4);
            $mmS= substr($dataSaldo,4,2);
            $ddS =  substr($dataSaldo,6,2);

            $dataSaldoFormat = $ddS.'/'.$mmS.'/'.$yyyyS;
        }

        $arrDados = [
            "dtPeriodoInicio"=> strval($dtPeridoIniExtratoFormat),
            "dtPeriodoFim"=>strval($dtPeriodoFimExtratoFormat),
            "saldoConta"=>strval($saldo),
            "dataEmissaoExtrato"=>strval($dataSaldoFormat),
            "arrExtratoItens"=>$arrExtrato
        ];
        
        return $arrDados;
    }

}

?>
