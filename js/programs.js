var selectedFilter = "Filters";
var selectedGuest = "";
var selectedSeries = [];
var selectedDate = "";
var selectedMonth = "";
var selectedYear = "";
var gotSeriesList = false;

// filters dropdown taken from main.js in haventoday
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

function bindCheckboxEvent(){
	$('.checkbox').unbind('click');
	$('.checkbox').click(function(){
		if ($(this).hasClass('on')){
			$(this).removeClass('on');
			var index = selectedSeries.indexOf($(this).data('slug'));
			if (index > -1) {
				selectedSeries.splice(index, 1);
			}
		}
		else{
			$(this).addClass('on');
			selectedSeries.push($(this).data('slug'));
		}
	});
}

function printCheckboxes(searchResults){
	var $checkboxHTML = "";
	for(i=0;i<searchResults.length;i++){
		$checkboxHTML = '<div class="checkbox" data-slug="' + searchResults[i].name.toLowerCase() + '"><span><span>select</span></span>' + searchResults[i].name + '</div>'
		$('.section.archive.filters .checkboxes').append($checkboxHTML);
	}
}

function getCategoriesList(category_filter) {
	var $getAllCategoriesUrl = '/wp-content/themes/haventomorrow/program-search.php';
	var $categoriesResult = $.ajax({
		type: "POST",
		url: $getAllCategoriesUrl,
		data: {
			ftype: "categories",
			categoriesfilter: category_filter
		},
		success: (function (results) {
			//console.log(requests[count].statusText);
			$('.section.archive.filters .checkboxes .loadingMore').fadeOut(function(){$(this).remove();});
			$('.section.archive.filters .checkboxes .loading').fadeOut(function() {$(this).remove();});
			if (results != ""){
				gotCategoriesList = true;
				var searchResults = jQuery.parseJSON(results);
				//printCheckboxes(searchResults);
				resetResultByCategoryOnly(searchResults);
				bindCheckboxEvent();
			}
			//else {
			//	$('#noSearchResults').show();
			//	$('#noSearchResults').append('<div class="sssCount">0 Results for <span>' + ministry.toUpperCase() + '</span> Category.</div>');
			//}
		})
	})
}

function getSeriesList(series_filter) {
	var $getAllSeriesUrl = '/wp-content/themes/haventomorrow/program-search.php';
	var $seriesResult = $.ajax({
		type: "POST",
		url: $getAllSeriesUrl,
		data: {
			ftype: "series",
			seriesfilter: series_filter
		},
		success: (function (results) {
			//console.log(requests[count].statusText);
			$('.section.archive.filters .checkboxes .loadingMore').fadeOut(function(){$(this).remove();});
			$('.section.archive.filters .checkboxes .loading').fadeOut(function() {$(this).remove();});
			if (results != ""){
				gotSeriesList = true;
				var searchResults = jQuery.parseJSON(results);
				//printCheckboxes(searchResults);
				resetResultBySeriesOnly(searchResults);
				bindCheckboxEvent();
			}
			//else {
			//	$('#noSearchResults').show();
			//	$('#noSearchResults').append('<div class="sssCount">0 Results for <span>' + ministry.toUpperCase() + '</span> Category.</div>');
			//}
		})
	})
}

