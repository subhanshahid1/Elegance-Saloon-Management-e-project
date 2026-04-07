<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// 1. ADD ITEM
if (isset($_POST['add_item'])) {
    $name = $conn->real_escape_string($_POST['item_name']);
    $cat  = $conn->real_escape_string($_POST['category']);
    $qty  = (int)$_POST['quantity'];
    $cost = (float)$_POST['cost_price'];
    $min  = (int)$_POST['min_level'];
    $sid  = !empty($_POST['supplier_id']) ? (int)$_POST['supplier_id'] : "NULL";

    $sql = "INSERT INTO inventory (item_name, category, quantity, cost_price, min_stock_level, supplier_id) 
            VALUES ('$name', '$cat', $qty, $cost, $min, $sid)";
    
    $conn->query($sql);
    header("Location: inventory.php?msg=added");
    exit();
}

// 2. UPDATE ITEM
if (isset($_POST['update_item'])) {
    $id   = (int)$_POST['item_id'];
    $name = $conn->real_escape_string($_POST['item_name']);
    $qty  = (int)$_POST['quantity'];
    $cost = (float)$_POST['cost_price'];
    $min  = (int)$_POST['min_level'];
    $sid  = !empty($_POST['supplier_id']) ? (int)$_POST['supplier_id'] : "NULL";

    $sql = "UPDATE inventory SET 
            item_name='$name', quantity=$qty, cost_price=$cost, 
            min_stock_level=$min, supplier_id=$sid 
            WHERE id=$id";
    
    $conn->query($sql);
    header("Location: inventory.php?msg=updated");
    exit();
}

// 3. DELETE ITEM
if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    $conn->query("DELETE FROM inventory WHERE id=$id");
    header("Location: inventory.php?msg=deleted");
    exit();
}