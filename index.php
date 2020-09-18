<title> Login</title>
<link rel="stylesheet" type="text/css" href="usr_style.css" />
</head>
<body>
<!-- Form for logging in the users -->
<?php require_once 'login.php'; ?>

<div class="register-form">

<p>Please login to continue</p>

<h1>Login</h1>
<form action="" method="POST">
    <p><label>User Name : </label>
    <input id="username" type="text" name="username" required placeholder="username" /></p>

     <p><label>Password&nbsp;&nbsp; : </label>
     <input id="password" type="password" name="password" required placeholder="password" /></p>

    <input class="btn" type="submit" name="submit" value="Login" />
    </form>
</div>
</body>
</html>