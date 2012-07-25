require.config({
	baseUrl: '/statics/js'
})

require(

	['jquery','app/page','/statics/boostrap/js/bootstrap.js'],
	
	function($,Page) {
		
		$.ajaxSetup({cache:false});
		
		//Init page
		$(function(){
			Page.init($('#inner'));
		});
		
		
		/*
		 *
		 * Twitter
		 *
		 */
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
		
		/*
		 *
		 * Facebook Javascript SDK
		 *
		 */
		if(FB_APPID && FB_APPID.length) {
			$('body').append('<div id="fb-root"><div>');
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/fr_CA/all.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			window.fbAsyncInit = function() {
				FB.init({appId: FB_APPID, status: true, cookie: true, xfbml: true});
				FB.Event.subscribe('edge.create',function(response) {
					_gaq.push(['_trackPageview','/facebook/like']);
				});
			};
		}
	
});


