$(function() {
	
	media_player_open = localStorage.getItem("streamPodcast");
	
	if(media_player_open.length > 0){
		
		if($('.mediaPlayerBottom:visible')){
			$('.topBar').css('top','130px');
			$('.mobileTopBar').css('top','130px');
			$('.mobileHeader').css('top','170px');
			$('.mobileNav').css('top','170px');
			$('.mainContainer').css('top','170px');
			$('.drop').css('top','170px');
		} else {
			$('.topBar').css('top','40px');
			$('.mobileTopBar').css('top','40px');
			$('.mobileHeader').css('top','80px');
			$('.mobileNav').css('top','80px');
			$('.mainContainer').css('top','80px');
			$('.drop').css('top','80px');
		}
	} else {
		
	}
	
	wpMediaElement();
	
});

$('html,body').css('overflow','initial');

$('.mobileBtn').click(function() {
	if (mobileOpen) {
		closeMobile();
	} else {
		closeDropDowns();
		openMobile();
	}
});

