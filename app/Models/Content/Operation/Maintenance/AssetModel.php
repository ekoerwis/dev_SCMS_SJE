<?php

namespace App\Models\Content\Operation\Maintenance;

class AssetModel extends \App\Models\BaseModel
{

  protected $db2;

  public function __construct()
  {
    parent::__construct();
    $this->db2 = db_connect("dbapps");
  }

  public function getAssetMasterLocation()
	{
    $q = isset($_POST['q']) ? strval ($_POST['q']) :'%%';
    $company = '3000';
    $site = '3100';


		$sql = "SELECT COUNT(*) JUMLAH FROM (
      SELECT DISTINCT ASSET_ID,ASSETNAME,CASE WHEN ASSET_ID = '$q' THEN NULL ELSE PARENT_ASET_ID END PARENT_ASET_ID,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
      ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
      FROM (
        SELECT A.ASSET_ID,A.ASSETNAME,A.PARENT_ASET_ID,A.SEQ,B.FIXEDASSETCODE,B.SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
        ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE
        FROM (
          SELECT ASSET_ID,ASSETNAME,CASE WHEN PARENT_ASET_ID IS NULL THEN ASSETLOCATION_CODE ELSE PARENT_ASET_ID END PARENT_ASET_ID,SEQ FROM ASSETMAINTENANCEMASTER WHERE COMP_ID = '$company' AND SITE_ID = '$site' AND ASSET_ID LIKE 'KR%'
          UNION ALL
          SELECT LOCATION_CODE,DESCRIPTION,PARENT_LOCATION_CODE,SEQ FROM ASSETMAINTENANCELOCATION WHERE COMP_ID = '$company' AND SITE_ID = '$site'
        ) A LEFT JOIN (SELECT * FROM ASSETMAINTENANCEMASTER WHERE COMP_ID = '$company' AND SITE_ID = '$site') B ON A.ASSET_ID=B.ASSET_ID
      )
      START WITH ASSET_ID LIKE '$q'
      CONNECT BY PRIOR ASSET_ID=PARENT_ASET_ID
      ORDER SIBLINGS BY SEQ
		)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT A.ASSET_ID,ASSETNAME,LEVELNAME,PARENT_ASET_ID,PARENTNAME,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
            ASSETLOCATION_CODE,LOCATIONNAME,SUPPLIER_CODE,SUPPLIER_NAME,TO_CHAR(INSTALLDATE,'DD-Mon-YYYY') INSTALLDATE,
            TO_CHAR(DATEO_ON_OPERATION,'DD-Mon-YYYY') DATEO_ON_OPERATION,REMARKS,TO_CHAR(INACTIVEDATE,'DD-Mon-YYYY') INACTIVEDATE,LEAF
            FROM (
              SELECT DISTINCT ASSET_ID,ASSETNAME,LEVELNAME,CASE WHEN ASSET_ID = '$q' THEN NULL ELSE PARENT_ASET_ID END PARENT_ASET_ID,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
              ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
              FROM (
                SELECT A.ASSET_ID,A.ASSETNAME,A.LEVELNAME,A.PARENT_ASET_ID,A.SEQ,B.FIXEDASSETCODE,B.SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
                ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE
                FROM (
                  SELECT ASSET_ID,ASSETNAME,CASE WHEN PARENT_ASET_ID IS NULL THEN ASSETLOCATION_CODE ELSE PARENT_ASET_ID END PARENT_ASET_ID,SEQ,'' LEVELNAME FROM ASSETMAINTENANCEMASTER WHERE COMP_ID = '$company' AND SITE_ID = '$site' AND ASSET_ID NOT LIKE '20100002%'
                  UNION ALL
                  SELECT LOCATION_CODE,DESCRIPTION,PARENT_LOCATION_CODE,SEQ,'X' LEVELNAME FROM ASSETMAINTENANCELOCATION WHERE COMP_ID = '$company' AND SITE_ID = '$site'
                ) A LEFT JOIN (SELECT * FROM ASSETMAINTENANCEMASTER WHERE COMP_ID = '$company' AND SITE_ID = '$site') B ON A.ASSET_ID=B.ASSET_ID
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
                    "LEVELNAME" => $row['LEVELNAME'],
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

  public function getAssetMaster()
	{
    $q = isset($_POST['q']) ? strval ($_POST['q']) :'%%';
    $company = '3000';
    $site = '3100';

		

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
    $company = '3000';
    $site = '3100';

		

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
  public function getAssetMaintenanceGroup()
	{
    $q = isset($_POST['q']) ? strval($_POST['q']) : '%%';
    $company = '3000';
    $site = '3100';

		

		$sql = "SELECT COUNT(*) JUMLAH FROM (
			SELECT DISTINCT ASSET_GROUP_ID,DESCRIPTION,PARENT_ASSET_GROUP_ID,FIXED_ASSET_GROUP,SEQ,TO_CHAR(INACTIVEDATE,'DD-Mon-YYYY') INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
			FROM (
        SELECT ASSET_GROUP_ID,DESCRIPTION,
        CASE
        WHEN ASSET_GROUP_ID = '$q' THEN NULL
        WHEN PARENT_ASSET_GROUP_ID = '0' THEN NULL
        ELSE PARENT_ASSET_GROUP_ID END PARENT_ASSET_GROUP_ID,
        FIXED_ASSET_GROUP,SEQ,INACTIVEDATE
        FROM ASSETMAINTENANCEGROUP
				WHERE COMP_ID = '$company' AND SITE_ID = '$site'
			)
      START WITH ASSET_GROUP_ID LIKE '$q'
			CONNECT BY PRIOR ASSET_GROUP_ID=PARENT_ASSET_GROUP_ID
			ORDER SIBLINGS BY SEQ
		)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT A.ASSET_GROUP_ID,DESCRIPTION,PARENT_ASSET_GROUP_ID,PARENTNAME,FIXED_ASSET_GROUP,FAGROUPNAME,SEQ,TO_CHAR(INACTIVEDATE,'DD-Mon-YYYY') INACTIVEDATE,LEAF
            FROM (
              SELECT DISTINCT ASSET_GROUP_ID,DESCRIPTION,PARENT_ASSET_GROUP_ID,FIXED_ASSET_GROUP,SEQ,INACTIVEDATE,CONNECT_BY_ISLEAF AS LEAF
              FROM (
                SELECT ASSET_GROUP_ID,DESCRIPTION,
                CASE
                WHEN ASSET_GROUP_ID = '$q' THEN NULL
                WHEN PARENT_ASSET_GROUP_ID = '0' THEN NULL
                ELSE PARENT_ASSET_GROUP_ID END PARENT_ASSET_GROUP_ID,
                FIXED_ASSET_GROUP,SEQ,INACTIVEDATE
                FROM ASSETMAINTENANCEGROUP
                WHERE COMP_ID = '$company' AND SITE_ID = '$site'
              )
              START WITH ASSET_GROUP_ID LIKE '$q'
              CONNECT BY PRIOR ASSET_GROUP_ID=PARENT_ASSET_GROUP_ID
              ORDER SIBLINGS BY SEQ
            ) A
            LEFT JOIN (SELECT ASSET_GROUP_ID,DESCRIPTION AS PARENTNAME FROM ASSETMAINTENANCEGROUP WHERE COMP_ID = '$company' AND SITE_ID = '$site') B ON A.PARENT_ASSET_GROUP_ID = B.ASSET_GROUP_ID
            LEFT JOIN (SELECT GROUPID,DESCRIPTION AS FAGROUPNAME FROM FAGROUP@ERPDBLINK) C ON A.FIXED_ASSET_GROUP = C.GROUPID
            ORDER BY SEQ,ASSET_GROUP_ID ASC";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;

		$data = array();
				if ($sql > 0) {
						$index = 0;

						foreach($sql as $row) {
								// $data['total'] = '1';
								$data['rows'][$index] = array(
										"ASSET_GROUP_ID" => $row['ASSET_GROUP_ID'],
										"DESCRIPTION" => $row['DESCRIPTION'],
										"PARENT_ASSET_GROUP_ID" => $row['PARENT_ASSET_GROUP_ID'],
                    "PARENTNAME" => $row['PARENTNAME'],
										"SEQ" => $row['SEQ'],

                    "FIXED_ASSET_GROUP" => $row['FIXED_ASSET_GROUP'],
                    "FAGROUPNAME" => $row['FAGROUPNAME'],
                    "INACTIVEDATE" => $row['INACTIVEDATE'],

										"LEAF" => $row['LEAF'],
										"_parentId" => $row['PARENT_ASSET_GROUP_ID']
								);

								$index++;
						}
				}

		return $data;

	}

  public function getFaGroup()
	{
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$limit = $page*$rows;
		$offset = ($page-1)*$rows;
		$result = array();

		

    $sql = "SELECT count(*)JUMLAH FROM (
            SELECT GROUPID,DESCRIPTION FROM FAGROUP@ERPDBLINK
              WHERE LOWER(GROUPID) LIKE LOWER('%$q%') OR LOWER(DESCRIPTION) like LOWER('%$q%')
              ORDER BY GROUPID
            )";

		$sql = $this->db2->query($sql)->getRowArray();

		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM (
            SELECT GROUPID,DESCRIPTION,ROWNUM AS RNUM
						FROM (
              SELECT GROUPID,DESCRIPTION FROM FAGROUP@ERPDBLINK
              WHERE LOWER(GROUPID) LIKE LOWER('%$q%') OR LOWER(DESCRIPTION) like LOWER('%$q%')
              ORDER BY GROUPID
            ) WHERE ROWNUM <= $limit
						) WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}
  // end FILTER ASSET GROUP --------------------------------------------------------

  public function getAssetMasterById($id){

    $company = '3000';
    $site = '3100';

		

		$sql = "SELECT ASSET_ID,ASSETNAME,PARENT_ASET_ID,SEQ,FIXEDASSETCODE,SPESIFICATION,BRAND,MADEIN,SERIALPRODNUMBER,
            ASSETLOCATION_CODE,SUPPLIER_CODE,SUPPLIER_NAME,INSTALLDATE,DATEO_ON_OPERATION,REMARKS,INACTIVEDATE
            FROM ASSETMAINTENANCEMASTER
            WHERE COMP_ID = '$company' AND SITE_ID = '$site'
            AND ASSET_ID = ?
						";

		$result = $this->db2->query($sql, trim($id))->getRowArray();
		return $result;

	}

  public function getAssetLocationById($id){

    $company = '3000';
    $site = '3100';

		

		$sql = "SELECT LOCATION_CODE,DESCRIPTION,PARENT_LOCATION_CODE,SEQ,LOCATIONTYPECODE,REMARKS,INACTIVEDATE
            FROM ASSETMAINTENANCELOCATION
            WHERE COMP_ID = '$company' AND SITE_ID = '$site'
            AND LOCATION_CODE = ?
						";

		$result = $this->db2->query($sql, trim($id))->getRowArray();
		return $result;

	}

  public function getAssetMaintenanceGroupById($id){

    $company = '3000';
    $site = '3100';

		

		$sql = "SELECT ASSET_GROUP_ID,DESCRIPTION,PARENT_ASSET_GROUP_ID,FIXED_ASSET_GROUP,SEQ,INACTIVEDATE
            FROM ASSETMAINTENANCEGROUP
            WHERE COMP_ID = '$company' AND SITE_ID = '$site'
            AND ASSET_GROUP_ID = ?
						";

		$result = $this->db2->query($sql, trim($id))->getRowArray();
		return $result;

	}

  public function saveMaster()
  {
    $this->db2->transBegin();
    try {

      $data_db['ASSET_ID'] = strtoupper($_POST['ASSET_ID']);
      $data_db['ASSETNAME'] = strtoupper($_POST['ASSETNAME']);
      $data_db['PARENT_ASET_ID'] = strtoupper($_POST['PARENT_ASET_ID']);
      $data_db['SEQ'] = $_POST['SEQ'];
      $data_db['ASSETLOCATION_CODE'] = strtoupper($_POST['ASSETLOCATION_CODE']);
      $data_db['FIXEDASSETCODE'] = strtoupper($_POST['FIXEDASSETCODE']);
      $data_db['SPESIFICATION'] = strtoupper($_POST['SPESIFICATION']);
      $data_db['BRAND'] = strtoupper($_POST['BRAND']);
      $data_db['MADEIN'] = strtoupper($_POST['MADEIN']);
      $data_db['SERIALPRODNUMBER'] = strtoupper($_POST['SERIALPRODNUMBER']);
      $data_db['SUPPLIER_CODE'] = strtoupper($_POST['SUPPLIER_CODE']);
      $data_db['SUPPLIER_NAME'] = strtoupper($_POST['SUPPLIER_NAME']);

      if($_POST['INSTALLDATE'] <> null){
        $data_db['INSTALLDATE'] = date("d-M-Y", strtotime($_POST['INSTALLDATE']));
      } else {
        $data_db['INSTALLDATE'] = null;
      }

      if($_POST['DATEO_ON_OPERATION'] <> null){
        $data_db['DATEO_ON_OPERATION'] = date("d-M-Y", strtotime($_POST['DATEO_ON_OPERATION']));
      } else {
        $data_db['DATEO_ON_OPERATION'] = null;
      }

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      $data_db['REMARKS'] = strtoupper($_POST['REMARKS']);

      $data_db['COMP_ID'] = '3000';
      $data_db['SITE_ID'] = '3100';

      $tablename = 'ASSETMAINTENANCEMASTER';
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

  public function updateMaster()
  {
    $this->db2->transBegin();
    try {

      $data_db['ASSET_ID'] = strtoupper($_POST['ASSET_ID']);
      $data_db['ASSETNAME'] = strtoupper($_POST['ASSETNAME']);
      $data_db['PARENT_ASET_ID'] = strtoupper($_POST['PARENT_ASET_ID']);
      $data_db['SEQ'] = $_POST['SEQ'];
      $data_db['ASSETLOCATION_CODE'] = strtoupper($_POST['ASSETLOCATION_CODE']);
      $data_db['FIXEDASSETCODE'] = strtoupper($_POST['FIXEDASSETCODE']);
      $data_db['SPESIFICATION'] = strtoupper($_POST['SPESIFICATION']);
      $data_db['BRAND'] = strtoupper($_POST['BRAND']);
      $data_db['MADEIN'] = strtoupper($_POST['MADEIN']);
      $data_db['SERIALPRODNUMBER'] = strtoupper($_POST['SERIALPRODNUMBER']);
      $data_db['SUPPLIER_CODE'] = strtoupper($_POST['SUPPLIER_CODE']);
      $data_db['SUPPLIER_NAME'] = strtoupper($_POST['SUPPLIER_NAME']);

      if($_POST['INSTALLDATE'] <> null){
        $data_db['INSTALLDATE'] = date("d-M-Y", strtotime($_POST['INSTALLDATE']));
      } else {
        $data_db['INSTALLDATE'] = null;
      }

      if($_POST['DATEO_ON_OPERATION'] <> null){
        $data_db['DATEO_ON_OPERATION'] = date("d-M-Y", strtotime($_POST['DATEO_ON_OPERATION']));
      } else {
        $data_db['DATEO_ON_OPERATION'] = null;
      }

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      $data_db['REMARKS'] = strtoupper($_POST['REMARKS']);

      $data_db['COMP_ID'] = '3000';
      $data_db['SITE_ID'] = '3100';

      $tablename = 'ASSETMAINTENANCEMASTER';
      $input = $this->db2->table($tablename)->update($data_db,['ASSET_ID' => $_POST['ASSET_ID']]);;

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

  public function deleteMaster()
  {
    $table = 'ASSETMAINTENANCEMASTER';
    $result = $this->db2->table($table)->delete(['ASSET_ID' => $_POST['id']]);
  }

  public function saveLocation()
  {
    $this->db2->transBegin();
    try {

      $data_db['LOCATION_CODE'] = strtoupper($_POST['LOCATION_CODE']);
      $data_db['DESCRIPTION'] = strtoupper($_POST['DESCRIPTION']);
      $data_db['PARENT_LOCATION_CODE'] = strtoupper($_POST['PARENT_LOCATION_CODE']);
      $data_db['SEQ'] = $_POST['SEQ'];
      $data_db['LOCATIONTYPECODE'] = strtoupper($_POST['LOCATIONTYPECODE']);

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      $data_db['REMARKS'] = strtoupper($_POST['REMARKS']);

      $data_db['COMP_ID'] = '3000';
      $data_db['SITE_ID'] = '3100';

      $tablename = 'ASSETMAINTENANCELOCATION';
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

  public function updateLocation()
  {
    $this->db2->transBegin();
    try {

      $data_db['LOCATION_CODE'] = strtoupper($_POST['LOCATION_CODE']);
      $data_db['DESCRIPTION'] = strtoupper($_POST['DESCRIPTION']);
      $data_db['PARENT_LOCATION_CODE'] = strtoupper($_POST['PARENT_LOCATION_CODE']);
      $data_db['SEQ'] = $_POST['SEQ'];
      $data_db['LOCATIONTYPECODE'] = strtoupper($_POST['LOCATIONTYPECODE']);

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      $data_db['REMARKS'] = strtoupper($_POST['REMARKS']);

      $data_db['COMP_ID'] = '3000';
      $data_db['SITE_ID'] = '3100';

      $tablename = 'ASSETMAINTENANCELOCATION';
      $input = $this->db2->table($tablename)->update($data_db,['LOCATION_CODE' => $_POST['LOCATION_CODE']]);;

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

  public function deleteLocation()
  {
    $table = 'ASSETMAINTENANCELOCATION';
    $result = $this->db2->table($table)->delete(['LOCATION_CODE' => $_POST['id']]);
  }

  public function saveMaintenanceGroup()
  {
    $this->db2->transBegin();
    try {

      $data_db['ASSET_GROUP_ID'] = strtoupper($_POST['ASSET_GROUP_ID']);
      $data_db['DESCRIPTION'] = strtoupper($_POST['DESCRIPTION']);

      if($_POST['PARENT_ASSET_GROUP_ID'] <> null){
        $data_db['PARENT_ASSET_GROUP_ID'] = strtoupper($_POST['PARENT_ASSET_GROUP_ID']);
      } else {
        $data_db['PARENT_ASSET_GROUP_ID'] = '0';
      }

      $data_db['SEQ'] = $_POST['SEQ'];
      $data_db['FIXED_ASSET_GROUP'] = strtoupper($_POST['FIXED_ASSET_GROUP']);

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      // $data_db['REMARKS'] = strtoupper($_POST['REMARKS']);

      $data_db['COMP_ID'] = '3000';
      $data_db['SITE_ID'] = '3100';

      $tablename = 'ASSETMAINTENANCEGROUP';
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

  public function updateMaintenanceGroup()
  {
    $this->db2->transBegin();
    try {

      $data_db['ASSET_GROUP_ID'] = strtoupper($_POST['ASSET_GROUP_ID']);
      $data_db['DESCRIPTION'] = strtoupper($_POST['DESCRIPTION']);

      if($_POST['PARENT_ASSET_GROUP_ID'] <> null){
        $data_db['PARENT_ASSET_GROUP_ID'] = strtoupper($_POST['PARENT_ASSET_GROUP_ID']);
      } else {
        $data_db['PARENT_ASSET_GROUP_ID'] = '0';
      }

      $data_db['SEQ'] = $_POST['SEQ'];
      $data_db['FIXED_ASSET_GROUP'] = strtoupper($_POST['FIXED_ASSET_GROUP']);

      if($_POST['INACTIVEDATE'] <> null){
        $data_db['INACTIVEDATE'] = date("d-M-Y", strtotime($_POST['INACTIVEDATE']));
      } else {
        $data_db['INACTIVEDATE'] = null;
      }

      // $data_db['REMARKS'] = strtoupper($_POST['REMARKS']);

      $data_db['COMP_ID'] = '3000';
      $data_db['SITE_ID'] = '3100';

      $tablename = 'ASSETMAINTENANCEGROUP';
      $input = $this->db2->table($tablename)->update($data_db,['ASSET_GROUP_ID' => $_POST['ASSET_GROUP_ID']]);;

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

  public function deleteMaintenanceGroup()
  {
    $table = 'ASSETMAINTENANCEGROUP';
    $result = $this->db2->table($table)->delete(['ASSET_GROUP_ID' => $_POST['id']]);
  }

}
