
<?php
    require 'functions.php';
    require 'header.php';
?>

        <main>

            <div class="mainSearch">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    <input type="text" name="searchterm" placeholder="Search for name or ID of a Lego set" class="searchField" value="<?php echo $searchterm; ?>"></input>
                    <input type="submit" id="searchButton" value=""></input>
                </form>

            </div>

<?php
/*if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["searchterm"])) {
        $searchterm = validate($_GET["searchterm"]);

        if (!empty($_GET["start"])) {
            $start = validate($_GET["start"]);
            mainSearch(connect(), $searchterm, $start);
        } else {
            mainSearch(connect(), $searchterm, 0);
        }
    }

}*/

if (isset($_GET["searchterm"])) {
    if (validate($_GET["searchterm"])) {
        $searchterm = cleanInput($_GET["searchterm"]);

        if (isset($_GET["start"])) {
            $start = $_GET["start"];
            if (validateStart($start)) {
                mainSearch(connect(), $searchterm, $start);
            }
        } else {
            mainSearch(connect(), $searchterm, 0);
        }
    }

}

?>

        </main>

<?php require 'footer.php';
