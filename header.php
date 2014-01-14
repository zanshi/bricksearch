<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?php

        $searchterm = "";
        if (isset($_GET["searchterm"])) {
            if (validate($_GET["searchterm"])) {
                $searchterm = cleanInput($_GET["searchterm"]);
                printTitle($searchterm);
            }
        } else {
            printTitle(null);
        }
    ?>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="favicon2.png" />
    <!--Fonts-->
    <link href='http://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Patua+One">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
    <!--CSS-->
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!--Icons for Apple/Android-->
    <link rel="apple-touch-icon" href="touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
    <link rel="shortcut icon" sizes="196x196" href="nice-highres.png">
    <!--Splash Screen iOS-->
    <link href="assets/splashs/splash_1096.png" rel="apple-touch-startup-image" media="(device-height: 568px)">
    <link href="assets/splashs/splash_iphone_2x.png" rel="apple-touch-startup-image" sizes="640x960" media="(device-height: 480px)">
   <!-- Prevent the webapp to change window while user click links-->
    <script type="text/javascript">

        (function (a,b,c) {if (c in b&&b[c]) {var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function (a) {d=a.target;
            while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},
            !1)}})(document,window.navigator,"standalone")

    </script>

    <script src="js/jquery-2.0.3.js"></script>

    <script>

        function loadExtended(parent)
        {
            var setID = parent.children[1].children[1].innerHTML;

            console.log(setID);

            if (parent.nextSibling.className == "row extendedResults") {
                parent.nextSibling.remove();
            } else {
                $.get("extended.php", { id: setID })
                    .done(function (data) {
                        $(parent).after(data);
                        console.log("success");
                    });
            }

        }

    </script>

</head>

<body>

    <!--Google Analytics-->
    <?php include_once("analyticstracking.php") ?>

    <div id="container">

        <header>
            <h1>Brick Search</h1>
        </header>

        <nav>
            <ul>
                <li><a href="index.php" class="nav">Home</a></li>
                <li><a href="advanced.php" class="nav">Advanced search</a></li>
                 <li><a href="about.php" class="nav">About</a></li>
            </ul>
        </nav>
