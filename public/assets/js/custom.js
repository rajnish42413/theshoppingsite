(function($){
  "use strict";
		jQuery(document).ready(function($) {
			var $this = $(window);
	
	/*------ Mobile Menu --------*/
		var pho_count = 0;
		$('.sh_menu_btn').on("click", function(){
			if( pho_count == '0') {
				$('.sh_main_menu_wrapper').addClass('sh_main_menu_hide');
				$(this).children().removeAttr('class');
				$(this).children().attr('class','fa fa-close');
				pho_count++;
			}
			else {
				$('.sh_main_menu_wrapper').removeClass('sh_main_menu_hide');
				$(this).children().removeAttr('class');
				$(this).children().attr('class','fa fa-bars');
				pho_count--;
			}		
		});
		$('.sh_main_wrap').click(function(){
			$('.sh_main_menu_hide').removeClass('sh_main_menu_hide');
			$('.fa-close').addClass('fa-bars');
			$('.fa-bars').removeClass('fa-close');
		});
		$('#menu a').click(function(){
			$('.sh_main_menu_hide').removeClass('sh_main_menu_hide');
			$('.fa-close').addClass('fa-bars');
			$('.fa-bars').removeClass('fa-close');
		});
		
	/*-------- MObile Menu -----------*/
	/*-------- Category Sidebar -----------*/
	
		/* $('.sh_sidear_cat_menu > ul > li').on('click', function () {
			$(this).find('ul').slideToggle();
		});
	  */
	  
	  
	  /*-----------------------------------------------------
		Fix Owl Slider 
	-----------------------------------------------------*/
		$(document).ready(function(){
		
			// Top Products	
			$('.sh_top_prod').owlCarousel({
				loop: true,
				margin: 30,
				dots: false,
				autoplayHoverPause: true, 
				nav: true,
				navText : ['<span class="icofont-stylish-left"></span>','<span class="icofont-stylish-right"></span>'],
				autoplay: true,
				autoplayTimeout: 3500,
				smartSpeed: 1200,
				responsive: {
					0: {
						items: 1
					},
					768: {
						items: 2
					},
					991: {
						items: 3
					},
					1200: {
						items: 5
					},
					1920: {
						items: 5
					}
				}
			});

			// Top Deals	
			$('.sh_top_deals_wrap').owlCarousel({
				loop: true,
				margin: 30,
				dots: false,
				autoplayHoverPause: true, 
				nav: true,
				navText : ['<span class="icofont-stylish-left"></span>','<span class="icofont-stylish-right"></span>'],
				autoplay: true,
				autoplayTimeout: 2000,
				smartSpeed: 1000,
				responsive: {
					0: {
						items: 1
					},
					768: {
						items: 2
					},
					991: {
						items: 3
					},
					1200: {
						items: 4
					},
					1920: {
						items: 4
					}
				}
			});
					
		});
		
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	 	
	
	});
		
})(jQuery); 