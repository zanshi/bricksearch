<?php

function connect()
{
    $con = mysqli_connect("koneko.se", "projekt", "tnmk30", "lego");
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    return $con;
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function printTitle($title)
{
    echo "<title>";
    if ($title) {
        echo $title . " - ";
    }
    echo "Brick Search" . "</title>";

}

function mainSearch($con, $str)
{
    $sql
        = "SELECT images.*, sets.SetID, sets.Setname
        FROM sets, images, inventory
        WHERE sets.SetID = inventory.SetID
        AND images.itemID = inventory.ItemID
        AND images.itemTypeID = inventory.ItemtypeID
        AND sets.SetID LIKE '$str-%'"
    ;

    $result = mysqli_query($con, $sql);

    if ($result) {

        for ($i = 0; $i < 60; $i++) {
            $row = mysqli_fetch_assoc($result);
            writeHtml($row);
        }

        mysqli_free_result($result);

    }

}

function writeHtml($row)
{

    $img_url = handleImgUrl($row);

    echo "<div class='row'>" . "\n";
    echo    "<div class='thumb'>" . "\n";
    echo        "<img class='thumb' src='" . $img_url . "' alt='bild' >" . "\n";
    echo    "</div>" . "\n";
    echo    "<div class='text'>" . "\n";
    echo        "<h2 class='setname'>" . $row['Setname'] . "</h2> \n";
    echo         "<p class='setid'>" . $row['SetID'] . "</p> \n";
    echo    "</div>" . "\n";
    echo "</div>" . "\n";

}

function handleImgUrl($row)
{

    // Sätter ihop URL:en efter vad som $row innehåller.
    $img_dir = "http://webstaff.itn.liu.se/~stegu/img.bricklink.com/";
    $img_url = $img_dir . $row['itemTypeID'];

    /*if ($row['has_largejpg'] == "1") {
        $img_url .= "L";
    } */

     $img_url .= "/";

    // Om itemTypeID är P eller G så betyder det att objektet har ett colorID
    if ($row['itemTypeID'] == "P" || $row['itemTypeID'] == "G") {
        $img_url = $img_url . $row['colorID'] . "/";
    }

    // Lägger till itemID till URL:en
    $img_url = $img_url . $row['itemID'];

    // Lägger till lämpliga filändelser
    if ($row['has_gif'] == 1) {
        $img_url = $img_url . ".gif";
    } elseif ($row['has_jpg'] == 1) {
        $img_url = $img_url . ".jpg";
    } else {
        $img_url = "img/noimage.png";
    }

    return $img_url;

}
