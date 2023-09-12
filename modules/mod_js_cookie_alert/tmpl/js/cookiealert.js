(function($){



	function cwsetCookie(c_name,value,exdays) {

		var exdate=new Date();

		exdate.setDate(exdate.getDate() + exdays);

		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());

		document.cookie=c_name + "=" + c_value;

	}



	function cwgetCookie(c_name) {

		var i,x,y,ARRcookies=document.cookie.split(";");

		for (i=0;i<ARRcookies.length;i++) {

			x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));

			y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);

			x=x.replace(/^\s+|\s+$/g,"");

			if (x==c_name) {

				return unescape(y);

			}

		}

	}



    $.fn.cwAllowCookies = function(options) {



		

		var dateObject = new Date();

		var timeOffset = - dateObject.getTimezoneOffset() / 60;

		var region = "TheWorld";



		switch (timeOffset) {

			case -1:

			case -0: 

			case 0:

			case 1:

			case 2:

			case 3:

			case 3.5:

			case 4:

			case 4.5:

			region = "Europe"; 	

			break;

			case 9:

			region = "Japan"; 

		}



		$(".cwallowcookies").live('click', function() {	

			cwsetCookie("cwallowcookies",true,365);	

			$(".cwcookielaw").slideUp('slow',function() { $(this).remove(); }); 

			$(".cwcookielawbg").slideUp('slow',function() { $(this).remove(); $(".cwcookielaw").remove();  });

		});



		$(".cwcookiesmoreinfo").live('click',function() { 

			$(".cwcookiebubble").fadeIn('slow');

		});



		$(".cwcookiebubble").live('click',function() { 

			$(".cwcookiebubble").fadeOut('slow');

		});



		

		var cwallowcookies=cwgetCookie("cwallowcookies");



		

        var defaults = {

            imgpath:				"/joomla25/modules/mod_js_cookie_alert/tmpl/img/",

            cwmessage:				"Nasz serwis wykorzystuje pliki cookies. Korzystanie z witryny oznacza zgodê na ich zapis lub odczyt zgodnie z ustawieniami przeglšdarki.",

            cwbubblemessage:			"Od 22 marca 2013 roku obowišzujš przepisy znowelizowanego Prawa Telekomunikacyjnego dotyczšce plików cookies. Nowe przepisy dostosowujš polskie prawo do dyrektyw unijnych 2009/136/WE i 2009/140/WE. Decyzjš Parlamentu Europejskiego zosta³a wprowadzona regulacja nakazujšca ka¿demu w³a?cicielowi serwisu internetowego na pozyskanie zgody internautów na instalowanie ciasteczek.",

            cwbubbletitle:			"Przepisy dot. plików cookies",

            cwhref:					"",

            cwreadmore:				"Czytaj wiêcej",

            cwagree:				"Rozumiem",

            cwmoreinfo:				"Wiêcej...",
			
			cwbuttoncolor:			"blue",

			animate:				true,

			europeonly:				false

        };





		

        var options = $.extend(defaults, options);



		

		if (options.europeonly == true) { if (region !== "Europe") { return(false); } }



		

		if (options.cwhref !== "") { options.cwbubblemessage = options.cwbubblemessage + " <a href=\""+options.cwhref+"\">"+options.cwreadmore+"</a>"; }



		

		var html = "<div class=\"cwcookielaw\">" +

							"<div class=\"cwcookiecontainer\">" +

								"<p>" + options.cwmessage + "</p>" +

								"<a class=\"cwallowcookies button " + options.cwbuttoncolor + "\" >" + options.cwagree + "</a>" +
								
								"<a class=\"cwcookiesmoreinfo button reset2 " + options.cwbuttoncolor + "\" >" + options.cwmoreinfo + "</a>" +

								"<div class=\"cwcookiebubble\"><div class=\"cwcookietitle\">" + options.cwbubbletitle + "</div><p>" + options.cwbubblemessage + "</p></div>" +

							"</div>" +

						"</div><!-- cwcookielaw -->" +

						"<div class=\"cwcookielawbg\"></div>";



		

		if (cwallowcookies) {

			cwsetCookie("cwallowcookies",true,365); 

		} else {

			$(this).prepend(html); 

			if (options.animate) { 

				$(".cwcookielaw").slideDown('slow'); 

				$(".cwcookielawbg").slideDown('slow'); 

			} else {

				$(".cwcookielaw").show();

				$(".cwcookielawbg").show();

			}

		}



    };

})(jQuery);