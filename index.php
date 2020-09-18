<title> Login</title>
<link rel="stylesheet" type="text/css" href="usr_style.css" />
</head>
<body>
<!-- Form for logging in the users -->

<div class="register-form">

<p>Please login to continue</p>

<h1>Login</h1>
<form action="login.php" method="POST">
    <p><label>User Name : </label>
    <input id="username" type="text" name="username" required placeholder="username" /></p>

     <p><label>Password&nbsp;&nbsp; : </label>
     <input id="password" type="password" name="password" required placeholder="password" /></p>

    <a class="btn" href="register.php">Register</a>
    <input class="btn" type="submit" name="submit" value="Login" />
    </form>
</div>
</body>
</html>