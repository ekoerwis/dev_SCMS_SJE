<?php

namespace App\Models\Content\Approval;

class MasterContentTableModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'ID';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        $MONTHNUMBER = isset($_POST['MONTHNUMBER']) ? intval($_POST['MONTHNUMBER']) : 0;
        $YEARNUMBER = isset($_POST['YEARNUMBER']) ? intval($_POST['YEARNUMBER']) : 0;

        $mainSql="SELECT A.ID, A.IDMODULE, A.TABLECONTENT, A.INACTIVEDATE, TO_CHAR(A.INACTIVEDATE,'FXFMDD-Mon-YYYY') INACTIVEDATE2, A.INPUTBY, B.ID_MODULE, B.NAMA_MODULE, B.JUDUL_MODULE, B.DESKRIPSI
        FROM MS_CONTENT_TABLE A, MODULE B
        WHERE A.IDMODULE = B.ID_MODULE";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
    $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT ID, IDMODULE, TABLECONTENT, INACTIVEDATE, INACTIVEDATE2, INPUTBY, ID_MODULE, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $dataRow = $this->db->query($sql)->getResultArray();

        $result['rows'] = $dataRow;
    
        return $result;
    }

    
	public function getCbModule()
	{
		
		$sql = "SELECT ID_MODULE, NAMA_MODULE, JUDUL_MODULE FROM MODULE WHERE ID_MODULE NOT IN (SELECT DISTINCT IDMODULE FROM MS_CONTENT_TABLE) ORDER BY ID_MODULE";

		$result = $this->db->query($sql)->getResultArray();

		return $result;
	
	}

	public function getCbTableContent()
	{
		
		$sql = "SELECT A.TNAME, A.TABTYPE, A.CLUSTERID FROM TAB A WHERE A.TNAME LIKE 'POM%' AND A.TNAME NOT IN (SELECT DISTINCT TABLECONTENT FROM MS_CONTENT_TABLE) ORDER BY A.TNAME";

		$result = $this->db->query($sql)->getResultArray();

		return $result;
	
	}

    // Fungsi Save  -------------------------------------------------------------
	public function saveData($user_data)
	{
		$ID_MODULE = isset($_POST['ID_MODULE']) ? strval($_POST['ID_MODULE']) : '';
		$TABLECONTENT = isset($_POST['TABLECONTENT']) ? strval($_POST['TABLECONTENT']) : '';
		// $DATECREATED = '';
		// if(!empty($_POST['DATECREATED'])){
		// 	$DATECREATED = date("d/M/Y", strtotime($_POST['DATECREATED']));
		// }


		try {

            $sqlNo = "SELECT NVL(MAX(ID),0)+1 IDNO FROM MS_CONTENT_TABLE";
            $dataIDNO = $this->db->query($sqlNo)->getRowArray()['IDNO'];

            $sess_iduser = $user_data['ID_USER'];

            $sqlInput = "INSERT INTO MS_CONTENT_TABLE (ID, IDMODULE, TABLECONTENT, INPUTBY) VALUES 
            ($dataIDNO, $ID_MODULE ,  '$TABLECONTENT', $sess_iduser)";
            $input = $this->db->query($sqlInput);

            if ($input) {
                $this->db->query('COMMIT');
                $result['msg']['status'] = 'ok';
                $result['msg']['content'] = 'Data Berhasil Disimpan';
                $result['msg']['UNIQUEID'] = $ID_MODULE .' - ' .$TABLECONTENT;
                // $statHeaderMasuk++;
            }
        } catch (\Exception $e) {
            $result['msg']['status'] = 'error';
            $result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput;
        }
        

		return $result;
	}

    // Fungsi Delete  -------------------------------------------------------------
		public function deleteData()
		{
	
			$id = isset($_POST['id']) ? strval($_POST['id']) : '';
			
            try {    
                $sqlDelete = "DELETE FROM MS_CONTENT_TABLE WHERE  ID = $id ";
                $delete = $this->db->query($sqlDelete);
    
                if ($delete) {
                    $this->db->query('COMMIT');

                    $this->db->query('COMMIT');
                    $result['msg']['status'] = 'ok';
                    $result['msg']['content'] = 'Proses Delete Berhasil';
                }
            } catch (\Exception $e) {
                $result['msg']['status'] = 'error';
                $result['msg']['content'] = 'Proses Delete Detail Gagal';
                // die($e->getMessage());
            } 
			
			return $result;
		}

    
    // batas pakai


}
