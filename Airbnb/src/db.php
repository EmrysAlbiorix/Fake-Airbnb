<?php

include 'functions.php';
$db = dbConnect();


function arrayToSelectList($arr, $secondKey){
	$resString = "";
	foreach($arr as $key => $value){	
		$resString .= '<option value="' . $arr[$key]['id']. '">' . $arr[$key][$secondKey] . '</option>';
	}
	return $resString;
}


function getNeighborhoods() {
	global $db;
	try{
//        get all neighborhoods in alphabetical order
		$stmt = $db->prepare("SELECT * FROM neighborhoods ORDER BY neighborhood ASC");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return arrayToSelectList($res, "neighborhood");
    }
    catch (PDOException $e) {
         echo $e->getMessage();
    }
}
function getRooms() { 
	global $db;
	try{
//        get all neighborhoods in alphabetical order
		$stmt = $db->prepare("SELECT * FROM roomTypes ORDER BY type ASC"); 
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		var_dump($res);
		return arrayToSelectList($res, "type");
    }
    catch (PDOException $e) {
         echo $e->getMessage();
    }
}

function getGuests(){
	$res = "";
	foreach(range(1,10) as $key => $value){
		$res .= '<option value="' . $key + 1 . '">' . $key + 1 . '</option>';
	}
	return $res;
}	

function fetchDataFromDatabase($db, $neighborhood, $rooms, $guests) {
	try {
    	// Construct the SQL query
        $sql = "
            SELECT
                listings.name AS name,
                listings.price AS price,
                listings.id AS id,
                listings.rating AS rating,
				listings.pictureUrl AS image_src,
                listings.numReviews AS num_reviews,
			    listings.description AS description,
                listings.roomTypeId AS room_type_id,
			    listings.accommodates AS accommodates,
                listings.neighborhoodId AS neighborhood_id,
                    
				hosts.hostAbout AS about,
    			hosts.hostName AS host,
				roomTypes.type AS room_type,
                neighborhoods.neighborhood AS neighborhood,
				(
        			SELECT GROUP_CONCAT(amenities.amenity SEPARATOR ', ')
        			FROM listingAmenities
        			JOIN amenities ON listingAmenities.amenityID = amenities.id
    	   			WHERE listingAmenities.listingID = listings.id
		   		) AS amenities
            FROM
                listings
            JOIN
                neighborhoods ON listings.neighborhoodId = neighborhoods.id
            JOIN
                roomTypes ON listings.roomTypeId = roomTypes.id
			JOIN
				hosts ON listings.hostId = hosts.id
            WHERE
                listings.neighborhoodId = :neighborhoodId
                AND listings.roomTypeId = :roomtypeId
                AND listings.accommodates >= :numberofGuests
            ";

        // Prepare the SQL statement
        $stmt = $db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':neighborhoodId', $neighborhood, PDO::PARAM_INT);
        $stmt->bindParam(':roomtypeId', $rooms, PDO::PARAM_INT);
        $stmt->bindParam(':numberofGuests', $guests, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the results
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return the results
        return $res;
    } catch (PDOException $e) {
        // Handle any exceptions
        echo $e->getMessage();
        return false; // Or handle error in a different way as needed
    }
}

function getMetaData($db, $neighborhood, $rooms, $guests) {
    try {
        // Construct the SQL query
        $sql = "
            SELECT
                (
                    SELECT neighborhood
                    FROM neighborhoods
                    WHERE id = :neighborhoodId
                ) AS neighborhood,
                (
                    SELECT type
                    FROM roomTypes
                    WHERE id = :roomtypeId
                ) AS room_type
        ";

        // Prepare the SQL statement
        $stmt = $db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':neighborhoodId', $neighborhood, PDO::PARAM_INT);
        $stmt->bindParam(':roomtypeId', $rooms, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the results
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Create the array containing neighborhood, room type, and guests
        $metadata = array();
        foreach ($res as $row) {
            $metadata['neighborhood'] = $row['neighborhood'];
            $metadata['room_type'] = $row['room_type'];
            $metadata['guests'] = $guests; // Assuming $guests is already defined
        }

        return $metadata;
    } catch (PDOException $e) {
        // Handle any exceptions
        echo $e->getMessage();
        return false; // Or handle error in a different way as needed
    }
}


function getListing($db, $listingId){
	try {
        $sql = "
			SELECT
			    listings.id AS id,
			    listings.name AS name,
			    listings.pictureUrl AS image_src,
			    neighborhoods.neighborhood AS neighborhood,
			    listings.price AS price,
			    listings.accommodates AS accommodates,
    			listings.rating AS rating,
			    hosts.hostName AS host
			FROM
			    listings
			JOIN
			    neighborhoods ON listings.neighborhoodId = neighborhoods.id
			JOIN
			    hosts ON listings.hostId = hosts.id
			WHERE
			    listings.id = :listingID;
        ";
        // Prepare the SQL statement
        $stmt = $db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the results
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the results
        return $res;
    } catch (PDOException $e) {
        // Handle any exceptions
        echo $e->getMessage();
        return false; // Or handle error in a different way as needed
    }
}
?>
