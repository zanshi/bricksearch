<?php

require 'functions.php';

/**
 * List year made, category name, parts names, id for parts, quantity, color
 * Will probably add more stuff
 *
 */

$setID = null;

if (validate($_GET['id'])) {
    $setID = cleanInput($_GET['id']);
}

$con = connect();

if ($con && $setID) {

    $query1
        = "SELECT sets.year, categories.categoryName
        FROM sets, categories
        WHERE sets.catID = categories.catID
        AND sets.setID = '$setID'"
    ;

    $query2
        = "SELECT parts.partName, parts.partID, inventory.quantity, colors.colorName
            FROM parts, inventory, colors
            WHERE inventory.colorID = colors.colorID
            AND inventory.itemID = parts.partID
            AND inventory.setID = '$setID'"
    ;

    $result = mysqli_query($con, $query1);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        writeSetInfo($row);
    }

    mysqli_free_result($result);

    $result = mysqli_query($con, $query2);

    if ($result) {
        writePartInfo($result, $con);
    }

    mysqli_free_result($result);

    mysqli_close($con);

    /*    if (mysqli_multi_query($con, $query)) {
            do {
                mysqli_next_result($con);
                if ($result = mysqli_store_result($con)) {

                    // If result contains only one row it means
                    // it's from the first query
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        writeSetInfo($row);

                    // Otherwise, it's the second query
                    } else {
                        writePartInfo($result, $con);
                    }
                    // Free result when we are done
                    mysqli_free_result($result);

                }
                // If no parts in set, close div tag
                if (mysqli_more_results($con)) {

                } else {
                    echo "<h2> No parts in this set!</h2>";
                    
                }
            } while (mysqli_more_results($con));

            echo "</div>";
        }*/

}

function writeSetInfo($row)
{
    echo "<div class='row extendedResults'>";
    echo    "<div class='moreSetInfo'>";
    echo        "<h2 class='setinfo'> Set Info </h2>";
    echo        "<h3> Year </h3>";
    echo        "<p>" . $row['year'] . "</p>";
    echo        "<h3> Category </h3>";
    echo        "<p>" . $row['categoryName'] . "</p>";
    echo    "</div>";

/*    echo "<div class='row extendedResults'>";
    echo    "<div class='moreSetInfo'>";
    echo        "<p> <strong>Year:</strong>";
    echo        "<p>" . $row['year'] . "</p>";
    echo        "<h2> Category </h2>";
    echo        "<p>" . $row['categoryName'] . "</p>";
    echo    "</div>";*/

}

function writePartInfo($result, $con)
{
    echo "<div class='partsContainer'>";
    echo "<h2> Parts </h2>";
    echo "<div class='scroll'>";

    $row = mysqli_fetch_assoc($result);
    do {
        if ($row['partName'] != null) {
            $imgUrl = handleImgUrl($con, $row, 1);
            echo "<div class='parts'>";
            echo    "<a href='". $imgUrl ."'><img src='" . $imgUrl . "' alt='bild' > </a>";
            echo    "<h3>Part name</h3>";
            echo        "<p>" . $row['partName'] . "</p>";
            echo    "<h3>Part ID</h3>";
            echo        "<p>" . $row['partID'] . "</p>";
            echo    "<h3>Quantity</h3>";
            echo        "<p>" . $row['quantity'] . "</p>";
            echo    "<h3>Color</h3>";
            echo        "<p>" . $row['colorName'] . "</p>";
            echo "</div>";
        } else {
            echo "<h3>No parts in this set. </h3>";
        }
    } while ($row = mysqli_fetch_assoc($result));
    echo "</div>";
    echo "</div>";
    echo "</div>";



}
