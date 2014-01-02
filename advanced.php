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
            </ul>
        </nav>

        <main>

		 <div id="mainSearch">

                <form action="" method="get">
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
	                    <input type="text" name="setid">
                    </div>
                    <div class="advRow">
	                	<label>Color</label>
	                    <input type="text" name="colorname">
                    </div>
                    <div class="advRow">
	                	<label>Minifig</label>
	                    <input type="text" name="setid">
                    </div>
                    <div class="advRow"> 
                        <label>Select</label> 
                        <label for="part"><input type="radio" name="ADVopt1" value="part" id="part" checked>Part</label> 
                        <label for="set"><input type="radio" name="ADVopt1" value="set" id="set">Set</label> 
                    </div>

                    <p><div id="searchButton2"></div></p>
                </form>

           
        </main>

        <footer>
            <p>© 2013 BrickSearch</p>
        </footer>

    </div>
</body>

</html>
