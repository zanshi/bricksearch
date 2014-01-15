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

                    <input type="submit" id="searchButton2" value="Search"></input>
                </form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cid = "";
    $cname = "";
    $id = "";
    $name = "";

    $searchOPT = $_POST['advOPT1'];
    $cid = validate($_POST["cid"]); 
    $cname = validate($_POST["cname"]);
    $id = validate($_POST["id"]); 
    $name = validate($_POST["name"]);   
        

    if(!empty($_POST["start"])) {
        $start = validate($_POST["start"]);
        advSearch(connect(), $start, $searchOPT, $cid, $cname, $id, $name);
    } else {
        advSearch(connect(), 0, $searchOPT, $cid, $cname, $id, $name);
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
