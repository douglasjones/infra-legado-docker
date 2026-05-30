<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/fatura.class.php';


class faturadao{

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
    
    public function salvar($fatura){

        $fields = array();
        $fields['leads_pk'] = $fatura->getleads_pk();
        $fields['dt_inicio_fatura'] = $fatura->getdt_inicio_fatura();
        $fields['dt_fim_fatura'] = $fatura->getdt_fim_fatura();
        $fields['vl_bruto_total'] = $fatura->getvl_bruto_total();
        $fields['vl_falta'] = $fatura->getvl_falta();
        $fields['qtde_falta'] = $fatura->getqtde_falta();
        $fields['empresas_pk'] = $fatura->getempresas_pk();
        $fields['tipo_contrato_pk'] = $fatura->gettipo_contrato_pk();
        if($fatura->getdt_cancelamento()!=""){
             $fields['dt_cancelamento'] = "sysdate()";
        }
       
        $fields['ds_descricao_cancelamento'] = $fatura->getds_descricao_cancelamento();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($fatura->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("fatura", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("fatura", $fields, " pk = ".$fatura->getpk());
        }

    }

    public function excluir($fatura){
        $this->db->execDelete("fatura"," pk = ".$fatura->getpk());
    }
    public function excluirItens($pk){
        $this->db->execDelete("itens_fatura"," fatura_pk = ".$pk);
    }

    public function carregarPorPk($pk){

        $fatura = new fatura();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,leads_pk ";
        $sql.="       ,dt_inicio_fatura ";
        $sql.="       ,dt_fim_fatura";
        $sql.="       ,vl_bruto_total ";
        $sql.="       ,tipo_contrato_pk";


        $sql.="  from fatura ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $fatura->setpk($query[$i]["pk"]);
                $fatura->setdt_cadastro($query[$i]["dt_cadastro"]);
                $fatura->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $fatura->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $fatura->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $fatura->setleads_pk($query[$i]['leads_pk']);
                $fatura->setdt_inicio_fatura($query[$i]['dt_inicio_fatura']);
                $fatura->setdt_fim_fatura($query[$i]['dt_fim_fatura']);
                $fatura->setvl_bruto_total($query[$i]['vl_bruto_total']);
                $fatura->settipo_contrato_pk($query[$i]['tipo_contrato_pk']);

            }
        }
        return $fatura;
    }

    public function listarPkItensFatura($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from itens_fatura ";
        $sql.=" where fatura_pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,leads_pk ";
        $sql.="       ,dt_inicio_fatura ";
        $sql.="       ,dt_fim_fatura";
        $sql.="       ,vl_bruto_total ";

        $sql.="  from fatura ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarValorServicoPrestado($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk){

        $sql ="";
        $sql.=" select ";
        $sql.="            sum(ci.vl_total)vl_total ";
        $sql.="        from contratos_itens  ci ";
        $sql.="            inner join contratos c on ci.contratos_pk = c.pk";
        $sql.="            inner join processos_etapas pe on c.processos_etapas_pk = pe.pk";
        $sql.="            inner join processos p on pe.processos_pk = p.pk";

        $sql.="            where 1=1 ";
        if($empresas_pk != ""){
            if($empresas_pk==1){
                $sql.=" and (c.empresas_pk=".$empresas_pk.")";
            }
            else{
                $sql.=" and c.empresas_pk=".$empresas_pk;
            }
            
        }
        else{
            //$sql.=" and c.empresas_pk is null";
        }
        if($leads_pk!=""){
            $sql.=" and p.leads_pk =".$leads_pk;
        }
        if($dt_inicio_fatura!=""){
            //$sql.=" AND '".DataYMD($dt_inicio_fatura)."' between  c.dt_inicio_contrato and c.dt_fim_contrato";
            $sql.=" AND '".DataYMD($dt_fim_fatura)."' between  c.dt_inicio_contrato and c.dt_fim_contrato";
            
            
        }
        
        
        $sql.=" and c.dt_cancelamento is null";
        $sql.=" and c.ic_tipo_contrato =  1";
   
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarValorServicoExtraAditivo($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk){

        $sql ="";
        $sql.=" select ";
        $sql.="            ci.vl_total,";
        $sql.="            ps.ds_produto_servico";
        $sql.="        from contratos_itens  ci ";
        $sql.="            inner join produtos_servicos ps on ci.produtos_servicos_pk = ps.pk";
        $sql.="            inner join contratos c on ci.contratos_pk = c.pk";
        $sql.="            inner join processos_etapas pe on c.processos_etapas_pk = pe.pk";
        $sql.="            inner join processos p on pe.processos_pk = p.pk";

        $sql.="            where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk =".$leads_pk;
        }
        if($empresas_pk != ""){
            if($empresas_pk==1){
                $sql.=" and (c.empresas_pk=".$empresas_pk.")";
            }
            else{
                $sql.=" and c.empresas_pk=".$empresas_pk;
            }
            
        }
        else{
            //$sql.=" and c.empresas_pk is null";
        }
        if($dt_inicio_fatura!=""){
            $sql.=" AND '".DataYMD($dt_inicio_fatura)."' between  c.dt_inicio_contrato and c.dt_fim_contrato";
            $sql.=" AND '".DataYMD($dt_fim_fatura)."' between  c.dt_inicio_contrato and c.dt_fim_contrato";
            
        }
        if($leads_pk!=""){
            $sql.=" and p.leads_pk =".$leads_pk;
        }
        
        $sql.=" and c.dt_cancelamento is null";
        $sql.=" and c.ic_tipo_contrato =  2";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarValorServicoExtra($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk){

        $sql ="";
        $sql.=" select ";
        $sql.="            ci.vl_total,";
        $sql.="            ps.ds_produto_servico";
        $sql.="        from contratos_itens  ci ";
        $sql.="            inner join produtos_servicos ps on ci.produtos_servicos_pk = ps.pk";
        $sql.="            inner join contratos c on ci.contratos_pk = c.pk";
        $sql.="            inner join processos_etapas pe on c.processos_etapas_pk = pe.pk";
        $sql.="            inner join processos p on pe.processos_pk = p.pk";

        $sql.="            where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk =".$leads_pk;
        }
        if($empresas_pk != ""){
            if($empresas_pk==1){
                $sql.=" and (c.empresas_pk=".$empresas_pk.")";
            }
            else{
                $sql.=" and c.empresas_pk=".$empresas_pk;
            }
            
        }
        else{
            //$sql.=" and c.empresas_pk is null";
        }
        if($dt_inicio_fatura!=""){
            $sql.=" and '".DataYMD($dt_inicio_fatura)."' <= c.dt_inicio_contrato";
            $sql.=" and '".DataYMD($dt_fim_fatura)."' >= c.dt_fim_contrato";

            
        }
        if($leads_pk!=""){
            $sql.=" and p.leads_pk =".$leads_pk;
        }
        
        $sql.=" and c.dt_cancelamento is null";
        $sql.=" and c.ic_tipo_contrato =  3";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarValorDesconto($leads_pk,$dt_inicio_fatura,$dt_fim_fatura){

        $sql ="";
        $sql.=" select ";
        $sql.="            (ld.vl_desconto)vl_total,";
        $sql.="            ld.ds_desconto";
        $sql.="        from leads_desconto  ld";

        $sql.="            where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and ld.leads_pk =".$leads_pk;
        }
        if($dt_inicio_fatura!=""){
            $sql.=" AND ld.dt_base between '".DataYMD($dt_inicio_fatura)."' and '".DataYMD($dt_fim_fatura)."'";
        }
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarValorMateriaisConsumiveis($leads_pk,$dt_inicio_fatura,$dt_fim_fatura){

        $sql ="";
        $sql.=" select sum(pi.qtde)qtde,sum(pi.vl_item)vl_item ";
        $sql.="        from movimentacao_estoque me";
        $sql.="        inner join produtos_itens pi on me.produtos_itens_pk = pi.pk";
        $sql.="        where 1=1";
        if($leads_pk!=""){
            $sql.=" and me.leads_pk =".$leads_pk;
        }
        /*if($dt_inicio_fatura!=""){
            $sql.=" and me.dt_entrega >= '".DataYMD($dt_inicio_fatura)."'";
            $sql.=" and me.dt_entrega <='".DataYMD($dt_fim_fatura)."'";
        }*/
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeFalta($leads_pk,$dt_inicio_fatura,$dt_fim_fatura){

        $sql ="";
        $sql.=" select * from colaboradores_faltas cf ";
        $sql.="        where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and cf.leads_pk =".$leads_pk;
        }
        if($dt_inicio_fatura!=""){
            $sql.="        and cf.dt_escala between '".DataYMD($dt_inicio_fatura)."' and '".DataYMD($dt_fim_fatura)."'";
        }
        $sql.="        and cf.colaborador_reserva_pk is null";
        $sql.="        group by cf.colaborador_pk, cf.dt_escala ";
        
       
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_leads_pk($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,dt_inicio_fatura ";
        $sql.="       ,dt_fim_fatura";
        $sql.="       ,vl_bruto_total ";

        $sql.="  from fatura ";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and ds_fatura like '%".$leads_pk."%' ";
        }
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarGridFaturamento($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk){

        $sql ="";
        $sql.="select f.pk, date_format(f.dt_cadastro,'%d/%m/%Y')dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.leads_pk ";
        $sql.="       ,date_format(f.dt_inicio_fatura,'%d/%m/%Y')dt_inicio_fatura";
        $sql.="       ,date_format(f.dt_fim_fatura,'%d/%m/%Y')dt_fim_fatura";
        $sql.="       ,date_format(f.dt_cancelamento,'%d/%m/%Y')dt_cancelamento";
        $sql.="       ,f.vl_bruto_total ";
        $sql.="       ,f.ds_descricao_cancelamento";
        $sql.="       ,f.tipo_contrato_pk";
        $sql.="       ,case f.tipo_contrato_pk when 1 then 'Contrato/Extra' when 2 then 'Aditivo' when 3 then 'Serviço Extra' end ds_tipo_contrato";
        $sql.="       ,l.ds_lead";
        $sql.="       ,concat(date_format(f.dt_inicio_fatura,'%d/%m/%Y'),' até ',date_format(f.dt_fim_fatura,'%d/%m/%Y'))periodo";

        $sql.="  from fatura f";
        $sql.="       inner join leads l on f.leads_pk = l.pk ";
        $sql.=" where 1=1 ";
        
        if($empresas_pk != ""){
            if($empresas_pk==1){
                $sql.=" and (f.empresas_pk=".$empresas_pk." or f.empresas_pk is null)";
            }
            else{
                $sql.=" and f.empresas_pk=".$empresas_pk;
            }
            
        }
        if($leads_pk != ""){
            $sql.=" and f.leads_pk=".$leads_pk;
        }
        if($dt_inicio_fatura!=""){
            $sql.=" and f.dt_inicio_fatura ='".DataYMD($dt_inicio_fatura)."'";
        }
        if($dt_fim_fatura!=""){
            $sql.=" and f.dt_fim_fatura ='".DataYMD($dt_fim_fatura)."'";
        }
        $sql.=" order by f.pk asc ";
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorLead($pk,$leads_pk,$dt_inicio_fatura,$dt_fim_fatura){

        $sql ="";
        $sql.="select f.pk, date_format(f.dt_cadastro,'%d/%m/%Y')dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.leads_pk ";
        $sql.="       ,date_format(f.dt_inicio_fatura,'%d/%m/%Y')dt_inicio_fatura";
        $sql.="       ,date_format(f.dt_fim_fatura,'%d/%m/%Y')dt_fim_fatura";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,f.vl_bruto_total ";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,fi.tipo_item_fatura";
        $sql.="       ,fi.ds_descricao";
        $sql.="       ,fi.vl_total";
        $sql.="       ,f.vl_falta";
        $sql.="       ,f.qtde_falta";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,concat(l.ds_endereco,', ',l.ds_numero,', ',l.ds_bairro,', ',l.ds_cidade,', ',l.ds_uf)ds_endereco";
        $sql.="       ,concat(date_format(f.dt_inicio_fatura,'%d/%m/%Y'),' até ',date_format(f.dt_fim_fatura,'%d/%m/%Y'))periodo";
        $sql.="  from fatura f";
        $sql.="       inner join leads l on f.leads_pk = l.pk ";
        $sql.="       left join processos p on p.leads_pk = l.pk ";
        $sql.="       left join processos_etapas pe on pe.processos_pk = p.pk ";
        $sql.="       left join contratos c on c.processos_etapas_pk = pe.pk ";
        $sql.="       left join contas co on c.empresas_pk = co.pk ";
        $sql.="       left join itens_fatura fi on fi.fatura_pk = f.pk";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and f.leads_pk=".$leads_pk;
        }
        if($dt_inicio_fatura!=""){
            $sql.=" and f.dt_inicio_fatura ='".DataYMD($dt_inicio_fatura)."'";
        }
        if($dt_fim_fatura!=""){
            $sql.=" and f.dt_fim_fatura ='".DataYMD($dt_fim_fatura)."'";
        }
        if($pk!=""){
            $sql.=" and f.pk =".$pk;
        }
        $sql.=" group by fi.tipo_item_fatura,l.pk,fi.ds_descricao ";
        $sql.=" order by fi.tipo_item_fatura asc ";
       //echo $sql."<br>";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function relatorioLeadFatura($empresas_pk,$leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$tipo_contrato_fixo,$tipo_contrato_aditivo,$tipo_contrato_extra,$dt_ini_contrato,$dt_fim_contrato,$desconto_pk){

        $sql ="";
        $sql.="select f.pk, date_format(f.dt_cadastro,'%d/%m/%Y')dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.leads_pk ";
        $sql.="       ,f.ds_descricao_cancelamento";
        $sql.="       ,date_format(f.dt_inicio_fatura,'%d/%m/%Y')dt_inicio_fatura";
        $sql.="       ,date_format(f.dt_fim_fatura,'%d/%m/%Y')dt_fim_fatura";
        $sql.="       ,date_format(f.dt_cancelamento,'%d/%m/%Y')dt_cancelamento";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,(f.vl_bruto_total)vl_bruto_total";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,fi.tipo_item_fatura";
        $sql.="       ,fi.ds_descricao";
        $sql.="       ,(fi.vl_total)vl_total";
        $sql.="       ,(f.vl_falta)";
        $sql.="       ,f.qtde_falta";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,concat(date_format(f.dt_inicio_fatura,'%d/%m/%Y'),' até ',date_format(f.dt_fim_fatura,'%d/%m/%Y'))periodo,";
        $sql.="       ,concat(date_format(c.dt_ini_contrato,'%d/%m/%Y'),' até ',date_format(f.dt_fim_contrato,'%d/%m/%Y'))periodo_contrato";

        $sql.="  from fatura f";
        $sql.="       inner join leads l on f.leads_pk = l.pk ";
        $sql.="       inner join contas co on f.empresas_pk = co.pk ";
        $sql.="       left join itens_fatura fi on fi.fatura_pk = f.pk";        
        $sql.="       left join processos p on p.leads_pk = l.pk ";
        $sql.="       left join processos_etapas pe on pe.processos_pk = p.pk ";
        $sql.="       left join contratos c on c.processos_etapas_pk = pe.pk ";
        $sql.=" where 1=1 ";
        if($empresas_pk != ""){
            if($empresas_pk==1){
                $sql.=" and (f.empresas_pk=".$empresas_pk." or f.empresas_pk is null)";
            }
            else{
                $sql.=" and f.empresas_pk=".$empresas_pk;
            }
            
        }
        if($leads_pk != ""){
            $sql.=" and f.leads_pk=".$leads_pk;
        }
        if($dt_inicio_fatura!=""){
            $sql.=" and f.dt_inicio_fatura >='".DataYMD($dt_inicio_fatura)."'";
        }
        if($dt_fim_fatura!=""){
            $sql.=" and f.dt_fim_fatura <='".DataYMD($dt_fim_fatura)."'";
        }
               
        if($tipo_contrato_fixo==1){
            $sql.=" and c.ic_tipo_controato=1";
        }
        if($tipo_contrato_aditivo==1){
            $sql.=" and c.ic_tipo_controato=1";
        }
        if($tipo_contrato_extra==1){
            $sql.=" and c.ic_tipo_controato=1";
        }
                
        if($dt_ini_contrao!=""){
            $sql.=" and c.dt_inicio_contrato >='".DataYMD($dt_ini_contrato)."'";
        }
        if($dt_fim_contrato!=""){
            $sql.=" and f.dt_fim_contrato <='".DataYMD($dt_fim_contrato)."'";
        }
        
        
        //$sql.=" and f.dt_cancelamento is null";
        $sql.=" group by f.pk ";
        $sql.=" order by l.ds_lead asc ";
        echo $sql;
        exit;
 
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function relatorioFaturaTipoItem($pk,$empresas_pk,$leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$tipo_item_pk){

        $sql ="";
        $sql.="select f.pk, date_format(f.dt_cadastro,'%d/%m/%Y')dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.leads_pk ";
        $sql.="       ,date_format(f.dt_inicio_fatura,'%d/%m/%Y')dt_inicio_fatura";
        $sql.="       ,date_format(f.dt_fim_fatura,'%d/%m/%Y')dt_fim_fatura";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,(f.vl_bruto_total)vl_bruto_total";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,fi.tipo_item_fatura";
        $sql.="       ,fi.ds_descricao";
        $sql.="       ,(fi.vl_total)vl_total";
        $sql.="       ,(f.vl_falta)";
        $sql.="       ,f.qtde_falta";
        $sql.="       ,c.empresas_pk";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,concat(l.ds_endereco,', ',l.ds_numero,', ',l.ds_bairro,', ',l.ds_cidade,', ',l.ds_uf)ds_endereco";
        $sql.="       ,concat(date_format(f.dt_inicio_fatura,'%d/%m/%Y'),' até ',date_format(f.dt_fim_fatura,'%d/%m/%Y'))periodo";
        $sql.="  from fatura f";
        $sql.="       inner join leads l on f.leads_pk = l.pk ";
        $sql.="       left join processos p on p.leads_pk = l.pk ";
        $sql.="       left join processos_etapas pe on pe.processos_pk = p.pk ";
        $sql.="       left join contratos c on c.processos_etapas_pk = pe.pk ";
        $sql.="       left join contas co on c.empresas_pk = co.pk ";
        $sql.="       left join itens_fatura fi on fi.fatura_pk = f.pk";
        $sql.=" where 1=1 ";
        if($empresas_pk != ""){
            if($empresas_pk==1){
                $sql.=" and (f.empresas_pk=".$empresas_pk." or c.empresas_pk is null)";
            }
            else{
                $sql.=" and f.empresas_pk=".$empresas_pk;
            }
            
        }
        if($pk != ""){
            $sql.=" and f.pk=".$pk;
        }
        if($leads_pk != ""){
            $sql.=" and f.leads_pk=".$leads_pk;
        }
        if($tipo_item_pk != ""){
            $sql.=" and fi.tipo_item_fatura=".$tipo_item_pk;
        }
        if($dt_inicio_fatura!=""){
            $sql.=" and f.dt_inicio_fatura ='".DataYMD($dt_inicio_fatura)."'";
        }
        if($dt_fim_fatura!=""){
            $sql.=" and f.dt_fim_fatura ='".DataYMD($dt_fim_fatura)."'";
        }
        
        //$sql.=" and f.dt_cancelamento is null";
        $sql.=" group by fi.tipo_item_fatura,f.pk ";
        $sql.=" order by fi.tipo_item_fatura asc ";
        
        //echo $sql."<br>";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function relatorioFaturaServiçoAdicional($pk,$empresas_pk,$leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$tipo_item_pk){

        $sql ="";
        $sql.="select f.pk, date_format(f.dt_cadastro,'%d/%m/%Y')dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.leads_pk ";
        $sql.="       ,date_format(f.dt_inicio_fatura,'%d/%m/%Y')dt_inicio_fatura";
        $sql.="       ,date_format(f.dt_fim_fatura,'%d/%m/%Y')dt_fim_fatura";
        $sql.="       ,(f.vl_bruto_total)vl_bruto_total";
        $sql.="       ,fi.tipo_item_fatura";
        $sql.="       ,fi.ds_descricao";
        $sql.="       ,sum(fi.vl_total)vl_total";
       
        $sql.="       ,(f.vl_falta)";
        $sql.="       ,f.qtde_falta";
        $sql.="  from fatura f";
        $sql.="       inner join itens_fatura fi on fi.fatura_pk = f.pk";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and f.leads_pk=".$leads_pk;
        }
        if($pk != ""){
            $sql.=" and f.pk=".$pk;
        }
        if($tipo_item_pk != ""){
            $sql.=" and fi.tipo_item_fatura=".$tipo_item_pk;
        }
        if($dt_inicio_fatura!=""){
            $sql.=" and f.dt_inicio_fatura >='".DataYMD($dt_inicio_fatura)."'";
        }
        if($dt_fim_fatura!=""){
            $sql.=" and f.dt_fim_fatura <='".DataYMD($dt_fim_fatura)."'";
        }
        
        //$sql.=" and f.dt_cancelamento is null";
        $sql.=" order by fi.tipo_item_fatura asc ";

       
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,dt_inicio_fatura ";
        $sql.="       ,dt_fim_fatura";
        $sql.="       ,vl_bruto_total ";

        $sql.="  from fatura ";
        $sql.=" where 1=1 ";
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function pegarConta(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_razao_social";

        $sql.="  from contas ";
        $sql.=" where 1=1 ";
        $sql.=" order by pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
