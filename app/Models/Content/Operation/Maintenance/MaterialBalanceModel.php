<?php

namespace App\Models\Content\Operation\Maintenance;

class MaterialBalanceModel extends \App\Models\BaseModel
{

  protected $db2;

  public function __construct()
  {
    parent::__construct();
    $this->db2 = db_connect("dbapps");
  }


  
  public function getMaterialBalance()
  {
        $mainSql = "SELECT A.COMP_ID, A.SITE_ID, A.MILLCODE, A.MILLNAME, 
        A.PARAMETERCODE, A.PARAMETERNAME, A.PARENTCODE, B.PARAMETERNAME PARENTNAME,
        A.VALUE, A.INACTIVEDATE, A.INPUTDATE, A.INPUTBY, A.UPDATEDATE, A.UPDATEBY 
        FROM OP_MATERIAL_BALANCE A 
        LEFT JOIN OP_MATERIAL_BALANCE B
        ON A.COMP_ID = B.COMP_ID AND A.MILLCODE = B.MILLCODE AND A.PARENTCODE = B.PARAMETERCODE
        WHERE A.INACTIVEDATE IS NULL  
        ORDER BY A.PARAMETERCODE";

        $data = $this->db->query($mainSql)->getResultArray();

        $result = $this->buildTree($data);

        return $result;


  }

   public function buildTree($data, $parentCode = null) {
        $tree = [];
        foreach ($data as $element) {
            if ($element['PARENTCODE'] === $parentCode) {
                $children = $this->buildTree($data, $element['PARAMETERCODE']);
                if ($children) {
                    $element['children'] = $children;
                }
                $tree[] = $element;
            }
        }
        return $tree;
    }


    public function getParentNode()
    {
        $q = isset($_POST['q']) ? strval($_POST['q']) : '';
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
           
            
        $mainSql = "SELECT A.COMP_ID, A.SITE_ID, A.MILLCODE, A.MILLNAME, 
        A.PARAMETERCODE, A.PARAMETERNAME, A.PARENTCODE,  A.PARAMETERCODE||' - '||A.PARAMETERNAME DESCRIPTION,
        A.VALUE, A.INACTIVEDATE, A.INPUTDATE, A.INPUTBY, A.UPDATEDATE, A.UPDATEBY 
        FROM OP_MATERIAL_BALANCE A 
        WHERE INACTIVEDATE IS NULL and  (LOWER (PARAMETERCODE) LIKE LOWER('%$q%') OR LOWER (PARAMETERNAME) LIKE LOWER('%$q%'))
        ";

        $sql = "SELECT count(*)JUMLAH FROM ($mainSql) ";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];

        $sql = "SELECT * FROM (
                            SELECT COMP_ID, SITE_ID, MILLCODE, MILLNAME, PARAMETERCODE, PARAMETERNAME, PARENTCODE, DESCRIPTION, VALUE,  INACTIVEDATE,  INPUTDATE,  INPUTBY,  UPDATEDATE,  UPDATEBY ,ROWNUM AS RNUM FROM (
                                $mainSql ORDER BY PARAMETERCODE
                            )	WHERE ROWNUM <= $limit
                            ) WHERE RNUM > $offset";

        $sql = $this->db->query($sql)->getResultArray();
        $result['rows'] = $sql;
        return $result;
  
  
    }

    public function getRowData($id='')
    {
          $mainSql = "SELECT A.COMP_ID, A.SITE_ID, A.MILLCODE, A.MILLNAME, 
          A.PARAMETERCODE, A.PARAMETERNAME, A.PARENTCODE,  A.PARAMETERCODE||' - '||A.PARAMETERNAME DESCRIPTION,
          A.VALUE, A.INACTIVEDATE, A.INPUTDATE, A.INPUTBY, A.UPDATEDATE, A.UPDATEBY 
          FROM OP_MATERIAL_BALANCE A 
          WHERE  A.PARAMETERCODE = '$id'
          ORDER BY PARAMETERCODE";
  
          $result = $this->db->query($mainSql)->getRowArray();
  
          return $result;
  
    }

  public function saveData()
  {
    $this->db->transBegin();
    try {

        $data_db['PARAMETERCODE'] = isset($_POST['PARAMETERCODE'])? strval($_POST['PARAMETERCODE']):'';
        $data_db['PARAMETERNAME'] = isset($_POST['PARAMETERNAME'])? strval($_POST['PARAMETERNAME']):'';
        $data_db['VALUE'] = isset($_POST['MASTER_VALUE'])? floatval($_POST['MASTER_VALUE']):0;
        $data_db['PARENTCODE'] = isset($_POST['PARENTCODE'])? strval($_POST['PARENTCODE']):'';

        $data_db['COMP_ID'] = '03';
        $data_db['SITE_ID'] = '02';
        $data_db['MILLCODE'] = '0302';
        $data_db['MILLNAME'] = 'SJE PKS';

        $tablename = 'OP_MATERIAL_BALANCE';

        $cekData = $this->getRowData($data_db['PARAMETERCODE']);

        if(empty($cekData)){

            $input = $this->db->table($tablename)->insert($data_db);
                if ($input) {
                $this->db->query("commit;");
                $result['msg']['status'] = 'ok';
                $result['msg']['content'] = 'Data berhasil disimpan';
                }
        
        } else {
            $result['msg']['status'] = 'error';
            $result['msg']['content'] = 'Kode Sudah Digunakan';
        }
    } catch (\Exception $e) {
        $result['msg']['status'] = 'error';
        $result['msg']['content'] = 'Data gagal disimpan';
    }

    return $result;
  }

  public function updateData()
  {
    $this->db->transBegin();
    try {

        $data_db['PARAMETERCODE'] = isset($_POST['PARAMETERCODE'])? strval($_POST['PARAMETERCODE']):'';
        $data_db['PARAMETERNAME'] = isset($_POST['PARAMETERNAME'])? strval($_POST['PARAMETERNAME']):'';
        $data_db['VALUE'] = isset($_POST['MASTER_VALUE'])? floatval($_POST['MASTER_VALUE']):0;
        $data_db['PARENTCODE'] = isset($_POST['PARENTCODE'])? strval($_POST['PARENTCODE']):'';
  
        $data_db['COMP_ID'] = '03';
        $data_db['SITE_ID'] = '02';
        $data_db['MILLCODE'] = '0302';
        $data_db['MILLNAME'] = 'SJE PKS';
  
        $tablename = 'OP_MATERIAL_BALANCE';

        $cekData = $this->getRowData($data_db['PARAMETERCODE']);

        if(!empty($cekData)){
            $input = $this->db->table($tablename)->update($data_db,['PARAMETERCODE' => $data_db['PARAMETERCODE']]);;

            if ($input) {
                $this->db->query("commit;");
                $result['msg']['status'] = 'ok';
                $result['msg']['content'] = 'Data berhasil diupdate';
            }
        } else {
            $result['msg']['status'] = 'error';
            $result['msg']['content'] = 'Kode Tidak Digunakan, Gunakan Fitur Add';

        }
        
    } catch (\Exception $e) {
        $result['msg']['status'] = 'error';
        $result['msg']['content'] = 'Data gagal diupdate';
    }

    return $result;
  }

  public function deleteData()
  {
    $table = 'OP_MATERIAL_BALANCE';
    $result = $this->db->table($table)->delete(['PARAMETERCODE' => $_POST['id']]);
  }


}
