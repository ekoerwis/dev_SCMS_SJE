<?php

namespace App\Models\Builtin;

class UserImportEPMSModel extends \App\Models\BaseModel
{
    protected $db2;
    protected $dbApps;

	public function __construct() {
		parent::__construct();
		$this->db2 = db_connect("dbtrxi");
        $this->dbApps = db_connect('dbapps');	
	}

    public function dataList() {
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

            $KEYWORD = isset($_POST['KEYWORD']) ? strval($_POST['KEYWORD']) : '';
            $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'LOGINID';
            $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

            $limit = $page*$rows;
            $offset = ($page-1)*$rows;
            $result = array();

            $sqlCari = "SELECT LISTAGG(USERNAME,''',''') WITHIN GROUP(ORDER BY USERNAME) AS USERNAME FROM USERS";
            $resultCari =  $this->db->query($sqlCari)->getRowArray();
            $keyCari = "'".$resultCari['USERNAME']."'";

        $sql = "SELECT count(*) AS JUMLAH 
                FROM (
                    SELECT LOGINID, FULLNAME FROM USERPROFILE WHERE ( LOWER(LOGINID) LIKE LOWER('%$KEYWORD%') OR LOWER(FULLNAME) LIKE LOWER('%$KEYWORD%') ) AND LOGINID NOT IN ($keyCari)
                    )";
            
            $sql = $this->dbApps->query($sql)->getRowArray();
            $result["total"] = $sql['JUMLAH'];

            $sql = "SELECT * FROM (
                    SELECT LOGINID, FULLNAME, ROWNUM AS RNUM 
                FROM (
                    SELECT LOGINID, FULLNAME FROM USERPROFILE WHERE ( LOWER(LOGINID) LIKE LOWER('%$KEYWORD%') OR LOWER(FULLNAME) LIKE LOWER('%$KEYWORD%') )  AND LOGINID NOT IN ($keyCari)
            ORDER BY $sort $order
                ) WHERE ROWNUM <= $limit 
            ) WHERE RNUM > $offset";

            $sql = $this->dbApps->query($sql)->getResultArray();
            $result['rows'] = $sql;
        
            return $result;
    }

    public function importProses($data) {
        
        $passDefault = '123456';

        $data_db['EMAIL'] = 'importEPMS@mail.com';
        $data_db['USERNAME'] = $data['LOGINID'];
        $data_db['NAMA'] = $data['FULLNAME'];
        $data_db['PASSWORD'] = password_hash($passDefault, PASSWORD_DEFAULT);
        $data_db['AKTIF'] = 1;

        // TAMBAHAN 14 APRIL 2023
        $sqlLastIdUser = "SELECT MAX(ID_USER)+1 LAST_ID_USER FROM USERS";
        $resultLastIdUser = $this->db->query($sqlLastIdUser)->getRowArray();

        $data_db['ID_USER'] =$resultLastIdUser['LAST_ID_USER'];
        $data_db['CREATED'] =date("d/M/Y H:i:s");

        $EMAIL = $data_db['EMAIL'];
        $USERNAME =  $data_db['USERNAME'];
        $NAMA = $data_db['NAMA'];
        $PASSWORD = $data_db['PASSWORD'];
        $AKTIF = $data_db['AKTIF'];
        $ID_USER = $data_db['ID_USER'];
        $CREATED = $data_db['CREATED'];

        // BATAS TAMBAHAN 14 APRIL 2023

        try {    

            // $tablename = 'USERS';
            // $input = $this->db->table($tablename)->insert($data_db);

            // script input diganti 14 april 2023
            $sqlInput = "INSERT INTO USERS (ID_USER, USERNAME, PASSWORD, NAMA, EMAIL, AKTIF, CREATED) VALUES ($ID_USER, '$USERNAME', '$PASSWORD', '$NAMA', '$EMAIL', $AKTIF, TO_DATE('$CREATED','DD/MON/YYYY HH24:MI:SS'))";
            $input = $this->db->query($sqlInput);

            if ($input) {
                $this->db->query('COMMIT');
                $result = 'ok';
            }
        } catch (\Exception $e) {
            $result = 'error';
            // die($e->getMessage());
        } 

        return $result;
    
    }

}
