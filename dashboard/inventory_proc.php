<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// UPDATE ITEM
if (isset($_POST['btn_update'])) {
    $id = (int)$_POST['upd_id'];
    $name = $conn->real_escape_string($_POST['upd_name']);
    $qty = (int)$_POST['upd_qty'];
    $cost = (float)$_POST['upd_cost'];
    $reorder = (int)$_POST['upd_reorder'];

    $sql = "UPDATE inventory SET name='$name', quantity=$qty, cost_per_unit=$cost, reorder_level=$reorder WHERE id=$id";
    $conn->query($sql);
    header("Location: inventory.php?msg=updated");
    exit();
}

// DELETE ITEM
if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    $conn->query("DELETE FROM inventory WHERE id = $id");
    header("Location: inventory.php?msg=deleted");
    exit();
}