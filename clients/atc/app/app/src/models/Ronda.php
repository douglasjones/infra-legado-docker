<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;

class Ronda {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPontoQrCode($qrCodePk){
        $sql = "";
        $sql .= " select";
        $sql .= "     lrq.pk qr_code_pk,";
        $sql .= "     lrq.leads_pk,";
        $sql .= "     lrq.ds_ponto,";
        $sql .= "     l.ds_lead,";
        $sql .= "     ll.ds_lead ds_cliente";
        $sql .= " from lead_ronda_qrcode lrq";
        $sql .= " inner join leads l on lrq.leads_pk = l.pk";
        $sql .= " left join leads ll on l.leads_pai_pk = ll.pk";
        $sql .= " where lrq.pk = :qr_code_pk";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':qr_code_pk', (int)$qrCodePk, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function buscarPontoLegado($posto, $local){
        $sql = "";
        $sql .= " select";
        $sql .= "     lrq.pk qr_code_pk,";
        $sql .= "     lrq.leads_pk,";
        $sql .= "     lrq.ds_ponto,";
        $sql .= "     l.ds_lead,";
        $sql .= "     ll.ds_lead ds_cliente";
        $sql .= " from lead_ronda_qrcode lrq";
        $sql .= " inner join leads l on lrq.leads_pk = l.pk";
        $sql .= " left join leads ll on l.leads_pai_pk = ll.pk";
        $sql .= " where l.ds_lead = :posto";
        $sql .= "   and lrq.ds_ponto = :local";
        $sql .= " order by lrq.pk desc";
        $sql .= " limit 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':posto', $posto);
        $stmt->bindValue(':local', $local);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function registrar($qrCodePk, $dsRonda = ''){
        $retorno = new \StdClass;
        $retorno->status = false;
        $retorno->data = [];

        $ponto = $this->buscarPontoQrCode($qrCodePk);

        if (!$ponto) {
            $retorno->message = 'Ponto de ronda não encontrado.';
            return $retorno;
        }

        $sql = "";
        $sql .= " insert into ronda";
        $sql .= "     (pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk, leads_pk, local_ronda_pk, ds_ronda)";
        $sql .= " values";
        $sql .= "     (0, sysdate(), 1, sysdate(), 1, :leads_pk, :local_ronda_pk, :ds_ronda)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':leads_pk', $ponto['ds_lead']);
        $stmt->bindValue(':local_ronda_pk', $ponto['ds_ponto']);
        $stmt->bindValue(':ds_ronda', $dsRonda);
        $stmt->execute();

        $retorno->status = true;
        $retorno->message = 'Registro salvo com sucesso!';
        $retorno->data = [
            'qr_code_pk' => (int)$ponto['qr_code_pk'],
            'ds_lead' => $ponto['ds_lead'],
            'ds_ponto' => $ponto['ds_ponto']
        ];

        return $retorno;
    }

    public function relRondas($leads_pk,$leads_clientes_pk,$dt_ini_ronda,$dt_fim_ronda){
        $retorno = new \StdClass;
        $retorno->status = false;
        $retorno->data = [];
        $retorno->message = 'Nenhum dado encontrado.';
        $retorno->iTotalDisplayRecords = 0;
        $retorno->iTotalRecords = 0;

        $leads_pk = trim((string) $leads_pk);
        $leads_clientes_pk = trim((string) $leads_clientes_pk);
        $dt_ini_ronda = trim((string) $dt_ini_ronda);
        $dt_fim_ronda = trim((string) $dt_fim_ronda);

        if ($dt_ini_ronda === '' || $dt_fim_ronda === '') {
            $retorno->message = 'Informe a data inicial e final da ronda.';
            return $retorno;
        }

        $sql = " select";
        $sql .= "    COALESCE(ll.ds_lead, l.ds_lead, '') ds_cliente,";
        $sql .= "    COALESCE(r.leads_pk, '') ds_lead,";
        $sql .= "    COALESCE(r.local_ronda_pk, '') ds_local_ronda,";
        $sql .= "    date_format(r.dt_cadastro, '%d/%m/%Y') dt_ronda,";
        $sql .= "    date_format(r.dt_cadastro, '%H:%i:%s') hr_ronda,";
        $sql .= "    COALESCE(r.ds_ronda, '') ds_obs";
        $sql .= " from ronda r";
        $sql .= " left join leads l on r.leads_pk = l.ds_lead";
        $sql .= " left join leads ll on l.leads_pai_pk = ll.pk";
        $sql .= " where r.dt_cadastro between :dt_ini_ronda and :dt_fim_ronda";

        if (ctype_digit($leads_clientes_pk)) {
            $sql .= " and ll.pk = :leads_clientes_pk";
        }

        if (ctype_digit($leads_pk)) {
            $sql .= " and l.pk = :leads_pk";
        }

        $sql .= " order by r.dt_cadastro desc";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':dt_ini_ronda', Util::DataYMD($dt_ini_ronda) . ' 00:00:00');
        $stmt->bindValue(':dt_fim_ronda', Util::DataYMD($dt_fim_ronda) . ' 23:59:59');

        if (ctype_digit($leads_clientes_pk)) {
            $stmt->bindValue(':leads_clientes_pk', (int) $leads_clientes_pk, \PDO::PARAM_INT);
        }

        if (ctype_digit($leads_pk)) {
            $stmt->bindValue(':leads_pk', (int) $leads_pk, \PDO::PARAM_INT);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso !';
        $retorno->iTotalDisplayRecords = count($rows);
        $retorno->iTotalRecords = count($rows);

        return $retorno;
    }

}
