(function($){$(document).ready(function(){
	
	$(window).on('resize', function(){
		if($('.hii-w-slide:nth-child(1)').css('display') == 'none') {
	     	$( ".hii-w-slide:nth-child(2)" ).css({
			    left: "0",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  });	
			  
			  $( ".hii-w-slide:nth-child(4)" ).css({
			    left: "60%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  });
		}
		else {
			$( ".hii-w-slide:nth-child(2)" ).css({
			    left: "12.5%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  });	
			  
			  $( ".hii-w-slide:nth-child(4)" ).css({
			    left: "47.5%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  });
		}
	});

	$('.hii-w-next').click(function() {
		  
		if($('.hii-w-slide:nth-child(1)').css('display') == 'none') {
			$( ".hii-w-slide:nth-child(1)" ).animate({
			    left: "0",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  }, "fast", "linear");			
		} else {
		  
			$( ".hii-w-slide:nth-child(1)" ).animate({
			    left: "12.5%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  }, "fast", "linear");
			  
		}
		  
		$( ".hii-w-slide:nth-child(2)" ).animate({
		    left: "25%",
		    top: "0px",
		    height: "300px",
		    width: "50%"
		  }, "fast", "linear");
		  
		  
		if($('.hii-w-slide:nth-child(1)').css('display') == 'none') {
			$( ".hii-w-slide:nth-child(3)" ).animate({
			    left: "60%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  }, "fast", "linear");
			
		} else {
		  
			$( ".hii-w-slide:nth-child(3)" ).animate({
			    left: "47.5%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  }, "fast", "linear");
			  
		}
				
		$( ".hii-w-slide:nth-child(4)" ).animate({
		    left: "70%",
		    top: "50px",
		    height: "200px",
		    width: "30%"
		  }, "fast", "linear");

		
		$( ".hii-w-slide:nth-child(5)" ).animate({
		    left: "50%",
		    height: "0",
		    width: "0",
		  }, "fast", "linear", function() {
			  
		});
		
		
		var style = $('.hii-w-slide:nth-last-child(1) > div').attr('style');
		
		
		/* append */
		$('.hii-w-carousel').prepend('<div class="hii-w-slide"><div style="'+style+'"></div></div>');
		
		/* Delete original from end */
		$('.hii-w-slide').last().remove();
		
		  
		$(".hii-w-slide:nth-child(1)").animate({
		    left: "0",
		    top: "50px",
		    height: "200px",
		    width: "30%"
		  }, "fast", "linear");

		
	});
	
	
	/* PREVIOUS */
	$('.hii-w-prev').click(function() {
		
		$( ".hii-w-slide:nth-child(1)" ).animate({
		    left: "50%",
		    top: "150px",
		    height: "110px",
		    width: "25%"
		  }, 400, "linear", function () {
				var style = $('.hii-w-slide:nth-child(1) > div').attr('style');
				
				/* append */
				$('.hii-w-carousel').append('<div class="hii-w-slide"><div style="'+style+'"></div></div>');	
				$('.hii-w-slide').first().remove();  
		});
		
		$( ".hii-w-slide:nth-child(2)" ).animate({
		    left: "0",
		    top: "50px",
		    height: "200px",
		    width: "30%"
		  }, "fast", "linear");
		  
		  
		if($('.hii-w-slide:nth-child(1)').css('display') == 'none') {
			$( ".hii-w-slide:nth-child(3)" ).animate({
			    left: "0",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  }, "fast", "linear");
				
		} else {
		  
			$( ".hii-w-slide:nth-child(3)" ).animate({
			    left: "12.5%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  }, "fast", "linear");
			  
		}
		
		
		$( ".hii-w-slide:nth-child(4)" ).animate({
		    left: "25%",
		    top: "0",
		    height: "300px",
		    width: "50%"
		  }, "fast", "linear");
		  
		  
		  if($('.hii-w-slide:nth-child(1)').css('display') == 'none') {
			$( ".hii-w-slide:nth-child(5)" ).animate({
			    left: "60%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  }, "fast", "linear");
				
		} else {
		  
			$( ".hii-w-slide:nth-child(5)" ).animate({
			    left: "47.5%",
			    top: "25px",
			    height: "250px",
			    width: "40%"
			  }, "fast", "linear");
			  
		}

		
		
		//var style = $('.hii-w-slide:nth-child(1) > div').attr('style');
		
		/* append */
		//$('.hii-w-carousel').append('<div class="hii-w-slide"><div style="'+style+'"></div></div>');

		
		$( ".hii-w-slide:nth-last-child(1)" ).animate({
		    left: "50%",
		    top: "150px",
		    height: "0",
		    width: "0",
		  }, "fast", "linear");
		
		$( ".hii-w-slide:nth-child(6)" ).animate({
		    left: "70%",
		    top: "50px",
		    height: "200px",
		    width: "30%"
		  }, "fast", "linear");
		
		/* Delete original from beguining */
		//$('.hii-w-slide').first().remove();
		
		
	});
	
	/* Handles Adding Images to Waterwheel post type */
	
	 /* Instantiates the variable that holds the media library frame. */
    var meta_image_frame;
 
    /* Runs when the image button is clicked. */
    $('#hiiwaterwheel-meta-image-button').click(function(e){
 
        /* Prevents the default action from occuring. */
        e.preventDefault();
 
        /* If the frame already exists, re-open it. */
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        /* Sets up the media library frame */
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });
 
        /* Runs when an image is selected. */
        meta_image_frame.on('select', function(){
 
            /* Grabs the attachment selection and creates a JSON representation of the model. */
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 
            /* Sends the attachment URL to our custom image input field. */
            $('#hiiwaterwheel-meta-image').val(media_attachment.url);
        });
 
        /* Opens the media library frame. */
        meta_image_frame.open();
    });
	
	
		
});})(jQuery);