function searchPrograms(searchTerm, thisSelectedFilter, filterTerms) {
	// console.log('search programs')
	// console.log(searchTerm, thisSelectedFilter, filterTerms)
	$('#guestFilters').hide();
	$('#dateFilters').hide();
	$('#mainFilters').show();
	if (thisSelectedFilter != "categoryid"){
		$('.section.archive.filters').hide();
		$('#mainFilters').append('<div class="loading"><img src="/wp-content/themes/haventomorrow/assets/img/ajax-loader-search-white.gif" alt="loading..."></div>');
	}
	else {
		$('.section.archive.filters .checkboxes').append('<div class="loading"><img src="/wp-content/themes/haventomorrow/assets/img/ajax-loader-search-white.gif" alt="loading..."></div>');
	}

	var $getAllSeriesUrl = '/wp-content/themes/haventomorrow/program-search.php';

	var $seriesResult = $.ajax({
		type: "POST",
		url: $getAllSeriesUrl,
		data: {
			ftype: "search",
			term: searchTerm,
			filter: thisSelectedFilter.toLowerCase(),
			fterms:	filterTerms
		},
		success: (function (results) {
			// console.log(results)
			//console.log(requests[count].statusText);
			if (thisSelectedFilter != "categoryid"){
				$('#mainFilters .loadingMore').fadeOut(function(){$(this).remove();});
				$('#mainFilters .loading').fadeOut(function() {$(this).remove();});
			}
			else {
				$('.section.archive.filters .checkboxes .loadingMore').fadeOut(function(){$(this).remove();});
				$('.section.archive.filters .checkboxes .loading').fadeOut(function() {$(this).remove();});
			}
			if (results != ""){
				var searchResults = jQuery.parseJSON(results);
				// console.log(searchResults)
				resetItemsList(searchResults, thisSelectedFilter, filterTerms);
			}
		})
	})
}

function resetItemsList(searchResults, thisSelectedFilter, filterTerms){
	switch (thisSelectedFilter.toLowerCase()){
		case "date":
			resetResultByDate(searchResults, filterTerms);
			break;
		case "guest":
			resetResultByGuest(searchResults);
			break;
		case "categoryid":
		case "series":
			resetResultBySeries(searchResults);
			break;
		default:
			resetResultByTerm(searchResults);
			break;
	}
	$('.items').show();
}

function getHTMLResultByCategoryID(searchResults, filterTerms){
	$divItemsHTML = "";
	for(i=0;i<searchResults.length;i++){
		$divItemsHTML = $divItemsHTML + '<div class="itemResult">';
		if (searchResults[i].post_guest == ' '){
			$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '"><span>' + searchResults[i].post_date + '</span> ' + searchResults[i].post_title + ' <span>Part ' + searchResults[i].post_partnum + '</span></a>';
		}
		else {
			$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '"><span>' + searchResults[i].post_date + '</span> ' + searchResults[i].post_title + ' <span>Part ' + searchResults[i].post_partnum + ' with ' + searchResults[i].post_guest + '</span></a>';
		}
		$divItemsHTML = $divItemsHTML + '</div>';
	}
	return $divItemsHTML;
}

function resetResultByDate(searchResults, filterTerms){
	$('.items').empty();
	DisplayDateLinksBefore(filterTerms);
	DisplayThisMonthDate(filterTerms);
	$divItemsHTML = "";
	for(i=0;i<searchResults.length;i++){
		$divItemsHTML = $divItemsHTML + '<div class="itemResult">';
		if (searchResults[i].post_guest == ' '){
			$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '"><span>' + searchResults[i].post_date + '</span> ' + searchResults[i].post_title + ' <span>Part ' + searchResults[i].post_partnum + '</span></a>';
		}
		else {
			$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '"><span>' + searchResults[i].post_date + '</span> ' + searchResults[i].post_title + ' <span>Part ' + searchResults[i].post_partnum + ' with ' + searchResults[i].post_guest + '</span></a>';
		}
		$divItemsHTML = $divItemsHTML + '</div>';
	}
	$('.items').append($divItemsHTML);
	DisplayDateLinksAfter(filterTerms);
	DisplayYearLinks(filterTerms);
	$('.items').show();
}

