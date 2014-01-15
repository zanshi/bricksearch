<?php require 'header.php';?>

        <main>

        <div class="advSearch">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="advSearchForm" method="get">
                <div class="advRow">
                    <label>Year</label>
                    <input type="text" name="year" placeholder="Search a year" value="<?php echo $year; ?>">
                </div>
                <div class="advRow">
                    <label>Category</label>
                    <input type="text" name="cname" placeholder="Search for a category" value="<?php echo $cname; ?>">
                </div>
                <div class="advRow">
                    <label>ID</label>
                    <input type="text" name="id" placeholder="Search for an id" value="<?php echo $id; ?>">
                </div>
                <div class="advRow">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Search for a set name" value="<?php echo $name; ?>">
                </div>
<!--
                <div class="advRow">
                    <label>Item ID</label>
                    <input type="text" name="quantity">
                </div>
                <div class="advRow">
                    <label>Quantity</label>
                    <input type="text" name="quantity">
                </div>
                <div class="advRow">
                    <label>Partname</label>
                    <input type="text" name="quantity">
                </div>
                <div class="advRow">
                    <label>Itemtype</label>
                    <input type="text" name="quantity">
                </div>
                <div class="advRow">
                    <label>Color</label>
                    <input type="text" name="quantity">
                </div>
                <div class="advRow">
                    <label>Minifig</label>
                    <input type="text" name="minifig">
                </div>
-->
                <div class="advRow">
                    <label>Select</label>
                    <label for="part"><input type="radio" name="advOPT1" value="parts" id="part" disabled>Part</label>
                    <label for="set"><input type="radio" name="advOPT1" value="sets" id="set" checked>Set</label>
                </div>

                <!-- <button type="submit" class="button" id="searchButton2"> -->
            </form>
            <input type="submit" form="advSearchForm" class="button" id="searchButton2" value="Search">

        </div>

<?php

if (count($_GET) > 0 && $con = connect()) {

    if (isset($_GET["advOPT1"])) {
        if ($_GET['advOPT1'] == "sets") {
            $searchOPT = $_GET['advOPT1'];
        }
    }
    if (isset($_GET["year"])) {
        if (validate($_GET["year"])) {
            $year = cleanInput($_GET["year"]);
        }
    }
    if (isset($_GET["cname"])) {
        if (validate($_GET["cname"])) {
            $cname = cleanInput($_GET["cname"]);
        }
    }
    if (isset($_GET["id"])) {
        if (validate($_GET["id"])) {
            $id = cleanInput($_GET["id"]);
        }
    }
    if (isset($_GET["name"])) {
        if (validate($_GET["name"])) {
            $name = cleanInput($_GET["name"]);
        }
    }
    if ($year != "" || $cname != "" || $id != "" || $name != "") {
        if (isset($_GET["start"])) {
            if (validateStart($_GET["start"])) {
                $start = cleanInput($_GET["start"]);
                advSearch($con, $start, $searchOPT, $year, $cname, $id, $name);
            }
        } else {
            advSearch($con, 0, $searchOPT, $year, $cname, $id, $name);
        }
    }
}
?>

        </main>

<?php require 'footer.php';
