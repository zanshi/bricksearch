<?php require 'header.php';?>

        <main>

         <div class="mainSearch">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    <div class="advRow">
                        <label>SetID</label>
                        <input type="text" name="setid" >
                    </div>
                    <div class="advRow">
                        <label>SetName</label>
                        <input type="text" name="setname">
                    </div>
                    <div class="advRow">
                        <label>Year</label>
                        <input type="text" name="year">
                    </div>
                    <div class="advRow">
                        <label>Category</label>
                        <input type="text" name="catname">
                    </div>
                    <div class="advRow">
                        <label>Item ID</label>
                        <input type="text" name="itemid">
                    </div>
                    <div class="advRow">
                        <label>Quantity</label>
                        <input type="text" name="quantity">
                    </div>
                    <div class="advRow">
                        <label>Partname</label>
                        <input type="text" name="partname">
                    </div>
                    <div class="advRow">
                        <label>Itemtype</label>
                        <input type="text" name="itemtype">
                    </div>
                    <div class="advRow">
                        <label>Color</label>
                        <input type="text" name="colorname">
                    </div>
                    <div class="advRow">
                        <label>Minifig</label>
                        <input type="text" name="minifig">
                    </div>
                    <div class="advRow">
                        <label>Select</label>
                        <label for="part"><input type="radio" name="advOPT1" value="1" id="part" checked>Part</label>
                        <label for="set"><input type="radio" name="advOPT1" value="0" id="set">Set</label>
                    </div>

                    <input type="submit" id="searchButton2" value="Search"></input>
                </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

/*    if(isset($searchOPT = $_POST['advOPT1'];
*/
    if (!empty($_GET["setid"])) {
        $searchterms['setid'] = cleanInput($_GET["setid"]);
    }
    if (!empty($_GET["setname"])) {
        $searchterms['setname'] = cleanInput($_GET["setname"]);
    }
    if (!empty($_GET["year"])) {
        $searchterms['year'] = cleanInput($_GET["year"]);
    }
    if (!empty($_GET["catname"])) {
        $searchterms['catname'] = cleanInput($_GET["catname"]);
    }
    if (!empty($_GET["itemid"])) {
        $searchterms['itemid'] = cleanInput($_GET["itemid"]);
    }
    if (!empty($_GET["quantity"])) {
        $searchterms['quantity'] = cleanInput($_GET["quantity"]);
    }
    if (!empty($_GET["partname"])) {
        $searchterms['partname'] = cleanInput($_GET["partname"]);
    }
    if (!empty($_GET["itemtype"])) {
        $searchterms['itemtype'] = cleanInput($_GET["itemtype"]);
    }
    if (!empty($_GET["colorname"])) {
        $searchterms['colorname'] = cleanInput($_GET["colorname"]);
    }
    if (!empty($_GET["minifig"])) {
        $searchterms['minifig'] = cleanInput($_GET["minifig"]);
    }
    if (!empty($_GET["start"])) {
        $start = cleanInput($_GET["start"]);
//        advSearch(connect(), $searchterms, $start, $searchOPT);
    } else {
//        advSearch(connect(), $searchterms, 0, $searchOPT);
    }
}
?>

        </main>

<?php require 'footer.php';
