<?php require 'auth.php';
$type = $_GET['type'] ?? '';
$city = $_GET['city'] ?? '';

$q="SELECT * FROM properties WHERE available=1";
$params=[];
if($type){ $q.=" AND type=?"; $params[]=$type; }
if($city){ $q.=" AND city LIKE ?"; $params[]="%$city%"; }

$stmt=$pdo->prepare($q);
$stmt->execute($params);
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Search Properties</title>
<style>
  *{box-sizing:border-box;}
  html,body{height:100%;margin:0;}
  body{
    font:16px/1.5 "Segoe UI",Roboto,Arial,sans-serif;
    background:url('images/bg-search.jpg') center/cover no-repeat fixed;
    padding:20px;
    color:#fff;
  }
  .overlay{
    position:fixed;inset:0;
    background:rgba(0,0,0,.45);
  }
  .container{
    position:relative;
    max-width:1000px;
    margin:auto;
    z-index:1;
  }
  h2{margin-top:0;text-align:center;font-size:28px;font-weight:700;}
  form{
    background:rgba(255,255,255,.15);
    backdrop-filter:blur(6px);
    padding:15px;
    border-radius:10px;
    display:flex;gap:10px;
    justify-content:center;
    margin-bottom:20px;
  }
  select,input,button{
    padding:10px;
    border-radius:6px;
    border:none;
    font-size:15px;
  }
  select,input{flex:1;min-width:120px;}
  button{
    background:#2196f3;
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:.25s;
  }
  button:hover{background:#0b7dda;}
  .cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:20px;
  }
  .card{
    background:rgba(255,255,255,.9);
    color:#222;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,.3);
  }
  .card img{width:100%;height:180px;object-fit:cover;}
  .card-content{padding:15px;}
  .card-content h3{margin:0 0 8px;font-size:20px;}
  .card-content p{margin:4px 0;}
  .card-content a{
    display:inline-block;margin-top:10px;
    background:#ff9800;color:white;
    padding:8px 14px;border-radius:6px;
    text-decoration:none;font-weight:600;
    transition:.25s;
  }
  .card-content a:hover{background:#e68900;}
  .back{margin-top:20px;text-align:center;}
  .back a{color:#ffd275;text-decoration:none;font-weight:600;}
</style>
</head>
<body>
  <div class="overlay"></div>
  <div class="container">
    <h2>Search Properties</h2>
    <form>
      <select name="type">
        <option value="">Any Type</option>
        <option <?=$type=='Apartment'?'selected':''?>>Apartment</option>
        <option <?=$type=='House'?'selected':''?>>House</option>
        <option <?=$type=='Land'?'selected':''?>>Land</option>
      </select>
      <input name="city" placeholder="City" value="<?=htmlspecialchars($city)?>">
      <button>Search</button>
    </form>

    <div class="cards">
      <?php foreach($rows as $r): ?>
      <div class="card">
        <?php if(!empty($r['photo'])): ?>
          <img src="<?=htmlspecialchars($r['photo'])?>" alt="Property">
        <?php endif; ?>
        <div class="card-content">
          <h3><?=htmlspecialchars($r['title'])?></h3>
          <p>Type: <?=$r['type']?></p>
          <p>Price: Tk <?=$r['price']?></p>
          <p>City: <?=$r['city']?></p>
          <a href="book.php?id=<?=$r['id']?>">Book</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="back"><a href="dashboard.php">⬅ Back to Dashboard</a></div>
  </div>
</body>
</html>
