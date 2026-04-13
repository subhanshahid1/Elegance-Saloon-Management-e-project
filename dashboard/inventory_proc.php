<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Check access
checkAccess(['admin', 'receptionist']);

/* HELPER LOGIC: Notify all staff (Admins/Receptionists) about inventory issues */
function notifyStaffInventory($conn, $name, $qty) {
    // Find all users who are either admins or receptionists
    $staff_query = $conn->query("SELECT id FROM users WHERE role IN ('admin', 'receptionist')");
    $msg = "Low Stock Alert: '$name' has only $qty units left.";
    
    while($staff = $staff_query->fetch_assoc()) {
        notifyUser($conn, $staff['id'], "Inventory Alert", $msg, "inventory", "inventory.php");
    }
}

// HANDLE ADD NEW ITEM 
if (isset($_POST['btn_save'])) {
    $name = $_POST['ins_name'];
    $category = $_POST['ins_category'];
    $qty = $_POST['ins_qty'];
    $cost = $_POST['ins_cost'];
    $reorder = $_POST['ins_reorder'];
    $supplier = !empty($_POST['ins_supplier']) ? $_POST['ins_supplier'] : NULL;

    $stmt = $conn->prepare("INSERT INTO inventory (name, category, quantity, cost_per_unit, reorder_level, supplier_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiddi", $name, $category, $qty, $cost, $reorder, $supplier);

    if ($stmt->execute()) {
        // Trigger notification if added item is already low stock
        if ($qty <= $reorder) {
            notifyStaffInventory($conn, $name, $qty);
        }
        header("Location: inventory.php?msg=added");
    } else {
        echo "Error: " . $conn->error;
    }
    exit();
}

// HANDLE UPDATE ITEM
if (isset($_POST['btn_update'])) {
    $id = $_POST['upd_id'];
    $name = $_POST['upd_name'];
    $qty = $_POST['upd_qty'];
    $cost = $_POST['upd_cost'];
    $reorder = $_POST['upd_reorder'];

    $stmt = $conn->prepare("UPDATE inventory SET name=?, quantity=?, cost_per_unit=?, reorder_level=? WHERE id=?");
    $stmt->bind_param("sidii", $name, $qty, $cost, $reorder, $id);

    if ($stmt->execute()) {
        // Trigger notification for all staff if quantity drops below reorder level
        if ($qty <= $reorder) {
            notifyStaffInventory($conn, $name, $qty);
        }

        header("Location: inventory.php?msg=updated");
    } else {
        echo "Error: " . $conn->error;
    }
    exit();
}

// HANDLE DELETE ITEM
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    
    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: inventory.php?msg=deleted");
    } else {
        echo "Error: " . $conn->error;
    }
    exit();
}

// If someone tries to access this file directly without posting data
header("Location: inventory.php");
exit();