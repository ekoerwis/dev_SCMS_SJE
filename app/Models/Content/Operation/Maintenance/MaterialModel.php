<?php

namespace App\Models\Content\Operation\Maintenance;

class MaterialModel extends \App\Models\BaseModel
{

  protected $db2;

  public function __construct()
  {
    parent::__construct();
    $this->db2 = db_connect("dbapps");
  }

  public function getMaterialList()
	{
    $q = isset($_POST['q']) ? strval ($_POST['q']) :'%%';
    $company = '2000';
    $site = '2100';

		

		$sql = "SELECT COUNT(*) JUMLAH FROM (
      SELECT DISTINCT CASE WHEN ITEMCODE = '$q' THEN NULL
      WHEN GROUPCODE = '0' THEN NULL ELSE GROUPCODE END GROUPCODE,GROUPNAME,
      SEQ,ITEMCODE,ITEMDESCRIPTION,BRAND,UOMCODE,PARTNO,SPECIFICATION,GRADE,LIFETIME,PRIOROTY,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
      FROM (
        SELECT A.ITEMCODE,A.ITEMDESCRIPTION,SEQ,A.GROUPCODE,B.GROUPNAME,B.BRAND,B.UOMCODE,B.PARTNO,B.SPECIFICATION,B.GRADE,B.LIFETIME,B.PRIOROTY,B.INACTIVEDATE
        FROM (
          SELECT ITEMCODE,ITEMDESCRIPTION,GROUPCODE,0 SEQ FROM ASSETMAINTENANCEMATERIAL
          UNION ALL
          SELECT GROUPCODE,GROUPNAME,PARENT_GROUP_CODE,SEQ FROM ASSETMAINTENANCEGROUPMATERIAL
        ) A LEFT JOIN (SELECT * FROM ASSETMAINTENANCEMATERIAL) B ON A.ITEMCODE=B.ITEMCODE AND A.GROUPCODE=B.GROUPCODE
      )
      START WITH ITEMCODE LIKE '$q'
      CONNECT BY PRIOR ITEMCODE=GROUPCODE
      ORDER SIBLINGS BY SEQ
		)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT  GROUPCODE,GROUPNAME,LEVELNAME,SEQ,ITEMCODE,ITEMDESCRIPTION,BRAND,UOMCODE,PARTNO,SPECIFICATION,GRADE,LIFETIME,PRIOROTY,TO_CHAR(INACTIVEDATE,'DD-Mon-YYYY') INACTIVEDATE,LEAF
            FROM (
              SELECT DISTINCT CASE WHEN ITEMCODE = '$q' THEN NULL
              WHEN GROUPCODE = '0' THEN NULL ELSE GROUPCODE END GROUPCODE,GROUPNAME,LEVELNAME,
              SEQ,ITEMCODE,ITEMDESCRIPTION,BRAND,UOMCODE,PARTNO,SPECIFICATION,GRADE,LIFETIME,PRIOROTY,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
              FROM (
                SELECT A.ITEMCODE,A.ITEMDESCRIPTION,SEQ,A.GROUPCODE,C.GROUPNAME,A.LEVELNAME,B.BRAND,B.UOMCODE,B.PARTNO,B.SPECIFICATION,B.GRADE,B.LIFETIME,B.PRIOROTY,B.INACTIVEDATE
                FROM (
                  SELECT ITEMCODE,ITEMDESCRIPTION,GROUPCODE,0 SEQ,'' LEVELNAME FROM ASSETMAINTENANCEMATERIAL
                  UNION ALL
                  SELECT GROUPCODE,GROUPNAME,PARENT_GROUP_CODE,SEQ,'X' LEVELNAME FROM ASSETMAINTENANCEGROUPMATERIAL
                ) A LEFT JOIN (SELECT * FROM ASSETMAINTENANCEMATERIAL) B ON A.ITEMCODE=B.ITEMCODE AND A.GROUPCODE=B.GROUPCODE
                LEFT JOIN (SELECT GROUPCODE,GROUPNAME FROM ASSETMAINTENANCEGROUPMATERIAL) C ON A.GROUPCODE=C.GROUPCODE
              )
              START WITH ITEMCODE LIKE '$q'
              CONNECT BY PRIOR ITEMCODE=GROUPCODE
              ORDER SIBLINGS BY SEQ
            )
            ORDER BY SEQ,ITEMCODE ASC";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;

