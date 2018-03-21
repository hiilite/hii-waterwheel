<?php
$html = '<div class="hii-w-carousel-wrap">
	<div class="hii-w-carousel">';
	
		$entries = get_post_meta( $a['id'], 'hii_ww_slide', true );
		$item_count = count($entries);
		
		if($item_count > 5) {

			foreach ( (array) $entries as $key => $entry ) {
	
				$img = $display = '';
			
				if ( isset( $entry['hii_ww_image'] ) ) {
					$img = $entry['hii_ww_image'];
				}
			
				if ( isset( $entry['hii_ww_img_display'] ) ) {
					$display = $entry['hii_ww_img_display'];
				}
			
				$html .= '<div class="hii-w-slide"><div style="background:url(\''.$img.'\'); background-size:'.$display.'"></div></div>';
			
			}
		} else {

			$slides = 0;
			
			while($slides < 6) {
				
				$new_slides = 0;
				
				foreach ( (array) $entries as $key => $entry ) {
	
					$img = $display = '';
				
					if ( isset( $entry['hii_ww_image'] ) ) {
						$img = $entry['hii_ww_image'];
					}
				
					if ( isset( $entry['hii_ww_img_display'] ) ) {
						$display = $entry['hii_ww_img_display'];
					}
				
					$html .= '<div class="hii-w-slide"><div style="background:url(\''.$img.'\'); background-size:'.$display.'"></div></div>';
					
					$new_slides++;
				}
				
				$slides = $slides + $new_slides;
				
			}
		}


	$html .= '</div>
	<img class="hii-w-prev hii-w-nav-button" alt="prev" src="'.HIIWATERWHEEL_URL . '/assets/images/arrow-prev.svg">
    <img class="hii-w-next hii-w-nav-button" alt="next" src="'.HIIWATERWHEEL_URL . '/assets/images/arrow-next.svg">
</div>';
?>
