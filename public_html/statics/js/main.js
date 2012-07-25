require.config({
	baseUrl: '/statics/js'
});

require(

	['require','jquery','app/page','/statics/bootstrap/js/bootstrap.js'],
	
	function(require,$,Page) {
		
		$.ajaxSetup({cache:false});
		
		//Init page
		$(function(){
			Page.init($('#inner'));
			
			//Load modules
			if(!REQUIRE_SCRIPTS || !REQUIRE_SCRIPTS.length) return;
			
			var modules = [];
			for(var i = 0; i < REQUIRE_SCRIPTS.length; i++) {
				var module = REQUIRE_SCRIPTS[i].replace('/statics/js/','').replace(/\.js$/i,'');
				modules.push(module);
			}
			
			var $container = this.container;
			require(modules,function() {
				for(var i = 0; i < arguments.length; i++) {
					arguments[i]($container);
				}
			});
			
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


