var please_select;

function getStationsFromZip($zipcode){
	var $getStationsUrl = '/wp-content/themes/haven2015/getstationsfromzip.php';
	var $seriesResult = $.ajax({
		type: "POST",
		url: $getStationsUrl,
		data: {
			zipcode: $zipcode
		},
		success: (function (results) {
			//console.log(requests[count].statusText);
			$('.drop.station .content .info .loadingMore').fadeOut(function(){$(this).remove();});
			$('.drop.station .content .info .loading').fadeOut(function() {$(this).remove();});
			if (results != ""){
				var searchResults = jQuery.parseJSON(results);
				displayStations(searchResults);
			}
		})
	})
}

function displayNoStationsFound(){
	var divStationHTML = '<div class="mid">There are no known stations in this area</div>'
	$('.drop.station .content .info').append(divStationHTML);
}

function displayStations(searchResults){
	var stationClass = "left";
	var stationFreq = "";
	var stationBand = "";

	if (searchResults.length > 0){
		gotStations = true;
		for(i=0;i<searchResults.length;i++){
			switch (i){
				case 0:
					stationClass = "left"
					break;
				case 1:
					stationClass = "mid"
					break;
				case 2:
					stationClass = "right"
					break;
			}
			if (searchResults[i].FBAND == "A"){
				stationBand = "AM";
			}
			else {
				stationBand = "FM";
			}

			switch (searchResults[i].ffreq){
				case "MF":
					stationFreq = "Mon - Fri";
					break;
				case "SS":
					stationFreq = "Sat & Sun";
					break;
				case "SA":
					stationFreq = "Saturday";
					break;
				case "SU":
					stationFreq = "Sunday";
					break;
				case "TS":
					break;
					stationFreq = "Tues - Sat";
			}

			var divStationHTML = '<div class="' + stationClass + '">' + '<h2>' + searchResults[i].dial + ' <span>' + stationBand + '</span> ' + searchResults[i].station + '</h2><hr />'+ '<span>' + searchResults[i].time + '  ' + stationFreq + '</span>'+ searchResults[i].city + ', ' + searchResults[i].state + '</div><!--end .left-->';
			$('.drop.station .content .info').append(divStationHTML);
		}
	}
	else {
		displayNoStationsFound();
	}

}

function create_mail(eNaam, eDomain, eTLD, eLabel) {
	var wMail = "";
	if (eLabel == "show") {
		eLabel = eNaam + '&#64;' + eDomain + '.' + eTLD;
	}
	wMail += '<a href="' + 'ma' + 'il' + 'to:' + eNaam;
	wMail += '&#64;' + eDomain + '.' + eTLD;
	wMail += '">' + eLabel + '<' + '/a>';
	document.write(wMail);
}

//mobile nav overlay
var mobileOpen = false;
function openMobile() {
	$('html,body').css('overflow','hidden');
	$('.mobileNav').slideDown();
	mobileOpen = true;
}
function closeMobile() {
	$('html,body').css('overflow','initial');
	$('.mobileNav').slideUp();
	mobileOpen = false;
}

//top dropdown boxes
var signupOpen = false;
var stationOpen = false;
var searchOpen = false;
var gotStations = false;

function closeDropDowns() {
	$('.drop').fadeOut();
	$('html,body').css('overflow','initial');
	signupOpen = false;
	stationOpen = false;
	searchOpen = false;
}

