<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <?php
        $searchterm = "";
        include 'header.php';
    ?>

    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Patua+One">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

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
                 <li><a href="about.php" class="nav">About</a></li>
            </ul>
        </nav>

        <main>

		 <div id="mainSearch">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $searchOPT = $_POST['advOPT1'];

    if (!empty($_POST["setid"])) {
        $searchterms['setid'] = validate($_POST["setid"]);        
    }
    if (!empty($_POST["setname"])) {
        $searchterms['setname'] = validate($_POST["setname"]);        
    }
    if (!empty($_POST["year"])) {
        $searchterms['year'] = validate($_POST["year"]);        
    }
    if (!empty($_POST["catname"])) {
        $searchterms['catname'] = validate($_POST["catname"]);        
    }
    if (!empty($_POST["itemid"])) {
        $searchterms['itemid'] = validate($_POST["itemid"]);        
    }
    if (!empty($_POST["quantity"])) {
        $searchterms['quantity'] = validate($_POST["quantity"]);        
    }
    if (!empty($_POST["partname"])) {
        $searchterms['partname'] = validate($_POST["partname"]);        
    }
    if (!empty($_POST["itemtype"])) {
        $searchterms['itemtype'] = validate($_POST["itemtype"]);        
    }
    if (!empty($_POST["colorname"])) {
        $searchterms['colorname'] = validate($_POST["colorname"]);        
    }
    if (!empty($_POST["minifig"])) {
        $searchterms['minifig'] = validate($_POST["minifig"]);        
    }
    if(!empty($_POST["start"])) {
        $start = validate($_POST["start"]);
//        advSearch(connect(), $searchterms, $start, $searchOPT);
    } else {
//        advSearch(connect(), $searchterms, 0, $searchOPT);
    }
}
?>
           
        </main>

        <footer>
            <p>© 2013 BrickSearch</p>
        </footer>

    </div>
</body>

</html>
