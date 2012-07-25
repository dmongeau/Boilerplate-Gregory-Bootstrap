// JavaScript Document

define(['jquery'],function($) {
	
	var Page = {
		
		
		'init' : function($container) {
			
			Page.container = $container = $container || $('body');
			
			//Resize
			Page.onResize();
			$(window).resize(Page.onResize);
			
			//Elements
			Page.initElements();
			
			
		},
		
		/*
		 *
		 * Init elements
		 *
		 */
		'initElements' : function($container) {
			
			$container = 	$container || $('body');
			
			
			
		},
		
		/*
		 *
		 * When window resize
		 *
		 */
		'onResize' : function() {
			
		}
		
	};
	
	
	return Page;
	
	
});
