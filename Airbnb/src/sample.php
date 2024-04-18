<?php

/* query with no SQL arguments */
function getTwentyListings($db) {
    try {
        $stmt = $db->prepare("select * from listings limit 20") ;
        $stmt->execute() ;
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
        return $rows ;
    } catch (Exception $e) {
        echo $e ;
    }
}

?>

<ul>
    <?php
    foreach($rows as $row) {
        $id = $row["id"] ;
        $neighborhood = $row["neighborhood"] ;

        echo "<li>$neighborhood, $id</li>" ;
    }
    ?>
</ul>