//adjust styles on browser resize
function resizeCheck(width) {
	var browserWidth = parseInt(width);
	var browserHeight = $('.container').height();

	if (browserWidth > 1010) {
		if ($('.banner.home').length > 0) {
			var homeBannerHeight = $('#hbImg1').height();
			$('.features').css({'position':'absolute','left':'0','bottom':'9%','margin':'0 auto'});
			if (browserHeight > homeBannerHeight) {
				$('.banner.home').css('height',homeBannerHeight + 'px');
			} else {
				var topBarHeight = $('.topBar').height();
				$('.banner.home').css('height',(browserHeight - topBarHeight) + 'px');
			}
		}
		if ($('.mobileNav').is(':visible')) {
			closeMobile();
		}
	} else if (browserWidth < 1010 && browserWidth > 600) {
		if ($('.banner.home').length > 0) {
			var homeBannerHeight = $('#hbImg1').height();
			$('.features').css({'position':'absolute','left':'0','bottom':'9%','margin':'0 auto'});
			if (browserHeight > homeBannerHeight) {
				$('.banner.home').css('height',homeBannerHeight + 'px');
			} else {
				$('.banner.home').css('height',browserHeight + 'px');
			}
		}
	} else {
		if ($('.banner.home').length > 0) {
			var homeBannerHeight = $('#hbImg1').height();
			var featuresHeight = $('.features').outerHeight();
			$('.features').css({'position':'relative','left':'auto','bottom':'auto','margin':'10px auto'});
			$('.banner.home').css('height',(homeBannerHeight + featuresHeight + 65) + 'px');
		}
	}

	//subpage header graphic text positioning
	if ($('.bannerTxt').length > 0) {
		var bannerTxtWidth = $('.bannerTxt').width()/2;
		$('.bannerTxt').css('margin-left','-' + bannerTxtWidth + 'px');
	}

}

//animate the header to show background color if needed
$(function(){
 var shrinkHeader = 100;
  $(window).scroll(function() {
    var scroll = getCurrentScroll();
      if ( scroll >= shrinkHeader ) {
		   $('.mainContainer').addClass('mainContainerBackground');
        }
        else {
            $('.mainContainer').removeClass('mainContainerBackground');
        }
  });
function getCurrentScroll() {
    return window.pageYOffset || document.documentElement.scrollTop;
    }
});

