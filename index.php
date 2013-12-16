<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <?php
        $searchterm = "";
        require 'header.php';
    ?>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link href='http://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Patua+One">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-2.0.3.js"></script>
  


</head>

<body>

    <div id="container">

        <header>
            <h1>Brick Search</h1>
        </header>

        <nav>
            <ul>
                <li><a href="index.php" class="nav">Home</a></li>
                <li><a href="advanced.php" class="nav">Advanced search</a></li>
            </ul>
        </nav>

        <main>

            <div id="mainSearch">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    <input type="text" name="searchterm" placeholder="Search for name or ID" class="searchField" value="<?php echo $searchterm; ?>"></input>
                    <input type="submit" id="searchButton" value=""></input>
                </form>

            </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["searchterm"])) {
        $searchterm = validate($_GET["searchterm"]);
        mainSearch(connect(), $searchterm);
    }
    
}
?>

        </main>

        <footer>
            <p>© 2013 BrickSearch</p>
        </footer>

    </div>
      <script src="js/script.js"></script>
      <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46498801-1', 'bricksearch.se');
  ga('send', 'pageview');
</script>
</body>

</html>