function DisplayYearLinks(thisDate){
	$divItemsHTML = '<h3>Previous Years</h3><div class="years">';
	var d = new Date(thisDate);
	var currentDate = new Date();
	if(d.getFullYear() == currentDate.getFullYear()){
		$divItemsHTML = $divItemsHTML + d.getFullYear() + '<div class="yearDiv">|</div>';
	}
	else {
		for (i=currentDate.getFullYear();i>d.getFullYear();i--){
			if (i == currentDate.getFullYear()){
				$divItemsHTML = $divItemsHTML + '<a href="javascript:void;" id="monthLink" data-month="' + (currentDate.getMonth()+1) + '" data-year="' + i + '">' + i + '</a><div class="yearDiv">|</div>';
			}
			else {
				$divItemsHTML = $divItemsHTML + '<a href="javascript:void;" id="monthLink" data-month="12" data-year="' + i + '">' + i + '</a><div class="yearDiv">|</div>';
			}
		}
		$divItemsHTML = $divItemsHTML + d.getFullYear() + '<div class="yearDiv">|</div>';
	}
	for (i=d.getFullYear()-1;i>=currentDate.getFullYear()-10;i--){
		$divItemsHTML = $divItemsHTML + '<a href="javascript:void;" id="monthLink" data-month="12" data-year="' + i + '">' + i + '</a><div class="yearDiv">|</div>';
	}
	$divItemsHTML = $divItemsHTML + '</div>';
	$('.items').append($divItemsHTML);
}

function DisplayThisMonthDate(thisDate) {
	$divItemsHTML = "";
	var monthNames = ["January", "February", "March", "April", "May", "June",
						"July", "August", "September", "October", "November", "December"];
	var d = new Date(thisDate);
	$divItemsHTML = $divItemsHTML + '<h2>';
	$divItemsHTML = $divItemsHTML + monthNames[d.getMonth()] + ', ' + d.getFullYear();
	$divItemsHTML = $divItemsHTML + '</h2><hr />';
	$('.items').append($divItemsHTML);
}

function DisplayDateLinksBefore(thisDate) {
	$divItemsHTML = "";
	var monthNames = ["January", "February", "March", "April", "May", "June",
						"July", "August", "September", "October", "November", "December"];

	var d = new Date(thisDate);
	var currentDate = new Date();
	var currentMonth = currentDate.getMonth();

	if (d.getYear() == currentDate.getYear()){
		if (d.getMonth() < currentMonth){
			for (i=currentMonth;i>=d.getMonth()+1;i--){
				$divItemsHTML = $divItemsHTML + '<h2>';
				$divItemsHTML = $divItemsHTML + '<a href="javascript:void;"  id="monthLink" data-month="' + (i+1) + '" data-year="' + d.getFullYear() + '">' + monthNames[i] + ' ' + d.getFullYear() + '</a>';
				$divItemsHTML = $divItemsHTML + '</h2><hr />';
			}
			$('.items').append($divItemsHTML);
		}
	}
	else {
		if (d.getMonth() < 11){
			for (i=11;i>=d.getMonth()+1;i--){
				$divItemsHTML = $divItemsHTML + '<h2>';
				$divItemsHTML = $divItemsHTML + '<a href="javascript:void;"  id="monthLink" data-month="' + (i+1) + '" data-year="' + d.getFullYear() + '">' + monthNames[i] + ' ' + d.getFullYear() + '</a>';
				$divItemsHTML = $divItemsHTML + '</h2><hr />';
			}
			$('.items').append($divItemsHTML);
		}
	}

}

function DisplayDateLinksAfter(thisDate) {
	$divItemsHTML = "";
	var monthNames = ["January", "February", "March", "April", "May", "June",
						"July", "August", "September", "October", "November", "December"];

	var d = new Date(thisDate);
	var currentDate = new Date();
	var monthToUse = d.getMonth();

	if (d.getYear() == currentDate.getYear()){
		if (d.getMonth() > currentDate.getMonth()){
			monthToUse = currentDate.getMonth();
		}
	}

	if (monthToUse > 0){
		for (i=monthToUse-1;i>=0;i--){
			$divItemsHTML = $divItemsHTML + '<h2>';
			$divItemsHTML = $divItemsHTML + '<a href="javascript:void;" id="monthLink" data-month="' + (i+1) + '" data-year="' + d.getFullYear() + '">' + monthNames[i] + ' ' + d.getFullYear() + '</a>';
			$divItemsHTML = $divItemsHTML + '</h2><hr />';
		}
		$('.items').append($divItemsHTML);
	}
}

