<?php


function Card($data) {
    // Extract data from the array
    $accommodates = 	$data["accommodates"];
	$amenities = 		$data["amenities"];
    $description = 		$data["description"];
    $host = 			$data["host"];
	$image_src = 		$data["image_src"];
	$id = 				$data["id"];
    $name = 			$data["name"];
    $neighborhood = 	$data["neighborhood"];
    $price = 			$data["price"];
    $rating = 			$data["rating"];
	$roomType = 		$data["room_type"];

    // Start building the card HTML
    $cardHTML = '
	<div class="col">	
    	<div class="card shadow-sm">
        	<img src="' . $image_src . '">

        	<div class="card-body">
            	<h5 class="card-title" >' . $neighborhood . '</h5>
            	<p class="card-text">' . $name . '</p>
            	<p class="card-text">Accommodates ' . $accommodates . '</p>
				<p class="card-room-type">' . $roomType . '</p
            	<p class="card-text align-bottom">
            	<i class="bi bi-star-fill"></i><span class=""> ' . $rating . '</span>
            	</p>

            	<div class="d-flex justify-content-between align-items-center">
                	<div class="btn-group">
						<button type="button" id="' . $id . '" class="viewButton btn btn-sm btn-outline-secondary viewListing" data-bs-toggle="modal" data-bs-target="#modal_' . $id . '">View</button>
                	</div>
                	<small class="text-muted">$' . $price . '</small>
            	</div>
        	</div>
    	</div>
		<!-- Modal --> 
		<div class="modal fade modal-lg" id="modal_' . $id . '" tabindex="-1" aria-labelledby="modal_' . $id . '_label" aria-modal="true" role="dialog">
			<div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">' . $name . '</h5>
                        <button type="button" id="' . $id . '" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-image">
                        <img src="' . $image_src . '" class="img-fluid">
                    </div>
                    <div class="modal-footer">
                        <p>' . $neighborhood . '</p>
                        <p>$' . $price . ' / night</p>
                        <p>Accommodates ' . $accommodates . '</p>
                        <p><i class="bi bi-star-fill"></i> ' . $rating . '</p>
                        <p>Hosted by '. $host . '</p>
                        <p>Amenities: ' . $amenities .'</p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>	
	</div>
	';

    return $cardHTML;
}

function NoResponses(){
	
}
?>

