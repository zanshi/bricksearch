<?php print("<?xml version = '1.0' encoding = 'iso-8859-1'?>\n"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- TNMK30 / projekt / legoimages.php -->

<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
   <title>Lego-bilder på BrickLink</title>
</head>

<body>
<h1>Lego-bilder på BrickLink</h1>

Kan vara en gif-fil eller en jpg-fil eller ingen alls.

<h2>Bilder för Lego-bitar</h2>

<h3>Generell URL för bit</h3>

<pre>
http://www.bricklink.com/P/ColorID/ItemID.gif

http://www.bricklink.com/P/ColorID/ItemID.jpg
</pre>

<h3>URL för specifik bit</h3>

<pre>
http://www.bricklink.com/P/6/3011.gif

http://www.bricklink.com/P/6/3011.jpg
</pre>

<?php
   $img_dir = "http://www.bricklink.com/";
   $gif_url = $img_dir . "P/" . "6/" . "3437" . ".gif";
   $jpg_url = $img_dir . "P/" . "6/" . "3437" . ".jpg";

   if (fclose(fopen($gif_url, "r")))
   {
      print("<p>" . "gif-bild" . "</p>");
      print("<p><img src='$gif_url' alt='gif-image' /></p>");
   }
   else if (fclose(fopen($jpg_url, "r")))
   {
      print("<p>" . "jpg-bild" . "</p>"); 
      print("<p><img src='$jpg_url' alt='jpg-image' /></p>");
   }
   else
   {
      print("<p>" . "bild saknas" . "</p>"); 
   }
?>

<h2>Bilder för Lego-satser</h2>

<h3>Generell URL för sats</h3>

<pre>
http://www.bricklink.com/S/SetID.gif

http://www.bricklink.com/S/SetID.jpg
</pre>

<h3>URL för specifik sats</h3>

<pre>
http://www.bricklink.com/S/033-1.gif

http://www.bricklink.com/S/033-1.jpg
</pre>

<?php
   $img_dir = "http://www.bricklink.com/";
   $gif_url = $img_dir . "S/" . "033-1" . ".gif";
   $jpg_url = $img_dir . "S/" . "033-1" . ".jpg";

   if (fclose(fopen($gif_url, "r")))
   {
      print("<p>" . "gif-bild" . "</p>");
      print("<p><img src='$gif_url' alt='gif-image' /></p>");
   }
   else if (fclose(fopen($jpg_url, "r")))
   {
      print("<p>" . "jpg-bild" . "</p>"); 
      print("<p><img src='$jpg_url' alt='jpg-image' /></p>");
   }
   else
   {
      print("<p>" . "bild saknas" . "</p>"); 
   }
?>

<h2>Bilder för minifigurer</h2>

<h3>Generell URL för minifigur</h3>

<pre>
http://www.bricklink.com/M/ItemID.gif

http://www.bricklink.com/M/ItemID.jpg
</pre>

<h3>URL för specifik för minifigur</h3>

<pre>
http://www.bricklink.com/M/adv033.gif

http://www.bricklink.com/M/adv033.jpg
</pre>

<?php
   $img_dir = "http://www.bricklink.com/";
   $gif_url = $img_dir . "M/" . "adv033" . ".gif";
   $jpg_url = $img_dir . "M/" . "adv033" . ".jpg";

   if (fclose(fopen($gif_url, "r")))
   {
      print("<p>" . "gif-bild" . "</p>");
      print("<p><img src='$gif_url' alt='gif-image' /></p>");
   }
   else if (fclose(fopen($jpg_url, "r")))
   {
      print("<p>" . "jpg-bild" . "</p>"); 
      print("<p><img src='$jpg_url' alt='jpg-image' /></p>");
   }
   else
   {
      print("<p>" . "bild saknas" . "</p>"); 
   }
?>

</body>
</html>
