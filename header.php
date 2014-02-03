<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<?php
    require 'functions.php';
    $searchterm = "";
    $searchOPT = "sets";
    $year = "";
    $cname = "";
    $id = "";
    $name = "";
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
    <link rel="shortcut icon" href="img/favicon.ico" />
    <!--Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
    <!--CSS-->
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!--Icons for Apple/Android-->
    <link rel="apple-touch-icon" href="img/touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/touch-icon-ipad-retina.png">
    <link rel="shortcut icon" sizes="196x196" href="img/nice-highres.png">

    <script async src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

    <script async>
        function loadExtended(parent)
        {
            var setID = parent.children[1].children[1].innerHTML;

            console.log(setID);

            if (parent.nextSibling.className == "row extendedResults") {
                $( parent.nextSibling ).toggle();
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
                <li><a href="index.php" class="button">Home</a></li>
                <li><a href="advanced.php" class="button">Advanced search</a></li>
                <li><a href="comment.php" class="button">Comment</a></li>
            </ul>
        </nav>
