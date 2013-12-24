<p>Use this "<strong>Login Email Password</strong>" to sign in to <?=$COMPANY_URL?></p>
<p>
Login: <?=$compact['username']?><br>
Login Email Password: <strong style="font-size:24px;font-weight:bold "><?=$compact['oneCode']?></strong><br>
IP: <?=$_SERVER['REMOTE_ADDR'];?><br>
Date and time: <?=gmdate('Y-m-d H:i:s',time())?>
</p>