$(document).ready(function() {
	//mobile nav
	$('.mobileBtn').click(function() {
		if (mobileOpen) {
			closeMobile();
		} else {
			closeDropDowns();
			openMobile();
		}
	});

	//mainnav dropdown
	$('.mainNav ul li').mouseenter(function() {
		$(this).find('.children').slideDown();
	});
	$('.mainNav > ul > li > ul.children').mouseleave(function() {
		setTimeout(function(){
			if ($('.mainNav ul li:hover').length != 0) {
				//do nothing
			} else {
				$('.mainNav > ul > li > ul.children').slideUp();
			}
		},500);
	});
	$('.mainContainer').mouseleave(function() {
		setTimeout(function(){
			if ($('.mainNav ul li:hover').length != 0) {
				//do nothing
			} else {
				$('.mainNav > ul > li > ul.children').slideUp();
			}
		},500);
	});

	//top dropdown boxes
	$('.links .signup').click(function() {
		if (signupOpen) {
			$('.drop.signup').fadeOut();
			$('html,body').css('overflow','initial');
			signupOpen = false;
		} else {
			closeDropDowns();
			closeMobile();
			var signupHeight = $(window).height() - 135; //moved for animation change
			$('.drop.signup .signupForm').css('height',signupHeight + 'px'); //moved for animation change
			$('.drop.signup').fadeIn(function() {
				//var signupHeight = $(window).height() - 135;
				//$('.drop.signup .signupForm').css('height',signupHeight + 'px');
			});
			$('html,body').css('overflow','hidden');
			signupOpen = true;
		}
	});
	$('.mobileSignup').click(function() {
		if (signupOpen) {
			$('.drop.signup').fadeOut();
			$('html,body').css('overflow','initial');
			signupOpen = false;
		} else {
			closeDropDowns();
			closeMobile();
			var signupHeight = $(window).height() - 135; //moved for animation change
			$('.drop.signup .signupForm').css('height',signupHeight + 'px'); //moved for animation change
			$('.drop.signup').fadeIn(function() {
				//var signupHeight = $(window).height() - 135;
				//$('.drop.signup .signupForm').css('height',signupHeight + 'px');
			});
			$('html,body').css('overflow','hidden');
			signupOpen = true;
		}
	});
	$('.topLinks .station').click(function() {
		if (stationOpen) {
			$('.drop.station').fadeOut();
			$('html,body').css('overflow','initial');
			stationOpen = false;
		} else {
			if (!gotStations){
				$('.drop.station .content .info').empty();
				//$('.drop.station .content .info').append('<div class="loading"><img src="/wp-content/themes/haven2015/images/ajax-loader-search-white.gif" alt="loading..."></div>');
				$('.drop.station .content .info').append('<div class="loading">PLEASE ENTER A ZIPCODE AND CLICK "SEARCH"</div>');
				//getStationsFromZip(geo_zipcode);
			}
			closeDropDowns();
			closeMobile();

			var stationHeight = $(window).height() - $('.drop.station .stationForm').height() - 135; //moved for animation change
			$('.drop.station .content').css('height',stationHeight + 'px');  //moved for animation change
			$('.drop.station').fadeIn(function() {
				//var stationHeight = $(window).height() - $('.drop.station .stationForm').height() - 135;
				//$('.drop.station .content').css('height',stationHeight + 'px');
			});
			$('html,body').css('overflow','hidden');
			$('.drop.station').find('input[type="text"]').focus();
			stationOpen = true;
		}
	});
	$('.links .search').click(function() {
		if (searchOpen) {
			$('.drop.search').fadeOut();
			$('html,body').css('overflow','initial');
			searchOpen = false;
		} else {
			closeDropDowns();
			closeMobile();
			var searchHeight = $(window).height() - 135; //moved for animation change
			$('.drop.search .searchForm').css('height',searchHeight + 'px'); //moved for animation change
			$('.drop.search').fadeIn(function() {
				//var searchHeight = $(window).height() - 135;
				//$('.drop.search .searchForm').css('height',searchHeight + 'px');
			});
			$('html,body').css('overflow','hidden');
			$('.drop.search').find('input[type="text"]').focus();
			searchOpen = true;
		}
	});
	$('.mobileSearch').click(function() {
		if (searchOpen) {
			$('.drop.search').fadeOut();
			$('html,body').css('overflow','initial');
			searchOpen = false;
		} else {
			closeDropDowns();
			closeMobile();
			var searchHeight = $(window).height() - 135; //moved for animation change
			$('.drop.search .searchForm').css('height',searchHeight + 'px'); //moved for animation change
			$('.drop.search').fadeIn(function() {
				//var searchHeight = $(window).height() - 135;
				//$('.drop.search .searchForm').css('height',searchHeight + 'px');
			});
			$('html,body').css('overflow','hidden');
			$('.drop.search').find('input[type="text"]').focus();
			searchOpen = true;
		}
	});

	//close top dropdown boxes
	$('.closeBtn').click(function() {
		closeDropDowns();
	});

	//anchor archive
	$('.anchorAchrive h2').click(function() {
		if($(this).hasClass('open')){
			$(this).removeClass('open');
			$(this).parent().find('.month').slideUp();
		} else {
			$(this).addClass('open');
			$(this).parent().find('.month').slideDown();
		}
	});

	//top dropdown checkboxes
	$('.checkbox').click(function() {
		if ($(this).hasClass('on')) {
			$(this).addClass('on');
		} else {
			$(this).removeClass('on');
		}
	});

	//filters dropdown
	if ($('.filter').length > 0) {
		var filterOpen = false;
		$('.filter').click(function() {
			if (filterOpen) {
				$(this).find('ul').slideUp();
				filterOpen = false;
			} else {
				$(this).find('ul').slideDown();
				filterOpen = true;
			}
		});
	}

	//tooltips

	if ( $(window).width() > 739) {

		if ($('.tip').length > 0) {
			$('.tip').mouseover(function() {
				$(this).find('.txt').show();
			});
			$('.tip').mouseout(function() {
				$(this).find('.txt').hide();
			});
		}

	} else {

		if ($('.tip').length > 0) {
			$('.tip').click(function() {
				$(this).find('.txt').toggle();
			});
		}

	}

	/*comments form*/
	$('#comment').focus(function() {
		$(this).prev('label').hide();
	})
	.blur(function() {
		if ($(this).val() == '') {
			$(this).prev('label').show();
		}
	});
	$('#commentform input').focus(function() {
		$(this).prev('label').hide();
	})
	.blur(function() {
		if ($(this).val() == '') {
			$(this).prev('label').show();
		}
	});

	/*products banner content for mobile*/
	if ($('.giveBanner .info').length > 0) {
		$('.minContent').click(function() {
			$(this).hide();
			$(this).parent().find('.allContent').show();
		});
		$('.allContent').click(function() {
			$(this).hide();
			$(this).parent().find('.minContent').show();
		});
	}

	//if window is resized
	$(window).resize(function() {
		resizeCheck($('.container').width());
	});
	resizeCheck($('.container').width());

	$('#btnZipSearch').click(function() {
		if ($('#textZipCode').value != ""){
			$('.drop.station .content .info').empty();
			$('.drop.station .content .info').append('<div class="loading"><img src="/wp-content/themes/haven2015/images/ajax-loader-search-white.gif" alt="loading..."></div>');

			getStationsFromZip($('#textZipCode').val());
		}
	});
	$('#billing_postcode').keyup(function() {
		if (document.getElementById("radio_stations_container") == null)
		{
			var p_container = document.getElementById("order_comments_field").parentNode;
			var new_p = document.createElement("p");
			new_p.setAttribute("class","form-row notes");
			new_p.setAttribute("id","radio_stations_container");
			var new_label = document.createElement("label");
			new_label.setAttribute("for","radio_stations");
			var new_label_text = document.createTextNode("Radio Station");
			var new_label_optional = document.createElement("span");
			new_label_optional.setAttribute("class","optional");
			new_label_optional.innerText = "(optional)";
			new_label.appendChild(new_label_text);
			new_label.appendChild(new_label_optional);
			new_p.appendChild(new_label);
			var new_span = document.createElement("span");
			new_span.setAttribute("class","woocommerce-input-wrapper");
			var radio_select = document.createElement("select");
			radio_select.setAttribute("name","radio_stations");
			please_select = document.createElement("option");
			please_select.innerText = "Please enter your zipcode to view stations.";
			radio_select.appendChild(please_select);
			new_span.appendChild(radio_select);
			new_p.appendChild(new_span);
			p_container.appendChild(new_p);
		}
		else{
			var radio_stations_select = document.getElementsByName("radio_stations")[0];
			for (var i = 1; i < radio_stations_select.childNodes.length; i++)
			{
				radio_stations_select.removeChild(radio_stations_select.childNodes[i]);
			}
			var zipcode_regex = /^\d{5}$/;
			if (zipcode_regex.test(this.value))
			{
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function()
				{
					if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 304))
					{
						var radios_array = JSON.parse(xhr.responseText);
						for (var i = 0; i < radios_array.length; i++)
						{
							var new_radio_option = document.createElement("option");
							new_radio_option.innerText = radios_array[i]["dial"] + radios_array[i]["FBAND"] + "M " + radios_array[i]["station"] + " | " + radios_array[i]["city"] + ", " + radios_array[i]["state"];
							new_radio_option.setAttribute("value",radios_array[i]["station"] + " " + radios_array[i]["dial"] + "-" + radios_array[i]["FBAND"] + "M")
							radio_stations_select.appendChild(new_radio_option);
						}
						if (radios_array == '') {
							please_select.innerText = 'No nearby radio stations.';
						} else {
							please_select.innerText = 'Please select a radio station ...';
						}
					}
				}
				xhr.open("POST","/wp-content/themes/haventomorrow/getstationsproxy.php",true);
				xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8")
				xhr.send("zipcode=" + this.value);
			} else {
				please_select.innerText = 'Please enter a valid zipcode.';
			}
		}
	});
});

$(window).on('load', function() {
	resizeCheck($('.container').width());

	//outdated browser check
	// outdatedBrowser({
	// 	bgColor: '#f25648',
	// 	color: '#ffffff',
	// 	lowerThan: 'transform',
	// 	languagePath: 'en.html'
	// });

});

$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

setTimeout(function() {
  $('#html-pourcent').html('25%');
},2800);