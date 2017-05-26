
$(document).ready(function() {

	$('.main-body').css('min-height', $(document).height()-64);

	$('.pin').on('click', function() {
    	var card_id = $(this).data("id");
    	$.ajax({
            url: base_url+'card/setCookieValue',
            type: 'post',
            data: { 'id' : card_id }
        });
    	if($(this).hasClass('pin-icon-skew')){
	    	$(this).removeClass('pin-icon-skew');
	    	$(this).addClass('pin-icon');
	    }else{
	    	$(this).removeClass('pin-icon');
	    	$(this).addClass('pin-icon-skew');
	    }
    });
    
    //Function to animate slider captions 
	function doAnimations( elems ) {
		//Cache the animationend event in a variable
		var animEndEv = 'webkitAnimationEnd animationend';
		
		elems.each(function () {
			var $this = $(this),
				$animationType = $this.data('animation');
			$this.addClass($animationType).one(animEndEv, function () {
				$this.removeClass($animationType);
			});
		});
	}
	
	//Variables on page load 
	var $myCarousel = $('#carousel-example-generic'),
		$firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
		
	//Initialize carousel 
	$myCarousel.carousel();
	
	//Animate captions in first slide on page load 
	doAnimations($firstAnimatingElems);
	
	//Pause carousel  
	$myCarousel.carousel('pause');
	
	
	//Other slides to be animated on carousel slide event 
	$myCarousel.on('slide.bs.carousel', function (e) {
		var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
		doAnimations($animatingElems);
	});  
    $('#carousel-example-generic').carousel({
        interval:3000,
        pause: "false"
    });
});





















