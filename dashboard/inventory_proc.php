<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// ADD ITEM
if (isset($_POST['add_item'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $quantity = (int)$_POST['quantity'];
    $reorder = (int)$_POST['reorder_level'];
    $cost = (float)$_POST['cost'];

    $stmt = $conn->prepare("INSERT INTO inventory (name, category, quantity, reorder_level, cost_per_unit, supplier) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiids", $name, $category, $quantity, $reorder, $cost, $supplier);
    $stmt->execute();
    header("Location: inventory.php?msg=added");
    exit();
}

// UPDATE ITEM
if (isset($_POST['update_item'])) {
    $id = (int)$_POST['item_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $quantity = (int)$_POST['quantity'];
    $reorder = (int)$_POST['reorder_level'];
    $cost = (float)$_POST['cost'];

    $stmt = $conn->prepare("UPDATE inventory SET name=?, category=?, quantity=?, reorder_level=?, cost_per_unit=?, supplier=? WHERE id=?");
    $stmt->bind_param("ssiidsi", $name, $category, $quantity, $reorder, $cost, $supplier, $id);
    $stmt->execute();
    header("Location: inventory.php?msg=updated");
    exit();
}

// DELETE ITEM
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM inventory WHERE id = $id");
    header("Location: inventory.php?msg=deleted");
    exit();
}