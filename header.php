
<head>
<link rel="stylesheet" href="styles.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<header>
    <div id="mainhead" class="col-sm-12">
        <div class="container header-container">
            <div class="col-sm-9 title"><h1>Epignosis Portal</h1></div>
            <div id="logout" class="col-sm-3">
                <?php 
                $url = $_SERVER['REQUEST_URI'];
                if($url != "/epignosis_portal/index.php" &&
                    $url != "/epignosis_portal/" ){?>
                    <a href="/epignosis_portal/logout.php">Logout</a>
                <?php }?>
        </div>
    </div>
</header>
<div class="container body-wrapper">
    
