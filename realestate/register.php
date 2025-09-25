<?php
require 'db.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $stmt=$pdo->prepare("INSERT INTO users(name,email,pass_hash) VALUES (?,?,?)");
    $stmt->execute([
      $_POST['name'] ?? '',
      $_POST['email'] ?? '',
      password_hash($_POST['pass'] ?? '', PASSWORD_DEFAULT)
    ]);
    header("Location: login.php?ok=1"); exit;
  } catch(Exception $e){
    $err = "Registration failed (email may already exist).";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register</title>
<style>
  *{box-sizing:border-box;}
  html,body{height:100%;margin:0;}
  body{
    font:16px/1.5 "Segoe UI",Roboto,Arial,sans-serif;
    background:url('images/bg-register.jpg') center/cover no-repeat fixed;
    display:flex;align-items:center;justify-content:center;padding:24px;
    color:#f3f3f3;
  }
  .overlay{position:fixed;inset:0;background:radial-gradient(ellipse at center,rgba(0,0,0,.35),rgba(0,0,0,.65));}
  .card{
    position:relative;width:100%;max-width:420px;padding:28px 24px;
    background:rgba(20,20,20,.55);backdrop-filter:blur(6px);
    border:1px solid rgba(255,255,255,.12);border-radius:14px;
    box-shadow:0 20px 40px rgba(0,0,0,.45);
  }
  h2{text-align:center;margin:0 0 15px;font-size:28px;font-weight:700;}
  .err{
    background:rgba(220,53,69,.25);border:1px solid rgba(220,53,69,.5);
    color:#ffe8ea;padding:10px 12px;border-radius:8px;
    margin:8px 0 14px;font-size:14px;text-align:center;
  }
  input{
    width:100%;padding:12px 14px;margin:8px 0;
    border:1px solid rgba(255,255,255,.25);border-radius:10px;
    background:rgba(255,255,255,.15);color:#fff;font-size:16px;
  }
  input::placeholder{color:#e6e6e6;}
  button{
    width:100%;padding:12px 14px;margin-top:10px;border:none;border-radius:10px;
    background:linear-gradient(180deg,#ffb74d,#ff9800);color:#1b1b1b;
    font-weight:700;font-size:16px;cursor:pointer;
    box-shadow:0 8px 18px rgba(255,152,0,.35);transition:.2s;
  }
  button:hover{filter:brightness(1.05);}
  .hint{text-align:center;margin-top:12px;}
  .hint a{color:#ffd275;text-decoration:none;font-weight:600;}
  .hint a:hover{text-decoration:underline;}
</style>
</head>
<body>
  <div class="overlay"></div>
  <div class="card">
    <h2>Create Account</h2>
    <?php if(!empty($err)): ?><div class="err"><?=htmlspecialchars($err)?></div><?php endif; ?>

    <form method="post" id="regForm" autocomplete="off">
      <input id="name"  name="name"  placeholder="Full name" required />
      <input id="email" name="email" type="email" placeholder="Email" required />
      <input id="pass"  name="pass"  type="password" placeholder="Password" required />
      <div id="msg" class="err" style="display:none;"></div>
      <button>Register</button>
    </form>

    <div class="hint"><a href="login.php">Have an account? Login</a></div>
  </div>

<script>
(function(){
  const f = document.getElementById('regForm');
  const name = document.getElementById('name');
  const email = document.getElementById('email');
  const pass = document.getElementById('pass');
  const msg  = document.getElementById('msg');

  const emailOK = v => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v);

  f.addEventListener('submit', function(e){
    msg.style.display = 'none';
    [name,email,pass].forEach(i=>i.style.borderColor='rgba(255,255,255,.25)');
    let errs = [];

    if(name.value.trim().length < 2){
      errs.push("Name too short");
      name.style.borderColor = "#ff6b6b";
    }
    if(!emailOK(email.value.trim())){
      errs.push("Invalid email");
      email.style.borderColor = "#ff6b6b";
    }
    if(pass.value.length < 6){
      errs.push("Password must be at least 6 characters");
      pass.style.borderColor = "#ff6b6b";
    }

    if(errs.length){
      e.preventDefault();
      msg.textContent = errs.join(" • ");
      msg.style.display = "block";
    }
  });
})();
</script>
</body>
</html>
