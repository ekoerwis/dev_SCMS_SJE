<?php


 function ubahPrefix($sqltext=''){

		$dbdr='mysql';
		$dbdr='postgres';

		if($dbdr=='postgres'){
			$pref1='{prefix_portal}';
			$pref2='{prefix_apps}';
			$pref3='{prefix_trxi}';
			$pref11='"SCH_PORTAL".';
			$pref22='"SCH_APPS".';
			$pref33='"SCH_TRXI".';
		}
		else {
			$pref1='{prefix_portal}';
			$pref2='{prefix_apps}';
			$pref3='{prefix_trxi}';
			$pref11=' ';
			$pref22=' ';
			$pref33=' ';
		}
		

		$sqlstring1 = str_replace($pref1, $pref11, $sqltext);
		$sqlstring2 = str_replace($pref2, $pref22, $sqlstring1);
		$sqlstring3 = str_replace($pref3, $pref33, $sqlstring2);

		return $sqlstring3;
	}


function helpertesting(){
	$eko='ini kalimat helper';
	return $eko;
}