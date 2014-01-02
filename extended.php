<?php

require "functions.php";

/**
 * List year made, category name, parts names, id for parts, quantity, color
 * Will probably add more stuff
 * 
 */

$setID = null;

if (!empty($_GET['id'])) {
    $setID = validate($_GET['id']);
}

$con = connect();

if($con && $setID) {

    $query
        = "SELECT sets.year, categories.categoryName
        FROM sets, categories
        WHERE sets.catID = categories.catID
        AND sets.setID = '$setID';"
    ;

    $query
        .= "SELECT parts.partName, parts.partID, inventory.quantity, colors.colorName
            FROM sets, parts, inventory, colors
            WHERE sets.setID = inventory.setID
            AND inventory.colorID = colors.colorID
            AND inventory.itemID = parts.partID
            AND sets.setID = '$setID'"
    ;


    if(mysqli_multi_query($con, $query)) {
        do {
            if( $result = mysqli_store_result($con)) {

                // If result contains only one row it means
                // it's from the first query
                if(mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    writeSetInfo($row);

                // Otherwise, it's the second query
                } else {
                    writePartInfo($result);
                }
                // Free result when we are done
                mysqli_free_result($result);

            }
            // If no parts in set, close div tag
            if(mysqli_more_results($con)) {
                
            } else {
                echo "</div>";
            }
        } while(mysqli_next_result($con));
    }

    mysqli_close($con);

}

function writeSetInfo($row) {
    echo "<div class='row extendedResults'>";
    echo    "<div class='moreSetInfo'>";
    echo        "<h2> Set Info </h2>";
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

function writePartInfo($result) {
    echo "<div class='partsContainer'>";
    echo    "<h2> Parts </h2>";
    while($row = mysqli_fetch_assoc($result)) {

        echo "<div class='parts'>";
        echo    "<h3>Part name</h3>";
        echo        "<p>" . $row['partName'] . "</p>";
        echo    "<h3>Part ID</h3>";
        echo        "<p>" . $row['partID'] . "</p>";
        echo    "<h3>Quantity</h3>";
        echo        "<p>" . $row['quantity'] . "</p>";
        echo    "<h3>Color</h3>";
        echo        "<p>" . $row['colorName'] . "</p>";
        echo "</div>";
    }
    echo "</div>";

}

