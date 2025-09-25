<?php require 'auth.php';
$s=$pdo->prepare("SELECT b.id, p.title, p.city, p.type, b.booked_at, p.photo
                  FROM bookings b JOIN properties p ON p.id=b.property_id
                  WHERE b.user_id=? ORDER BY b.booked_at DESC");
$s->execute([$user['id']]);
$rows=$s->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Bookings</title>
<style>
  *{box-sizing:border-box;}
  html,body{height:100%;margin:0;}
  body{
    font:16px/1.5 "Segoe UI",Roboto,Arial,sans-serif;
    background:url('images/bg-bookings.jpg') center/cover no-repeat fixed;
    padding:20px;
    color:#fff;
  }
  .overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);}
  .container{position:relative;max-width:1000px;margin:auto;z-index:1;}
  h2{text-align:center;font-size:28px;font-weight:700;margin-top:0;margin-bottom:20px;}
  .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;}
  .card{
    background:rgba(255,255,255,.9);
    color:#222;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,.3);
  }
  .card img{width:100%;height:160px;object-fit:cover;}
  .card-content{padding:15px;}
  .card-content h3{margin:0 0 8px;font-size:20px;}
  .card-content p{margin:4px 0;font-size:14px;}
  .back{margin-top:25px;text-align:center;}
  .back a{color:#ffd275;text-decoration:none;font-weight:600;}
  .back a:hover{text-decoration:underline;}
</style>
</head>
<body>
  <div class="overlay"></div>
  <div class="container">
    <h2>My Bookings</h2>
    <div class="cards">
      <?php foreach($rows as $r): ?>
      <div class="card">
        <?php if(!empty($r['photo'])): ?>
          <img src="<?=htmlspecialchars($r['photo'])?>" alt="Property">
        <?php endif; ?>
        <div class="card-content">
          <h3><?=htmlspecialchars($r['title'])?></h3>
          <p>Type: <?=$r['type']?></p>
          <p>City: <?=$r['city']?></p>
          <p>Booked at: <?=$r['booked_at']?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="back"><a href="dashboard.php">⬅ Back to Dashboard</a></div>
  </div>
</body>
</html>