function resetResultBySeries(searchResults){
	// console.log('resetResultBySeries')
	//$('.items').empty();
	$divItemsHTML = "";
	for(i=0;i<searchResults.length;i++){
		//$divItemsHTML = $divItemsHTML + '<h2 class="progResults">';
		if (searchResults[i].post_guest == ' ') {
			$divItemsHTML = $divItemsHTML + '<BR /><a href="/series/' + searchResults[i].series_slug.toLowerCase() + '">' + searchResults[i].post_date + ' <span class="title">' + searchResults[i].post_title + '</span> Part ' + searchResults[i].post_partnum + '</a>';
		}
		else {
			$divItemsHTML = $divItemsHTML + '<BR /><a href="/series/' + searchResults[i].series_slug.toLowerCase() + '">' + searchResults[i].post_date + ' <span class="title">' + searchResults[i].post_title + '</span> Part ' + searchResults[i].post_partnum + ' with ' + searchResults[i].post_guest + '</a>';
		}
		//$divItemsHTML = $divItemsHTML + '</h2>';
	}
	$('.progResults').append($divItemsHTML);
	//$('.items').show();
}

function resetResultBySeriesOnly(searchResults){
	// console.log('resetResultBySeriesOnly')
	$('.items').empty();
	$divItemsHTML = "";
	for(i=0;i<searchResults.length;i++){
		$divItemsHTML = $divItemsHTML + '<h2 class="progResults">';
		$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '"><span class="title">' + searchResults[i].post_title + '</span></a>';
		$divItemsHTML = $divItemsHTML + '</h2>';
	}
	$('.items').append($divItemsHTML);
	$('.items').show();
}

function resetResultByCategoryOnly(searchResults){
	// console.log('resetResultByCategoryOnly')
	$('.items').empty();
	$divItemsHTML = "";
	$divItemsHTML = $divItemsHTML + '<h2 class="progResults">';
	for(i=0;i<searchResults.length;i++){
		$divItemsHTML = $divItemsHTML + '<div>';
		$divItemsHTML = $divItemsHTML + '<a href="javascript:void;" id="categoryLink" data-categoryid="' + searchResults[i].post_ID + '" ><span class="title">' + searchResults[i].post_title + '</span></a>';
		$divItemsHTML = $divItemsHTML + '</div>';
	}
	$divItemsHTML = $divItemsHTML + '</h2>';
	$('.items').append($divItemsHTML);
	$('.items').show();
}

function resetResultByGuest(searchResults){
	// console.log('resetResultByGuest')
	$('.items').empty();
	$divItemsHTML = "";
	for(i=0;i<searchResults.length;i++){
		$divItemsHTML = $divItemsHTML + '<h2 class="progResults">';
		if (searchResults[i].post_guest == ' ') {
			$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '">' + searchResults[i].post_date + ' <span class="title">' + searchResults[i].post_title + '</span> Part ' + searchResults[i].post_partnum + '</a>';
		}
		else {
			$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '">' + searchResults[i].post_date + ' <span class="title">' + searchResults[i].post_title + '</span> Part ' + searchResults[i].post_partnum + ' with ' + searchResults[i].post_guest + '</a>';
		}
		$divItemsHTML = $divItemsHTML + '</h2>';
	}
	$('.items').append($divItemsHTML);
	$('.items').show();
}

function resetResultByTerm(searchResults){
	// console.log('resetResultByTerm')
	// console.log(searchResults)
	$('.items').empty();
	$divItemsHTML = "";
	for(i=0;i<searchResults.length;i++){
		$divItemsHTML = $divItemsHTML + '<h2 class="progResults">';
		if (searchResults[i].post_guest == ' ') {
			$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '">' + searchResults[i].post_date + ' <span class="title">' + searchResults[i].post_title + '</span> Part ' + searchResults[i].post_partnum + '</a>';
		}
		else {
			$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '">' + searchResults[i].post_date + ' <span class="title">' + searchResults[i].post_title + '</span> Part ' + searchResults[i].post_partnum + ' with ' + searchResults[i].post_guest + '</a>';
		}
		$divItemsHTML = $divItemsHTML + '</h2>';
	}
	$('.items').append($divItemsHTML);
	$('.items').show();
}

