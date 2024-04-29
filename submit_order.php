<?php
// Made with Chatgpt
session_start();

var_dump($_POST);


$db = new SQLite3('database.sqlite');


if (!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}


if (
    empty($_POST['item_number']) ||
    empty($_POST['description']) ||
    empty($_POST['unit_cost']) ||
    empty($_POST['quantity']) ||
    (empty($_POST['account_number']) && empty($_POST['new_account_number']))
) {
    die('All form fields are required.');
}


$itemNumber = $_POST['item_number'];
$description = $_POST['description'];
$unitCost = $_POST['unit_cost'];
$quantity = $_POST['quantity'];
$accountNumber = $_POST['account_number'];
$newAccountNumber = $_POST['new_account_number'];


$stmt = $db->prepare("INSERT INTO Items (item_number, description, unit_cost) VALUES (:itemNumber, :description, :unitCost)");
$stmt->bindValue(':itemNumber', $itemNumber, SQLITE3_TEXT);
$stmt->bindValue(':description', $description, SQLITE3_TEXT);
$stmt->bindValue(':unitCost', $unitCost, SQLITE3_FLOAT);
$result = $stmt->execute();

if (!$result) {
    die("Error inserting item: " . $db->lastErrorMsg());
}

$itemId = $db->lastInsertRowID();


$stmt = $db->prepare("SELECT id FROM Accounts WHERE account_number = :accountNumber");
$stmt->bindValue(':accountNumber', $accountNumber ? $accountNumber : $newAccountNumber, SQLITE3_TEXT);
$result = $stmt->execute();

$row = $result->fetchArray();

if (!$row) {

    $stmt = $db->prepare("INSERT INTO Accounts (account_number) VALUES (:accountNumber)");
    $stmt->bindValue(':accountNumber', $accountNumber ? $accountNumber : $newAccountNumber, SQLITE3_TEXT);
    $result = $stmt->execute();

    if (!$result) {
        die("Error inserting account: " . $db->lastErrorMsg());
    }

    $accountId = $db->lastInsertRowID();
} else {
    $accountId = $row['id'];
}


$stmt = $db->prepare("INSERT INTO PurchaseOrders (account_id) VALUES (:accountId)");
$stmt->bindValue(':accountId', $accountId, SQLITE3_INTEGER);
$result = $stmt->execute();

if (!$result) {
    die("Error inserting purchase order: " . $db->lastErrorMsg());
}

$poId = $db->lastInsertRowID();

$totalCost = $unitCost * $quantity;


$stmt = $db->prepare("INSERT INTO PurchaseOrderItems (po_id, item_id, quantity, total_cost) VALUES (:poId, :itemId, :quantity, :totalCost)");
$stmt->bindValue(':poId', $poId, SQLITE3_INTEGER);
$stmt->bindValue(':itemId', $itemId, SQLITE3_INTEGER);
$stmt->bindValue(':quantity', $quantity, SQLITE3_INTEGER);
$stmt->bindValue(':totalCost', $totalCost, SQLITE3_FLOAT);
$result = $stmt->execute();

if (!$result) {
    die("Error inserting purchase order item: " . $db->lastErrorMsg());
}


$_SESSION['item_number'] = $itemNumber;
$_SESSION['description'] = $description;
$_SESSION['unit_cost'] = $unitCost;
$_SESSION['quantity'] = $quantity;
$_SESSION['account_number'] = $accountNumber ? $accountNumber : $newAccountNumber;

header('Location: confirmation.html');
exit; 
?>
