<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';


class veiculos_condutoresdao{

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

    public function listarCondutores(){

        $sql = "";
        $sql .= " select pk condutor_pk, ds_condutor";
        $sql .= "   from condutores";
        $sql .= "   where 1=1";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTodos(){

        $sql = "";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
