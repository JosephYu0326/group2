<?php
// require __DIR__ . '/parts/connect_db.php';

$title = '新增活動';
$pageName = 'ab-add';

$stmt = $pdo->query("SELECT * FROM activity_types ORDER BY Activity_Types_id");
$raw_data = $stmt->fetchAll();

$Activity_Types_id = [];

foreach ($raw_data as $r) {
    if ($r['Activity_Types_id'] != '') {
        $Activity_Types_id = $r;
    }
}

echo json_encode($Activity_Types_id);