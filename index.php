
<?php require 'header.php';?>

<main>

    <div class="mainSearch">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
            <input type="text" name="searchterm" placeholder="Search for name or ID of a Lego set" class="searchField" value="<?php echo $searchterm; ?>">
            <input type="submit" id="searchButton" value="">
        </form>

    </div>

<?php
/*if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["searchterm"])) {
        $searchterm = validate($_GET["searchterm"]);

        if (!empty($_GET["start"])) {
            $start = validate($_GET["start"]);
            advSearch(connect(), $start, 2, "", "", "", $searchterm);
        } else {
            advSearch(connect(), 0, 2, "", "", "", $searchterm);
        }
    }

}*/

if (count($_GET) > 0 && $con = connect()) {
    if (isset($_GET["searchterm"])) {
        if (validate($_GET["searchterm"])) {
            $searchterm = cleanInput($_GET["searchterm"]);

            if (isset($_GET["start"])) {
                $start = $_GET["start"];
                if (validateStart($start)) {
                    //mainSearch($con, $searchterm, $start);
                    advSearch($con, $start, 'main', "", "", "", $searchterm);
                }
            } else {
                //mainSearch($con, $searchterm, 0);
                advSearch($con, 0, 'main', "", "", "", $searchterm);
            }
        }

    }
}

?>

</main>

<?php require 'footer.php';
