<?php

namespace App\Models\Content\Approval;

class MasterApprovalLSModel extends \App\Models\BaseModel
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

        $mainSql="SELECT A.ID, A.IDCONTENT, A.REMARKS, A.MAXLEVEL, A.INACTIVEDATE, B.IDMODULE, B.TABLECONTENT
        , C.ID_MODULE, C.NAMA_MODULE, C.JUDUL_MODULE, C.DESKRIPSI
        FROM MS_APPROVAL_LS_HEADER A, MS_CONTENT_TABLE B, MODULE C
        WHERE A.IDCONTENT = B.ID
        AND B.IDMODULE = C.ID_MODULE";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
        $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT ID, IDCONTENT, REMARKS, MAXLEVEL, INACTIVEDATE, IDMODULE, TABLECONTENT, ID_MODULE, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $dataRow = $this->db->query($sql)->getResultArray();

        // $result['rows'] = $dataRow;

        $dataFull = array();

		// $result['rows'] = $data;
        foreach ($dataRow as $data) {
			$dataDetail['dataDetail'] = $this->getMsApprovalLsDetail($data['ID']);
			$data = array_merge($data, $dataDetail);

			array_push($dataFull, $data);
		}

		$result['rows'] = $dataFull;
    
        return $result;
    }

    public function getMsApprovalLsDetail($ID = '')
	{
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'LVL';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		if ($ID == '') {
			$id = isset($_GET['id']) ? strval($_GET['id']) : '';
		} else {
			$id = $ID;
		}

		$mainSql = "SELECT * FROM (
        SELECT A.ID, A.IDHEADER, A.LVL, A.IDROLE, B.NAMA_ROLE, B.JUDUL_ROLE, B.KETERANGAN FROM MS_APPROVAL_LS_DETAIL A , ROLE B WHERE A.IDROLE = B.ID_ROLE AND A.IDHEADER = $id
        ) ORDER BY $sort $order
         ";

		$result = array();

		$result = $this->db->query($mainSql)->getResultArray();

		return $result;
	}

    
	public function getCbContent()
	{
		
		$sql = "SELECT A.ID, A.IDMODULE, A.TABLECONTENT, A.INACTIVEDATE, 
        TO_CHAR(A.INACTIVEDATE,'FXFMDD-Mon-YYYY') INACTIVEDATE2,A.INPUTBY, B.ID_MODULE, B.NAMA_MODULE, B.JUDUL_MODULE, B.DESKRIPSI
        FROM MS_CONTENT_TABLE A, MODULE B
        WHERE A.IDMODULE = B.ID_MODULE
        AND A.ID NOT IN (SELECT IDCONTENT FROM MS_APPROVAL_LS_HEADER) ORDER BY ID";

		$result = $this->db->query($sql)->getResultArray();

		return $result;
	
	}

    public function getCbRole()
	{
		
		$sql = "SELECT ID_ROLE, NAMA_ROLE, JUDUL_ROLE, KETERANGAN FROM ROLE ORDER BY ID_ROLE";

		$result = $this->db->query($sql)->getResultArray();

		return $result;
	
	}

    
    // batas pakai

    // Fungsi Save  -------------------------------------------------------------
	public function saveData($user_data)
	{
		$IDCONTENT = isset($_POST['IDCONTENT']) ? strval($_POST['IDCONTENT']) : '';
		$REMARKS = isset($_POST['REMARKS']) ? strval($_POST['REMARKS']) : '';
		// $DATECREATED = '';
		// if(!empty($_POST['DATECREATED'])){
		// 	$DATECREATED = date("d/M/Y", strtotime($_POST['DATECREATED']));
		// }

        if (isset($_POST['ROLE_DETAILS'])) {
			$jumDataDetail = count($_POST['ROLE_DETAILS']);
			if ($jumDataDetail < 1) {
				$result['msg']['status'] = 'error';
				$result['msg']['content'] = 'Data Gagal Disimpan, Detail Tidak Terbaca';
				return $result;
			}
		}

        $cekpk = $this->cekPKApprovalLSHeader($IDCONTENT);

        $statHeaderMasuk = 0;

        if (isset($cekpk)) {
			$result['msg']['status'] = 'error';
			$result['msg']['content'] = 'Data Gagal Disimpan, Data Tidak Unik.';
		} else {
            try {

                $sqlNo = "SELECT NVL(MAX(ID),0)+1 IDNO FROM MS_APPROVAL_LS_HEADER";
                $dataIDNO = $this->db->query($sqlNo)->getRowArray()['IDNO'];
    
                $sess_iduser = $user_data['ID_USER'];
    
                $sqlInput = "INSERT INTO MS_APPROVAL_LS_HEADER (ID, IDCONTENT, REMARKS, MAXLEVEL, INPUTBY) VALUES 
                ($dataIDNO, $IDCONTENT ,  '$REMARKS', $jumDataDetail, $sess_iduser)";
                $input = $this->db->query($sqlInput);
    
                if ($input) {
                    $this->db->query('COMMIT');
                    $result['msg']['status'] = 'ok';
                    $result['msg']['content'] = 'Data Berhasil Disimpan';
                    $result['msg']['UNIQUEID'] = $dataIDNO .' - ' .$IDCONTENT;
                    $statHeaderMasuk++;
                }
            } catch (\Exception $e) {
                $result['msg']['status'] = 'error';
                $result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput;
                return $result;

            }
        }

        $statDetailGagalMasuk=0;
        $statDetailMasuk=0;

        if($statHeaderMasuk == 1){
            for ($i = 0; $i < $jumDataDetail; $i++) {
				$LEVEL_DETAILS = isset($_POST['LEVEL_DETAILS'][$i]) ? intval($_POST['LEVEL_DETAILS'][$i]) : 0;
				$ROLE_DETAILS = isset($_POST['ROLE_DETAILS'][$i]) ? intval($_POST['ROLE_DETAILS'][$i]) : 0;

                $sess_iduser = $user_data['ID_USER'];

				$cekpkDetail = $this->cekPKApprovalLSDetail($dataIDNO, $LEVEL_DETAILS, $ROLE_DETAILS);


				if(!isset($cekpkDetail)){
					try {
                        $sqlNoDetail = "SELECT NVL(MAX(ID),0)+1 IDNO FROM MS_APPROVAL_LS_DETAIL";
                        $dataIDNODetail = $this->db->query($sqlNoDetail)->getRowArray()['IDNO'];

						$sqlInput = "INSERT INTO MS_APPROVAL_LS_DETAIL (ID, IDHEADER, LVL, IDROLE, INPUTBY) VALUES 
						($dataIDNODetail, $dataIDNO, $LEVEL_DETAILS, $ROLE_DETAILS, '$sess_iduser')";
						$input = $this->db->query($sqlInput);
	
						if ($input) {
							$this->db->query('COMMIT');
							$statDetailMasuk++;
						}
					} catch (\Exception $e) {

						$statDetailGagalMasuk++;
					}
				}
			}
        }

        if($statHeaderMasuk == 1 AND $statDetailMasuk == $jumDataDetail){
            $result['msg']['status'] = 'ok';
            $result['msg']['content'] = 'Data Berhasil Disimpan';
            $result['msg']['UNIQUEID'] = $dataIDNO .' - ' .$IDCONTENT;
        } else {
            $result['msg']['status'] = 'error';
            $result['msg']['content'] = 'Data Sebagian Gagal Disimpan, Detail Gagal : '.$statDetailGagalMasuk;
            $result['msg']['UNIQUEID'] = $dataIDNO .' - ' .$IDCONTENT;
        }    

		return $result;
	}

    public function cekPKApprovalLSHeader($IDCONTENT='')
	{
		$sql = "SELECT * FROM MS_APPROVAL_LS_HEADER WHERE IDCONTENT='$IDCONTENT'";

		$result = $this->db->query($sql)->getRowArray();

		return $result;
	}

    public function cekPKApprovalLSDetail($dataIDNO=0, $LEVEL_DETAILS=0, $ROLE_DETAILS=0)
	{
		$sql = "SELECT * FROM MS_APPROVAL_LS_DETAIL WHERE IDHEADER = $dataIDNO AND (LVL = $LEVEL_DETAILS OR IDROLE = $ROLE_DETAILS)";

		$result = $this->db->query($sql)->getRowArray();

		return $result;
	}

    // Fungsi Delete  -------------------------------------------------------------
		public function deleteData()
		{
	
			$id = isset($_POST['id']) ? strval($_POST['id']) : '';

            $cekUse = $this->cekUseHeaderOnList($id);

            if(!isset($cekUse)){
                try {    
                    $sqlDelete = "DELETE FROM MS_APPROVAL_LS_DETAIL WHERE IDHEADER = $id ";
                    $delete = $this->db->query($sqlDelete);

                    if ($delete) {
                        $this->db->query('COMMIT');

                        try {    
                            $sqlDelete = "DELETE FROM MS_APPROVAL_LS_HEADER WHERE ID = $id ";
                            $delete = $this->db->query($sqlDelete);
                
                            if ($delete) {
                                $this->db->query('COMMIT');
        
                                
                                $result['msg']['status'] = 'ok';
                                $result['msg']['content'] = 'Proses Delete Berhasil';
                            }
                        } catch (\Exception $e) {
                            $result['msg']['status'] = 'error';
                            $result['msg']['content'] = 'Proses Delete Header Gagal';
                            // die($e->getMessage());
                        } 
                    }
                } catch (\Exception $e) {
                    $result['msg']['status'] = 'error';
                    $result['msg']['content'] = 'Proses Delete Detail Gagal';
                    // die($e->getMessage());
                } 
            } else {
                $result['msg']['status'] = 'error';
                $result['msg']['content'] = 'Gagal Dihapus Karena Approval Sudah Digunakan';
            }
			
			return $result;
		}

        public function cekUseHeaderOnList($id=0)
        {
            $sql = "SELECT A.ID, A.ID_APPROVAL_DETAIL, A.LS_POSTDT, A.STATUS, A.REMARKS,
            B.IDHEADER, B.LVL, B.IDROLE
            FROM LIST_LS_STATUS_APPROVAL A , MS_APPROVAL_LS_DETAIL B
            WHERE A.ID_APPROVAL_DETAIL = B.ID
            AND IDHEADER =$id";

            $result = $this->db->query($sql)->getRowArray();

            return $result;
        }

    


}
