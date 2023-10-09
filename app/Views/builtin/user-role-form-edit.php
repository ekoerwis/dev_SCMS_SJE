<?php
helper('html');

$prefix_id = 'role_';
		
$checked = [];
foreach ($user_role as $row) {
	$checked[] = $prefix_id . $row['ID_ROLE'];
}

$checkbox[] = ['id' => 'check-all', 'name' => 'check_all', 'label' =>'Check All / Uncheck All'];
$check_all_checked = $checked ? ['check_all'] : [];
echo checkbox($checkbox, $check_all_checked);

echo '<hr class="mt-1 mb-2"/>';
echo '<form method="post" id="check-all-wrapper" action="">';
$checkbox = [];
foreach ($role as $val) {
	$checkbox[] = ['id' => $val['ID_ROLE'], 'name' => $prefix_id . $val['ID_ROLE'], 'label' => $val['JUDUL_ROLE']];
}

echo checkbox($checkbox, $checked);
echo '</form>';