function resetResultByTermOLD(searchResults){
	$('.items .inner').empty();
	$divItemsHTML = '<div class="swiper-container">';
	$divItemsHTML = $divItemsHTML + '<div class="swiper-wrapper">';

	for(i=0;i<searchResults.length;i++){
		$divItemsHTML = $divItemsHTML + '<div class="swiper-slide">';
		$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '"><img src="' + searchResults[i].post_imageurl + '" /></a>';
		$divItemsHTML = $divItemsHTML + '</div>';

		// 'post_id' => $post->ID,
		// 'post_title' => $post->post_title,
		// 'post_series' => $post->name,
		// 'post_imageurl' => $field["value"]["url"]
	}

	$divItemsHTML = $divItemsHTML + '</div>';
	$divItemsHTML = $divItemsHTML + '</div>';
	$('.items .inner').append($divItemsHTML);

	items = new Swiper('.items .swiper-container', {
		nextButton: '.items .arrowLeft',
		prevButton: '.items .arrowRight',
		slidesPerView: 3,
		slidesPerColumn: 2,
		paginationClickable: true,
		spaceBetween: 30,
	});
	$('.items').show();
}

function PlayProgramAudio(podcastID){
	var havenAudio = window.open('http://haven.streamon.fm/program-e-' + podcastID + '.000000', 'havenplayer', 'status=yes, resizable=yes', 'havenAudioWnd');
	havenAudio.focus();
}

