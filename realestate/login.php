<?php
require 'db.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $s=$pdo->prepare("SELECT * FROM users WHERE email=?");
  $s->execute([$_POST['email'] ?? '']);
  $u=$s->fetch(PDO::FETCH_ASSOC);

  if($u && password_verify($_POST['pass'] ?? '', $u['pass_hash'])){
    $_SESSION['user']=$u;
    header("Location: dashboard.php"); exit;
  } else {
    $err="Wrong email or password.";
  }
}
$justReg = isset($_GET['ok']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<style>
  *{box-sizing:border-box;} html,body{height:100%;margin:0;}
  body{
    font:16px/1.5 "Segoe UI",Roboto,Arial,sans-serif;
    background:url('images/bg-login.jpg') center/cover no-repeat fixed;
    display:flex;align-items:center;justify-content:center;padding:24px;
    color:#f3f3f3;
  }
  .overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);}
  .card{
    position:relative;width:100%;max-width:420px;padding:28px 24px;
    background:rgba(20,20,20,.55);backdrop-filter:blur(6px);
    border-radius:14px;box-shadow:0 20px 40px rgba(0,0,0,.45);
  }
  h2{text-align:center;margin:0 0 15px;font-size:28px;font-weight:700;}
  .note,.err{
    padding:10px 12px;border-radius:8px;margin:8px 0 14px;
    font-size:14px;text-align:center;
  }
  .note{background:rgba(40,167,69,.25);border:1px solid rgba(40,167,69,.5);color:#d7ffe2;}
  .err{background:rgba(220,53,69,.25);border:1px solid rgba(220,53,69,.5);color:#ffe8ea;display:none;}
  input,button{width:100%;padding:12px 14px;margin:8px 0;border-radius:10px;font-size:16px;}
  input{border:1px solid rgba(255,255,255,.25);background:rgba(255,255,255,.15);color:#fff;}
  input::placeholder{color:#e6e6e6;}
  button{
    border:none;background:linear-gradient(180deg,#ffd275,#f2b84a);
    color:#1b1b1b;font-weight:700;cursor:pointer;box-shadow:0 8px 18px rgba(242,184,74,.35);
  }
  button:hover{filter:brightness(1.05);}
  .hint{text-align:center;margin-top:12px;}
  .hint a{color:#ffd275;text-decoration:none;font-weight:600;}
</style>
</head>
<body>
  <div class="overlay"></div>
  <div class="card">
    <h2>Sign In</h2>
    <?php if($justReg): ?><div class="note">Registered successfully. Please log in.</div><?php endif; ?>
    <?php if(!empty($err)): ?><div class="err" id="serverErr"><?=htmlspecialchars($err)?></div><?php endif; ?>

    <form method="post" id="loginForm" autocomplete="off">
      <input id="email" name="email" type="email" placeholder="Email" required />
      <input id="pass"  name="pass"  type="password" placeholder="Password" required />
      <div class="err" id="msg"></div>
      <button>Login</button>
    </form>

    <div class="hint"><a href="register.php">Create a new account</a></div>
  </div>

<script>
(function(){
  const f=document.getElementById('loginForm');
  const email=document.getElementById('email');
  const pass=document.getElementById('pass');
  const msg=document.getElementById('msg');
  const emailOK=v=>/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v);

  f.addEventListener('submit',function(e){
    msg.style.display='none'; msg.textContent='';
    email.style.borderColor='rgba(255,255,255,.25)';
    pass.style.borderColor='rgba(255,255,255,.25)';

    let errs=[];
    if(!emailOK(email.value.trim())){errs.push("Invalid email");email.style.borderColor="#ff6b6b";}
    if(pass.value.length<6){errs.push("Password must be at least 6 chars");pass.style.borderColor="#ff6b6b";}

    if(errs.length){
      e.preventDefault();
      msg.textContent=errs.join(" • ");
      msg.style.display='block';
    }
  });
})();
</script>
</body>
</html>
