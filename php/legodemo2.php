
<html>
<head>
    <meta charset="utf-8">
    <?php
    /**
     * legodemo2
     *
     * @category Class
     * @package  Test
     * @author   [author] <test@test.com>
     * @license  [url] [description]
     * @link     (target, link)
     *
     */
    $con = mysqli_connect("koneko.se", "projekt", "tnmk30", "lego");
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }
/*   Från formuläret, om man trycker på "submit"-knappen, kommer
   variablen $POST["setnr"] som innehåller texten i fältet "setnr".*/
    $setnr = $_POST["setnr"];
    ?>
    <title>Lego-sats nummer <?php print $setnr ?></title>
</head>

<body>
    <h2>Matchande Lego-satser:</h2>

    <?php

    $sql 
        = "SELECT images.*, sets.SetID, sets.Setname
        FROM sets, images, inventory
        WHERE sets.SetID = inventory.SetID
        AND images.itemID = inventory.ItemID
        AND sets.SetID LIKE '$setnr-%'"
    ;

    $result = mysqli_query($con, $sql);

    if ($result) {

        /**
         * [$row description] Associativ array av $results-objektet
         * @var [type]
         */
    while ($row = mysqli_fetch_assoc($result)) {
        //echo "<pre>" . var_dump($row) . "</pre>\n";
        echo "\t" . "<div class='row'>" . "\n";
        echo    "<div class='thumb'>" . "\n";
        // Sätter ihop URL:en efter vad som $row innehåller.
        $img_dir = "http://webstaff.itn.liu.se/~stegu/img.bricklink.com/";
        $img_url = $img_dir . $row['itemTypeID'] . "/";

        // Om itemTypeID är P eller G så betyder det att objektet har ett colorID
        if ($row['itemTypeID'] == "P" || $row['itemTypeID'] == "G") {
            $img_url = $img_url . $row['colorID'] . "/";
        }

        // Lägger till itemID till URL:en
        $img_url = $img_url . $row['itemID'];

        // Lägger till lämpliga filändelser
        if ($row['has_gif'] == 1) {
            $img_url = $img_url . ".gif";
        } else if ($row['has_jpg'] == 1) {
            $img_url = $img_url . ".jpg";
        }
        echo "<img src='" . $img_url . "' alt='bild'>" . "\n";
        echo '</div>' . "\n";
        echo '<div class="text">' . "\n";
    }
    }
?>

</body>
</html>