		$data = array();
				if ($sql > 0) {
						$index = 0;

						foreach($sql as $row) {
								// $data['total'] = '1';
								$data['rows'][$index] = array(
										"ITEMCODE" => $row['ITEMCODE'],
										"ITEMDESCRIPTION" => $row['ITEMDESCRIPTION'],
										"GROUPCODE" => $row['GROUPCODE'],
                    "GROUPNAME" => $row['GROUPNAME'],
                    "LEVELNAME" => $row['LEVELNAME'],
                    "UOMCODE" => $row['UOMCODE'],

                    "BRAND" => $row['BRAND'],
                    "PARTNO" => $row['PARTNO'],
                    "SPECIFICATION" => $row['SPECIFICATION'],
                    "GRADE" => $row['GRADE'],
                    "LIFETIME" => $row['LIFETIME'],
                    "PRIOROTY" => $row['PRIOROTY'],
                    "INACTIVEDATE" => $row['INACTIVEDATE'],

										"LEAF" => $row['LEAF'],
										"_parentId" => $row['GROUPCODE']
								);

								$index++;
						}
				}

		return $data;

	}

  public function getAssetMaster()
	{
    $q = isset($_POST['q']) ? strval ($_POST['q']) :'%%';
    $company = '2000';
    $site = '2100';

		

		$sql = "SELECT COUNT(*) JUMLAH FROM (
			SELECT DISTINCT ASSET_ID,ASSETNAME,PARENT_ASET_ID,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
      ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
			FROM (
        SELECT ASSET_ID,ASSETNAME,CASE WHEN ASSET_ID = '$q' THEN NULL ELSE PARENT_ASET_ID END PARENT_ASET_ID,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
        ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE
        FROM ASSETMAINTENANCEMASTER
				WHERE COMP_ID = '$company' AND SITE_ID = '$site'
			)
      START WITH ASSET_ID LIKE '$q'
			CONNECT BY PRIOR ASSET_ID=PARENT_ASET_ID
			ORDER SIBLINGS BY SEQ
		)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT A.ASSET_ID,ASSETNAME,PARENT_ASET_ID,PARENTNAME,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
            ASSETLOCATION_CODE,LOCATIONNAME,SUPPLIER_CODE,SUPPLIER_NAME,TO_CHAR(INSTALLDATE,'DD-Mon-YYYY') INSTALLDATE,
            TO_CHAR(DATEO_ON_OPERATION,'DD-Mon-YYYY') DATEO_ON_OPERATION,REMARKS,TO_CHAR(INACTIVEDATE,'DD-Mon-YYYY') INACTIVEDATE,LEAF
            FROM (
              SELECT DISTINCT ASSET_ID,ASSETNAME,CASE WHEN ASSET_ID = '$q' THEN NULL ELSE PARENT_ASET_ID END PARENT_ASET_ID,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
              ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
              FROM (
                SELECT ASSET_ID,ASSETNAME,PARENT_ASET_ID,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
                ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE
                FROM ASSETMAINTENANCEMASTER
                WHERE COMP_ID = '$company' AND SITE_ID = '$site'
              )
              START WITH ASSET_ID LIKE '$q'
              CONNECT BY PRIOR ASSET_ID=PARENT_ASET_ID
              ORDER SIBLINGS BY SEQ
            ) A
            LEFT JOIN (SELECT ASSET_ID,ASSETNAME PARENTNAME FROM ASSETMAINTENANCEMASTER WHERE COMP_ID = '$company' AND SITE_ID = '$site') B ON A.PARENT_ASET_ID=B.ASSET_ID
            LEFT JOIN (SELECT LOCATION_CODE,DESCRIPTION LOCATIONNAME FROM ASSETMAINTENANCELOCATION WHERE COMP_ID = '$company' AND SITE_ID = '$site') C ON A.ASSETLOCATION_CODE = C.LOCATION_CODE
            ORDER BY SEQ,ASSET_ID ASC";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;

		$data = array();
				if ($sql > 0) {
						$index = 0;

						foreach($sql as $row) {
								// $data['total'] = '1';
								$data['rows'][$index] = array(
										"ASSET_ID" => $row['ASSET_ID'],
										"ASSETNAME" => $row['ASSETNAME'],
										"PARENT_ASET_ID" => $row['PARENT_ASET_ID'],
                    "PARENTNAME" => $row['PARENTNAME'],
										"SEQ" => $row['SEQ'],
										"FIXEDASSETCODE" => $row['FIXEDASSETCODE'],
										"SPESIFICATION" => $row['SPESIFICATION'],

                    "BRAND" => $row['BRAND'],
                    "MADEIN" => $row['MADEIN'],
                    "SERIALPRODNUMBER" => $row['SERIALPRODNUMBER'],
                    "ASSETLOCATION_CODE" => $row['ASSETLOCATION_CODE'],
                    "LOCATIONNAME" => $row['LOCATIONNAME'],
                    "SUPPLIER_CODE" => $row['SUPPLIER_CODE'],
                    "SUPPLIER_NAME" => $row['SUPPLIER_NAME'],
                    "INSTALLDATE" => $row['INSTALLDATE'],
                    "DATEO_ON_OPERATION" => $row['DATEO_ON_OPERATION'],
                    "REMARKS" => $row['REMARKS'],
                    "INACTIVEDATE" => $row['INACTIVEDATE'],

										"LEAF" => $row['LEAF'],
										"_parentId" => $row['PARENT_ASET_ID']
								);

								$index++;
						}
				}

		return $data;

	}

  //-------------------------------------------------
  public function getFaFixedAsset()
	{
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$limit = $page*$rows;
		$offset = ($page-1)*$rows;
		$result = array();

		

    $sql = "SELECT count(*)JUMLAH FROM (
              SELECT FIXEDASSETCODE,ASSETNAME,SPESIFICATION,BRAND,MADEIN,TAGNUMBER,SERIALPRODNUMBER
              FROM FAFIXEDASSET@ERPDBLINK
              WHERE LOWER(FIXEDASSETCODE) LIKE LOWER('%$q%') OR LOWER(ASSETNAME) like LOWER('%$q%')
              ORDER BY SEQ
            )";

		$sql = $this->db2->query($sql)->getRowArray();

		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM (
            SELECT FIXEDASSETCODE,ASSETNAME,SPESIFICATION,BRAND,MADEIN,TAGNUMBER,SERIALPRODNUMBER,ROWNUM AS RNUM
						FROM (
              SELECT FIXEDASSETCODE,ASSETNAME,SPESIFICATION,BRAND,MADEIN,TAGNUMBER,SERIALPRODNUMBER
              FROM FAFIXEDASSET@ERPDBLINK
              WHERE LOWER(FIXEDASSETCODE) LIKE LOWER('%$q%') OR LOWER(ASSETNAME) like LOWER('%$q%')
              ORDER BY SEQ
            ) WHERE ROWNUM <= $limit
						) WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}

  public function getSupplier()
	{
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$limit = $page*$rows;
		$offset = ($page-1)*$rows;
		$result = array();

		

    $sql = "SELECT count(*)JUMLAH FROM (
              SELECT SUPPLIERCODE,SUPPLIERNAME FROM SUPPLIER@ERPDBLINK
              WHERE LOWER(SUPPLIERCODE) LIKE LOWER('%$q%') OR LOWER(SUPPLIERNAME) like LOWER('%$q%')
              ORDER BY SUPPLIERCODE
            )";

		$sql = $this->db2->query($sql)->getRowArray();

		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM (
            SELECT SUPPLIERCODE,SUPPLIERNAME,ROWNUM AS RNUM
						FROM (
              SELECT SUPPLIERCODE,SUPPLIERNAME FROM SUPPLIER@ERPDBLINK
              WHERE LOWER(SUPPLIERCODE) LIKE LOWER('%$q%') OR LOWER(SUPPLIERNAME) like LOWER('%$q%')
              ORDER BY SUPPLIERCODE
            ) WHERE ROWNUM <= $limit
						) WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}
  // FILTER ASSET LOCATION --------------------------------------------------------
  public function getAssetLocation()
	{
    $q = isset($_POST['q']) ? strval ($_POST['q']) :'%%';
    $company = '2000';
    $site = '2100';

		

		$sql = "SELECT COUNT(*) JUMLAH FROM (
			SELECT DISTINCT LOCATION_CODE,DESCRIPTION,PARENT_LOCATION_CODE,SEQ,LOCATIONTYPECODE,REMARKS,TO_CHAR(INACTIVEDATE,'DD-Mon-YYYY') INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
			FROM (
        SELECT LOCATION_CODE,DESCRIPTION,CASE WHEN LOCATION_CODE = '$q' THEN NULL ELSE PARENT_LOCATION_CODE END PARENT_LOCATION_CODE,SEQ,LOCATIONTYPECODE,REMARKS,INACTIVEDATE
        FROM ASSETMAINTENANCELOCATION
				WHERE COMP_ID = '$company' AND SITE_ID = '$site'
			)
      START WITH LOCATION_CODE LIKE '$q'
			CONNECT BY PRIOR LOCATION_CODE=PARENT_LOCATION_CODE
			ORDER SIBLINGS BY SEQ
		)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT A.LOCATION_CODE,DESCRIPTION,PARENT_LOCATION_CODE,PARENTNAME,SEQ,A.LOCATIONTYPECODE,LOCATIONTYPENAME,REMARKS,TO_CHAR(INACTIVEDATE,'DD-Mon-YYYY') INACTIVEDATE,LEAF
            FROM (
              SELECT DISTINCT LOCATION_CODE,DESCRIPTION,PARENT_LOCATION_CODE,SEQ,LOCATIONTYPECODE,REMARKS,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
              FROM (
                SELECT LOCATION_CODE,DESCRIPTION,CASE WHEN LOCATION_CODE = '$q' THEN NULL ELSE PARENT_LOCATION_CODE END PARENT_LOCATION_CODE,SEQ,LOCATIONTYPECODE,REMARKS,INACTIVEDATE
                FROM ASSETMAINTENANCELOCATION
                WHERE COMP_ID = '$company' AND SITE_ID = '$site'
              )
              START WITH LOCATION_CODE LIKE '$q'
              CONNECT BY PRIOR LOCATION_CODE=PARENT_LOCATION_CODE
              ORDER SIBLINGS BY SEQ
            ) A
            LEFT JOIN (SELECT LOCATION_CODE,DESCRIPTION AS PARENTNAME FROM ASSETMAINTENANCELOCATION WHERE COMP_ID = '$company' AND SITE_ID = '$site') B ON A.PARENT_LOCATION_CODE = B.LOCATION_CODE
            LEFT JOIN (SELECT LOCATIONTYPECODE,LOCATIONTYPENAME FROM LOCATIONTYPE@ERPDBLINK) C ON A.LOCATIONTYPECODE = C.LOCATIONTYPECODE
            ORDER BY SEQ,LOCATION_CODE ASC";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;

		$data = array();
				if ($sql > 0) {
						$index = 0;

						foreach($sql as $row) {
								// $data['total'] = '1';
								$data['rows'][$index] = array(
										"LOCATION_CODE" => $row['LOCATION_CODE'],
										"DESCRIPTION" => $row['DESCRIPTION'],
										"PARENT_LOCATION_CODE" => $row['PARENT_LOCATION_CODE'],
                    "PARENTNAME" => $row['PARENTNAME'],
										"SEQ" => $row['SEQ'],

                    "LOCATIONTYPECODE" => $row['LOCATIONTYPECODE'],
                    "LOCATIONTYPENAME" => $row['LOCATIONTYPENAME'],
                    "REMARKS" => $row['REMARKS'],
                    "INACTIVEDATE" => $row['INACTIVEDATE'],

										"LEAF" => $row['LEAF'],
										"_parentId" => $row['PARENT_LOCATION_CODE']
								);

								$index++;
						}
				}

		return $data;

	}

  public function getLocationType()
	{
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$limit = $page*$rows;
		$offset = ($page-1)*$rows;
		$result = array();

		

    $sql = "SELECT count(*)JUMLAH FROM (
              SELECT LOCATIONTYPECODE,LOCATIONTYPENAME FROM LOCATIONTYPE@ERPDBLINK
              WHERE LOWER(LOCATIONTYPECODE) LIKE LOWER('%$q%') OR LOWER(LOCATIONTYPENAME) like LOWER('%$q%')
              ORDER BY LOCATIONTYPECODE
            )";

		$sql = $this->db2->query($sql)->getRowArray();

		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM (
            SELECT LOCATIONTYPECODE,LOCATIONTYPENAME,ROWNUM AS RNUM
						FROM (
              SELECT LOCATIONTYPECODE,LOCATIONTYPENAME FROM LOCATIONTYPE@ERPDBLINK
              WHERE LOWER(LOCATIONTYPECODE) LIKE LOWER('%$q%') OR LOWER(LOCATIONTYPENAME) like LOWER('%$q%')
              ORDER BY LOCATIONTYPECODE
            ) WHERE ROWNUM <= $limit
						) WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}
  // end FILTER ASSET LOCATION --------------------------------------------------------

  // FILTER ASSET GROUP --------------------------------------------------------
  public function getMaterialGroup()
	{
    $q = isset($_POST['q']) ? strval($_POST['q']) : '%%';
    $company = '2000';
    $site = '2100';

		

		$sql = "SELECT COUNT(*) JUMLAH FROM (
      SELECT DISTINCT GROUPCODE,GROUPNAME,PARENT_GROUP_CODE,SEQ,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
      FROM (
        SELECT GROUPCODE,GROUPNAME,
        CASE
        WHEN GROUPCODE = '$q' THEN NULL
        WHEN PARENT_GROUP_CODE = '0' THEN NULL
        ELSE PARENT_GROUP_CODE END PARENT_GROUP_CODE,
        SEQ,INACTIVEDATE
        FROM ASSETMAINTENANCEGROUPMATERIAL
      )
      START WITH GROUPCODE LIKE '$q'
      CONNECT BY PRIOR GROUPCODE=PARENT_GROUP_CODE
      ORDER SIBLINGS BY SEQ
		)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT A.GROUPCODE,GROUPNAME,PARENT_GROUP_CODE,PARENTNAME,SEQ,TO_CHAR(INACTIVEDATE,'DD-Mon-YYYY') INACTIVEDATE,LEAF
            FROM (
              SELECT DISTINCT GROUPCODE,GROUPNAME,PARENT_GROUP_CODE,SEQ,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
              FROM (
                SELECT GROUPCODE,GROUPNAME,
                CASE
                WHEN GROUPCODE = '$q' THEN NULL
                WHEN PARENT_GROUP_CODE = '0' THEN NULL
                ELSE PARENT_GROUP_CODE END PARENT_GROUP_CODE,
                SEQ,INACTIVEDATE
                FROM ASSETMAINTENANCEGROUPMATERIAL
              )
              START WITH GROUPCODE LIKE '$q'
              CONNECT BY PRIOR GROUPCODE=PARENT_GROUP_CODE
              ORDER SIBLINGS BY SEQ
            ) A
            LEFT JOIN (SELECT GROUPCODE,GROUPNAME PARENTNAME FROM ASSETMAINTENANCEGROUPMATERIAL) B ON A.PARENT_GROUP_CODE=B.GROUPCODE
            ORDER BY GROUPCODE,SEQ";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;

		$data = array();
				if ($sql > 0) {
						$index = 0;

						foreach($sql as $row) {
								// $data['total'] = '1';
								$data['rows'][$index] = array(
										"GROUPCODE" => $row['GROUPCODE'],
										"GROUPNAME" => $row['GROUPNAME'],
										"PARENT_GROUP_CODE" => $row['PARENT_GROUP_CODE'],
                    "PARENTNAME" => $row['PARENTNAME'],
										"SEQ" => $row['SEQ'],
                    "INACTIVEDATE" => $row['INACTIVEDATE'],

										"LEAF" => $row['LEAF'],
										"_parentId" => $row['PARENT_GROUP_CODE']
								);

								$index++;
						}
				}

		return $data;

	}

  public function getUOM()
	{
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;
		$result = array();


		$sql = "SELECT COUNT(*) JUMLAH FROM UNITOFMEASURE
					WHERE LOWER(UNITOFMEASURECODE) LIKE LOWER('%$q%') OR LOWER(UNITOFMEASUREDESC) LIKE LOWER('%$q%')";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM(
						SELECT UNITOFMEASURECODE,UNITOFMEASUREDESC,ROWNUM AS RNUM FROM (
							SELECT * FROM (
							SELECT UNITOFMEASURECODE,UNITOFMEASUREDESC FROM UNITOFMEASURE
							WHERE UNITOFMEASURECODE <> 'NA'
						) WHERE LOWER(UNITOFMEASURECODE) LIKE LOWER('%$q%') OR LOWER(UNITOFMEASUREDESC) LIKE LOWER('%$q%')
						) WHERE ROWNUM <= $limit
						) WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}
  // end FILTER ASSET GROUP --------------------------------------------------------

  public function getMaterialById($id){

    $company = '2000';
    $site = '2100';

		

		$sql = "SELECT GROUPCODE,GROUPNAME,ITEMCODE,ITEMDESCRIPTION,BRAND,UOMCODE,PARTNO,SPECIFICATION,GRADE,LIFETIME,PRIOROTY,INACTIVEDATE
            FROM ASSETMAINTENANCEMATERIAL
            WHERE ITEMCODE = ?
						";

		$result = $this->db2->query($sql, trim($id))->getRowArray();
		return $result;

	}

  public function getMaterialGroupById($id){

    $company = '2000';
    $site = '2100';

		

		$sql = "SELECT GROUPCODE,GROUPNAME,PARENT_GROUP_CODE,SEQ,INACTIVEDATE FROM ASSETMAINTENANCEGROUPMATERIAL
            WHERE GROUPCODE = ?
						";

		$result = $this->db2->query($sql, trim($id))->getRowArray();
		return $result;

	}

  public function saveMaterial()
  {
    $this->db2->transBegin();
    try {


      $data_db['ITEMCODE'] = strtoupper($_POST['ITEMCODE']);
      $data_db['ITEMDESCRIPTION'] = strtoupper($_POST['ITEMDESCRIPTION']);
      $data_db['GROUPCODE'] = strtoupper($_POST['GROUPCODE']);
      $data_db['GROUPNAME'] = strtoupper($_POST['GROUPNAME']);
      $data_db['UOMCODE'] = strtoupper($_POST['UOMCODE']);
      $data_db['BRAND'] = strtoupper($_POST['BRAND']);
      $data_db['PARTNO'] = strtoupper($_POST['PARTNO']);
      $data_db['SPECIFICATION'] = strtoupper($_POST['SPECIFICATION']);
      $data_db['GRADE'] = strtoupper($_POST['GRADE']);
      $data_db['LIFETIME'] = strtoupper($_POST['LIFETIME']);

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      $tablename = 'ASSETMAINTENANCEMATERIAL';
      $input = $this->db2->table($tablename)->insert($data_db);

      if ($input) {
        $this->db2->query("commit;");
        $result['msg']['status'] = 'ok';
        $result['msg']['content'] = 'Data berhasil disimpan';
      }

    } catch (\Exception $e) {
      $result['msg']['status'] = 'error';
      $result['msg']['content'] = 'Data gagal disimpan';
    }

    return $result;
  }

  public function updateMaterial()
  {
    $this->db2->transBegin();
    try {


      $data_db['ITEMCODE'] = strtoupper($_POST['ITEMCODE']);
      $data_db['ITEMDESCRIPTION'] = strtoupper($_POST['ITEMDESCRIPTION']);
      $data_db['GROUPCODE'] = strtoupper($_POST['GROUPCODE']);
      $data_db['GROUPNAME'] = strtoupper($_POST['GROUPNAME']);
      $data_db['UOMCODE'] = strtoupper($_POST['UOMCODE']);
      $data_db['BRAND'] = strtoupper($_POST['BRAND']);
      $data_db['PARTNO'] = strtoupper($_POST['PARTNO']);
      $data_db['SPECIFICATION'] = strtoupper($_POST['SPECIFICATION']);
      $data_db['GRADE'] = strtoupper($_POST['GRADE']);
      $data_db['LIFETIME'] = strtoupper($_POST['LIFETIME']);

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      $tablename = 'ASSETMAINTENANCEMATERIAL';
      $input = $this->db2->table($tablename)->update($data_db,['ITEMCODE' => $_POST['ITEMCODE']]);;

      if ($input) {
        $this->db2->query("commit;");
        $result['msg']['status'] = 'ok';
        $result['msg']['content'] = 'Data berhasil diupdate';
      }

    } catch (\Exception $e) {
      $result['msg']['status'] = 'error';
      $result['msg']['content'] = 'Data gagal diupdate';
    }

    return $result;
  }

  public function deleteMaterial()
  {
    $table = 'ASSETMAINTENANCEMATERIAL';
    $result = $this->db2->table($table)->delete(['ITEMCODE' => $_POST['id']]);
  }

  public function saveMaterialGroup()
  {
    $this->db2->transBegin();
    try {


      $data_db['GROUPCODE'] = strtoupper($_POST['GROUPCODE']);
      $data_db['GROUPNAME'] = strtoupper($_POST['GROUPNAME']);
      $data_db['PARENT_GROUP_CODE'] = strtoupper($_POST['PARENT_GROUP_CODE']);
      $data_db['SEQ'] = $_POST['SEQ'];

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      $tablename = 'ASSETMAINTENANCEGROUPMATERIAL';
      $input = $this->db2->table($tablename)->insert($data_db);

      if ($input) {
        $this->db2->query("commit;");
        $result['msg']['status'] = 'ok';
        $result['msg']['content'] = 'Data berhasil disimpan';
      }

    } catch (\Exception $e) {
      $result['msg']['status'] = 'error';
      $result['msg']['content'] = 'Data gagal disimpan';
    }

    return $result;
  }

  public function updateMaterialGroup()
  {
    $this->db2->transBegin();
    try {


      $data_db['GROUPCODE'] = strtoupper($_POST['GROUPCODE']);
      $data_db['GROUPNAME'] = strtoupper($_POST['GROUPNAME']);
      $data_db['PARENT_GROUP_CODE'] = strtoupper($_POST['PARENT_GROUP_CODE']);
      $data_db['SEQ'] = $_POST['SEQ'];

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      $tablename = 'ASSETMAINTENANCEGROUPMATERIAL';
      $input = $this->db2->table($tablename)->update($data_db,['GROUPCODE' => $_POST['GROUPCODE']]);;

      if ($input) {
        $this->db2->query("commit;");
        $result['msg']['status'] = 'ok';
        $result['msg']['content'] = 'Data berhasil diupdate';
      }

    } catch (\Exception $e) {
      $result['msg']['status'] = 'error';
      $result['msg']['content'] = 'Data gagal diupdate';
    }

    return $result;
  }

  public function deleteMaterialGroup()
  {
    $table = 'ASSETMAINTENANCEGROUPMATERIAL';
    $result = $this->db2->table($table)->delete(['GROUPCODE' => $_POST['id']]);
  }


}
