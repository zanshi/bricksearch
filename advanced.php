<?php require 'header.php';?>

        <main>

        <div class="advSearch">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                <div class="advRow">
                    <label>Cid</label>
                    <input type="text" name="cid" >
                </div>
                <div class="advRow">
                    <label>Cname</label>
                    <input type="text" name="cname">
                </div>
                <div class="advRow">
                    <label>ID</label>
                    <input type="text" name="id">
                </div>
                <div class="advRow">
                    <label>Name</label>
                    <input type="text" name="name">
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
                    <label for="part"><input type="radio" name="advOPT1" value="1" id="part" checked>Part</label>
                    <label for="set"><input type="radio" name="advOPT1" value="0" id="set">Set</label>
                </div>

                <input type="submit" id="searchButton2" value="Search">
            </form>

        </div>

<?php


if ($_SERVER["REQUEST_METHOD"] == "GET" && $con = connect()) {

    $cid = "";
    $cname = "";
    $id = "";
    $name = "";

    $searchOPT = $_GET['advOPT1'];
    $cid = cleanInput($_GET["cid"]);
    $cname = cleanInput($_GET["cname"]);
    $id = cleanInput($_GET["id"]);
    $name = cleanInput($_GET["name"]);

    if ($searchOPT != null || $cid != null || $cname != null || $id != null || $name != null) {
        if (isset($_GET["start"])) {
            $start = cleanInput($_GET["start"]);
            advSearch($con, $start, $searchOPT, $cid, $cname, $id, $name);
        } else {
            advSearch($con, 0, $searchOPT, $cid, $cname, $id, $name);
        }
    }
}
?>


        </main>

<?php require 'footer.php';
