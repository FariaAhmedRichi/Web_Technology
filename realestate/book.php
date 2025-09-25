<?php require 'auth.php';

$id = intval($_GET['id'] ?? 0);

// start a safe transaction
$pdo->beginTransaction();

// check if property is available
$chk = $pdo->prepare("SELECT id, available FROM properties WHERE id=? FOR UPDATE");
$chk->execute([$id]);
$p = $chk->fetch(PDO::FETCH_ASSOC);

if(!$p || !$p['available']) {
  $pdo->rollBack();
  die("Not available.");
}

// insert booking
$ins = $pdo->prepare("INSERT INTO bookings(user_id, property_id) VALUES (?,?)");
$ins->execute([$user['id'],$id]);

// mark property unavailable
$upd = $pdo->prepare("UPDATE properties SET available=0 WHERE id=?");
$upd->execute([$id]);

$pdo->commit();

// redirect to booking list
header("Location: my_bookings.php");
exit;
