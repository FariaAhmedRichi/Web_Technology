<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>
<style>
  *{box-sizing:border-box;}
  html,body{height:100%;margin:0}
  body{
    font:16px/1.5 "Segoe UI",Roboto,Arial,sans-serif;
    background:url('images/bg-dashboard.jpg') center/cover no-repeat fixed;
    display:flex;align-items:center;justify-content:center;
    padding:20px;
  }
  .overlay{
    position:fixed;inset:0;
    background:rgba(0,0,0,.45);
  }
  .card{
    position:relative;
    background:rgba(255,255,255,.85);
    border-radius:14px;
    padding:30px 40px;
    max-width:500px;width:100%;
    box-shadow:0 10px 25px rgba(0,0,0,.35);
    text-align:center;
  }
  h3{
    margin-top:0;margin-bottom:15px;
    font-size:28px;font-weight:700;
    color:#222;
  }
  p a{
    display:inline-block;
    margin:8px;
    padding:12px 22px;
    border-radius:8px;
    background:#2196f3;
    color:white;text-decoration:none;
    font-weight:600;
    transition:.25s;
  }
  p a:hover{background:#0b7dda}
</style>
</head>
<body>
  <div class="overlay"></div>
  <div class="card">
    <h3>Welcome, <?=htmlspecialchars($user['name'])?></h3>
    <p>
      <a href="search.php">🔎 Search Properties</a>
      <a href="my_bookings.php">📑 My Bookings</a>
      <a href="logout.php">🚪 Logout</a>
    </p>
  </div>
</body>
</html>
