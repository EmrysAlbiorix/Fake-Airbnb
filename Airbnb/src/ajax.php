<?php
/* PHP code for AJAX interaction goes here */

include("db.php");

$listingId=$_GET["listingId"];

echo getListing($db, $listingId);

?>