$(document).ready(function(){
	if ($('#hiddenTerm').length){
		selectedFilter = "Filters";
		selectedTerm = $('#hiddenTerm').data('term');
		$('#textSearch').val(selectedTerm);
		searchPrograms(selectedTerm,selectedFilter,"");
	}

	if ($('#hiddenFilter').length){
		selectedFilter = $('#hiddenFilter').data('filter');
		if (selectedFilter == '') {
			$('#mainFilter').find('.current').text('Filter');
		} else {
			$('#mainFilter').find('.current').text(selectedFilter);
		}
		switch (selectedFilter){
			case "Date":
				//$('#mainFilters').hide();
				$('#guestFilters').hide();
				$('.section.archive.filters').hide();
				//$('#dateFilters').show();
				$('.content .items').hide();
				var d = new Date();
				var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
				searchPrograms($('#textSearch')[0].value,selectedFilter,strDate);
				break;
			case "Guest":
				//$('#mainFilters').hide();
				$('#dateFilters').hide();
				$('.section.archive.filters').hide();
				$('#guestFilters').show();
				break;
			case "Category":
				$('.section.archive.filters').show();
				$('.section.archive.filters .checkboxes').empty();
				$('.section.archive.filters .checkboxes').append('<div class="loading"><img src="/wp-content/themes/haventomorrow/assets/img/ajax-loader-search-white.gif" alt="loading..."></div>');
				getCategoriesList('');
				break;
			case "Series":
				$('.section.archive.filters').show();
				$('.section.archive.filters .checkboxes').empty();
				$('.section.archive.filters .checkboxes').append('<div class="loading"><img src="/wp-content/themes/haventomorrow/assets/img/ajax-loader-search-white.gif" alt="loading..."></div>');
				getSeriesList('');
				break;
		}
	}

	$('.items').on('click','#monthLink', function(){
		//alert($(this).data('year') + '-' + $(this).data('month') + '-01');
		$('#guestFilters').hide();
		$('.section.archive.filters').hide();
		//$('#dateFilters').show();
		$('.content .items').hide();
		var strDate = $(this).data('year') + '-' + $(this).data('month') + '-02';
		searchPrograms($('#textSearch')[0].value,selectedFilter,strDate);
	});

	$('.items').on('click','#categoryLink', function(){
		// console.log('categoryLink clicked')
		var thisFilter = "categoryid";
		var strCategoryID = $(this).data('categoryid');
		var thisObject = $(this);

		$('.section.archive.filters .checkboxes').append('<div class="loading"><img src="/wp-content/themes/haventomorrow/assets/img/ajax-loader-search-white.gif" alt="loading..."></div>');

		var $getAllSeriesUrl = '/wp-content/themes/haventomorrow/program-search.php';

		var $seriesResult = $.ajax({
			type: "POST",
			url: $getAllSeriesUrl,
			data: {
				ftype: "search",
				term: $('#textSearch')[0].value,
				filter: thisFilter.toLowerCase(),
				fterms:	strCategoryID
			},
			success: (function (results) {
				$('.section.archive.filters .checkboxes .loadingMore').fadeOut(function(){$(this).remove();});
				$('.section.archive.filters .checkboxes .loading').fadeOut(function() {$(this).remove();});
				if (results != ""){
					thisObject.siblings("div").remove();
					var searchResults = jQuery.parseJSON(results);
					$divItemsHTML = '';
					for(i=0;i<searchResults.length;i++){
						if (searchResults[i].post_guest == ' ') {
							$divItemsHTML = $divItemsHTML + '<h2 class="progResults">';
							$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '">' + searchResults[i].post_date + ' <span class="title">' + searchResults[i].post_title + '</span> Part ' + searchResults[i].post_partnum + '</a>';
							$divItemsHTML = $divItemsHTML + '</h2>';
						}
						else {
							$divItemsHTML = $divItemsHTML + '<h2 class="progResults">';
							$divItemsHTML = $divItemsHTML + '<a href="/series/' + searchResults[i].series_slug.toLowerCase() + '">' + searchResults[i].post_date + ' <span class="title">' + searchResults[i].post_title + '</span> Part ' + searchResults[i].post_partnum + ' with ' + searchResults[i].post_guest + '</a>';
							$divItemsHTML = $divItemsHTML + '</h2>';
						}
					}
					thisObject.parent().append($divItemsHTML);
				}
			})
		})

	});

	$('#btnProgramSearch').click(function(){
		selectedFilter = "Filters";
		searchPrograms($('#textSearch')[0].value,selectedFilter,"");
	});

	$('#textSearch').on('keydown', function(e) {
		if (e.keyCode === 13) {
			selectedFilter = "Filters";
			searchPrograms($('#textSearch')[0].value,selectedFilter,"");
		}
	})

	$('#btnSearchArchive').click(function(){
		window.location.href = '/programs/program-archive/?term=' + $('#textSearch')[0].value;
	});

	$('#btnClearFilters').click(function(){
		selectedFilter = "Filters";
		selectedGuest = "";
		selectedSeries = [];
		selectedDate = "";
		selectedMonth = "";
		selectedYear = "";
		$('#textSearch').val('');
		$('#guestFilters').hide();
		$('.section.archive.filters').hide();
		$('#dateFilters').hide();
	});

	$('#archiveFilter ul li').click(function(){
		//alert($(this).data('name'));
		$('#archiveFilter').find('ul').slideUp();
		$('#archiveFilter').find('.current').text($(this).data('name'));
		selectedFilter = $(this).data('name');
		window.location.href = '/programs/program-archive/?filter=' + $(this).data('name');
	});

	// $('#mainFilter').click(function(){
		// $('#mainFilter').find('ul').slideDown();
	// });

	$('#mainFilter ul li').click(function(){
		if (selectedFilter != $(this).data('name')){
			$('.items').empty();
			$('.items').hide();
		}
		//alert($(this).data('name'));
		$('#mainFilter').find('ul').slideUp();
		$('#mainFilter').find('.current').text($(this).data('name'));
		selectedFilter = $(this).data('name');
		switch ($(this).data('name')){
			case "Date":
				//$('#mainFilters').hide();
				$('#guestFilters').hide();
				$('.section.archive.filters').hide();
				//$('#dateFilters').show();
				$('.content .items').hide();
				var d = new Date();
				var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
				searchPrograms($('#textSearch')[0].value,selectedFilter,strDate);
				break;
			case "Guest":
				//$('#mainFilters').hide();
				$('#dateFilters').hide();
				$('.section.archive.filters').hide();
				$('#guestFilters').show();
				break;
			case "Category":
				$('.section.archive.filters').show();
				$('.section.archive.filters .checkboxes').empty();
				$('.section.archive.filters .checkboxes').append('<div class="loading"><img src="/wp-content/themes/haventomorrow/assets/img/ajax-loader-search-white.gif" alt="loading..."></div>');
				getCategoriesList('');
				break;
			case "Series":
				$('.section.archive.filters').show();
				$('.section.archive.filters .checkboxes').empty();
				$('.section.archive.filters .checkboxes').append('<div class="loading"><img src="/wp-content/themes/haventomorrow/assets/img/ajax-loader-search-white.gif" alt="loading..."></div>');
				getSeriesList('');
				break;
		}
		//this_events_category = $(this).data('slug');
		//events_page = 1;
		//$divEventId = 1;
		//$('#searchEventResults').empty();
		//getEventResults(events_page, $(this).data('locid'), $(this).data('slug'));
		//events_page++;
	});

	$('[id=filter_0]').click(function() {
		var thisFilterValue = $(this).data('filtervalue');
		$('.section.archive.filters .checkboxes').empty();
		$('.section.archive.filters .checkboxes').append('<div class="loading"><img src="/wp-content/themes/haventomorrow/assets/img/ajax-loader-search-white.gif" alt="loading..."></div>');
		switch (selectedFilter){
			case "Category":
				getCategoriesList(thisFilterValue);
				break;
			case "Series":
				getSeriesList(thisFilterValue);
				break;
		}
	});

	$('#guestFilter ul li').click(function(){
		$('#guestFilter').find('ul').slideUp();
		$('#guestFilter').find('.current').text($(this).data('name'));
		selectedGuest = $(this).data('slug');
		searchPrograms($('#textSearch')[0].value,selectedFilter,selectedGuest);
	});

	$('#dateFilter ul li').click(function(){
		$('#dateFilter').find('ul').slideUp();
		$('#dateFilter').find('.current').text($(this).data('name'));
		selectedDate = $(this).data('slug');
	});

	$('#monthFilter ul li').click(function(){
		$('#monthFilter').find('ul').slideUp();
		$('#monthFilter').find('.current').text($(this).data('name'));
		selectedMonth = $(this).data('slug');
	});

	$('#yearFilter ul li').click(function(){
		$('#yearFilter').find('ul').slideUp();
		$('#yearFilter').find('.current').text($(this).data('name'));
		selectedYear = $(this).data('slug');
	});

	$('.outlineBtn').click(function(){
		$('.section.archive.filters').hide();
		$('#dateFilters').hide();
		$('#guestFilters').hide();
		$('#mainFilters').show();
	});

	$('.button.trans.play').click(function(){
		// if($(window).width() < 767){
			PlayProgramAudio($(this).data('podcast'));
		// } else {
			// OpenPlayProgramAudio($(this).data('podcast'), $(this), true); //FUNCTION LOCATED IN sidebar-player.php
		// }
	});

	$('.button.trans.download').click(function(){
		var link = document.createElement('a');
		link.href = $(this).data('fname');
		link.download = 'Download.mp3';
		document.body.appendChild(link);
		link.click();
	});

	$('#btnProgramImage').click(function(){
		if($(window).width() < 767){
			PlayProgramAudio($(this).data('podcast'));
		} else {
			OpenPlayProgramAudio($(this).data('podcast'), $(this), true); //FUNCTION LOCATED IN sidebar-player.php
		}
	});

	// items = new Swiper('.items .swiper-container', {
	// 	nextButton: '.items .arrowLeft',
	// 	prevButton: '.items .arrowRight',
	// 	slidesPerView: 3,
	// 	slidesPerColumn: 2,
	// 	paginationClickable: true,
	// 	spaceBetween: 30,
	// });
});
