<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        $searchterm = "";
        require 'header.php';
    ?>
    <link rel="shortcut icon" type="image/x-icon" href="favicon2.png" />
    <link href='http://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Patua+One">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-2.0.3.js"></script>

    <script>

        function loadExtended(parent) {

            var setID = parent.children[1].children[1].innerHTML;

            console.log(setID);

            //$ (parent).append( "extended.php?id=" + setID);

/*            var request = $.ajax({
                url: 'extended.php',
                type: 'GET',
                dataType: 'html',
                context: parent,
                data: {id: setID},
            })
            .done(function() {

                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });*/

/*            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var content = document.createTextNode(xmlhttp.responseText);
                    parent.appendChild(content);
                }
            }
            xmlhttp.open("GET","extended.php?id="+setID, true);
            xmlhttp.send();*/

            if(parent.children[2]) {
                //parent.children[2]
            }

            console.log(parent.innerHTML);

            $.get("extended.php", { id: setID })
                .done(function (data) {
                    $(parent).after(data);
                    console.log("success");
                });



            
        }

    </script>
  


</head>

<body>

    <?php include_once("analyticstracking.php") ?>

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

            <div class="mainSearch">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    <input type="text" name="searchterm" placeholder="Search for name or ID of a Lego set" class="searchField" value="<?php echo $searchterm; ?>"></input>
                    <input type="submit" id="searchButton" value=""></input>
                </form>

            </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["searchterm"])) {
        $searchterm = validate($_GET["searchterm"]);

        if(!empty($_GET["start"])) {
            $start = validate($_GET["start"]);
            mainSearch(connect(), $searchterm, $start);
        } else {
            mainSearch(connect(), $searchterm, 0);
        }
    }
    
}

?>

        </main>

        <footer>
            <p>© 2013 BrickSearch</p>
        </footer>

    </div>
      <script src="js/script.js"></script>
</body>

</html>
