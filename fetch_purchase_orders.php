<?php
$db = new SQLite3('database.sqlite');

$results = $db->query('SELECT * FROM PurchaseOrders');
$purchaseOrders = [];

while ($row = $results->fetchArray()) {
    $purchaseOrders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($purchaseOrders);
?>
