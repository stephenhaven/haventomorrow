<?php
// Test comment - Something

$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-config.php';
include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';

$function_called = strtolower($_POST['ftype']);
$search_term = strtolower($_POST['term']);
$filter_used = strtolower($_POST['filter']);
$filter_terms = strtolower($_POST['fterms']);
$series_filter = strtolower($_POST['seriesfilter']);
$categories_filter = strtolower($_POST['categoriesfilter']);

switch ($function_called){
	case "categories":
		getAllCategories($categories_filter);
		break;
	case "series":
		getAllSeries($series_filter);
		break;
	case "guest":
		getAllGuests();
		break;
	case "search":
		if ($filter_used == "categoryid"){
			searchByCategoryID($search_term, $filter_terms);
		}
		if ($filter_used == "series"){
			searchBySeries($search_term, $filter_terms);
		}
		if ($filter_used == "guest"){
			searchByGuest($search_term, $filter_terms);
		}
		if ($filter_used == "date"){
			searchByDate($search_term, $filter_terms);
		}
		if ($filter_used == "filters"){
			searchByTerm($search_term);
		}
		break;
}

function getAllSeries($series_filter){
	global $wpdb;

	if ($series_filter == ''){
		$filterQuery = "AND b.name regexp '^[0-9]+' ";
	}
	else {
		$filterQuery = "AND b.name LIKE '" . $series_filter . "%' ";
	}

	$qDB_AllSeries = "select a.term_taxonomy_id AS post_ID, b.name AS post_title, b.slug AS series_slug
	from " . DB_NAME . ".wp_ht_term_taxonomy a
	JOIN " . DB_NAME . ".wp_ht_terms b ON a.term_id = b.term_id
	where a.taxonomy = 'series' " . $filterQuery . "ORDER BY b.name;";

	$rDB_AllSeries = $wpdb->get_results($qDB_AllSeries);

	echo json_encode($rDB_AllSeries);
}

function getAllCategories($categories_filter){
	global $wpdb;

	if ($categories_filter == ''){
		$filterQuery = "AND b.name regexp '^[0-9]+' ";
	}
	else {
		$filterQuery = "AND b.name LIKE '" . $categories_filter . "%' ";
	}

	$qDB_AllCategories = "select a.term_taxonomy_id AS post_ID, b.name AS post_title, b.slug AS series_slug
	from " . DB_NAME . ".wp_ht_term_taxonomy a
	JOIN " . DB_NAME . ".wp_ht_terms b ON a.term_id = b.term_id
	where a.taxonomy = 'category' " . $filterQuery . "ORDER BY b.name;";

	$rDB_AllCategories = $wpdb->get_results($qDB_AllCategories);

	echo json_encode($rDB_AllCategories);
}

function title_filter($where, $wp_query){
    global $wpdb;

    if($search_term = $wp_query->get( 'search_prod_title' )){
        $search_term = $wpdb->esc_like($search_term);
        $search_term = ' \'%' . $search_term . '%\'';
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE '.$search_term;
    }

    return $where;
}

function searchByCategoryID($searchTerm, $filterTerms){
	global $wpdb;

	$qDB_ProgramSearch = "SELECT DISTINCT p.ID, p.post_title, p.post_date, MAX(c.name) AS name, MAX(c.slug) AS slug, p.image_url, p.guest_name, p.part_num
FROM (
SELECT DISTINCT p.ID, pm1.meta_value AS post_title, MAX(p.post_date) as post_date, pm.meta_value AS image_url, MAX(c2.name) AS guest_name, pm3.meta_value AS part_num 
FROM " . DB_NAME . ".wp_ht_posts p 
JOIN " . DB_NAME . ".wp_ht_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'program_title'
JOIN " . DB_NAME . ".wp_ht_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'program_image'
JOIN " . DB_NAME . ".wp_ht_postmeta pm3 ON p.ID = pm3.post_id AND pm3.meta_key = 'part' LEFT JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
LEFT JOIN " . DB_NAME . ".wp_ht_term_taxonomy a2 ON a2.term_taxonomy_id = txr.term_taxonomy_id AND a2.taxonomy = 'speaker'
LEFT JOIN " . DB_NAME . ".wp_ht_terms c2 ON a2.term_id = c2.term_id
WHERE p.ID IN(
SELECT DISTINCT MIN(p.ID) FROM " . DB_NAME . ".wp_ht_posts p
JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
JOIN " . DB_NAME . ".wp_ht_term_taxonomy a2 ON a2.term_taxonomy_id = txr.term_taxonomy_id
WHERE p.post_type = 'programs' AND p.post_status = 'publish' AND txr.term_taxonomy_id = " . $filterTerms . "
GROUP BY p.post_date
 ) GROUP BY p.ID
) AS p
JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
JOIN " . DB_NAME . ".wp_ht_term_taxonomy a ON a.term_taxonomy_id = txr.term_taxonomy_id AND a.taxonomy = 'series'
JOIN " . DB_NAME . ".wp_ht_terms c ON a.term_id = c.term_id GROUP BY p.ID
ORDER BY p.post_date DESC";

	$rDB_Programs = $wpdb->get_results($qDB_ProgramSearch);

	$results_array = array();

	foreach($rDB_Programs as $post){
		$thisImageURL = $post->image_url;
		if($thisImageURL == ''){
			$thisImageURL = '/wp-content/themes/haventomorrow/assets/img/missing.png';
		}
		$timestamp = $post->post_date;
		$postDatetime = explode(" ",$timestamp);
		$postDateOnly = $postDatetime[0];
		$tile = array(
			'post_id' => $post->ID,
			'post_title' => $post->post_title,
			'post_date'  => $postDateOnly,
			'post_series' => $post->name,
			'series_slug' => $post->slug,
			'post_imageurl' => $thisImageURL,
			'post_partnum'	=> $post->part_num,
			'post_guest'	=> ($post->guest_name == '-- Select a Guest --' || $post->guest_name == null ? ' ' : $post->guest_name)
		);

		array_push($results_array, $tile);
	}

	echo json_encode($results_array);
}

function searchBySeries($searchTerm, $filterTerms){
	global $wpdb;

	$qDB_TitleMatch = "";
	$qDB_SeriesMatch = "";
	if ($searchTerm != ""){
		$qDB_TitleMatch = " AND pm1.meta_value like '%" . $searchTerm . "%'";
		if ($filterTerms != ""){
			$qDB_SeriesMatch = " AND c2.name IN ('" . $filterTerms . "')";
		}
	}
	else {
		if ($filterTerms != ""){
			$qDB_SeriesMatch = " AND c2.name IN ('" . $filterTerms . "')";
		}
	}

	$qDB_ProgramSearch = "SELECT DISTINCT p.ID, p.post_title, p.post_date, MAX(c.name) AS name, MAX(c.slug) AS slug, p.image_url, p.guest_name, p.part_num
FROM
(
   SELECT DISTINCT
    p.ID,
    pm1.meta_value AS post_title,
    MAX(p.post_date) as post_date,
    pm.meta_value AS image_url,
    MAX(c2.name) AS guest_name,
    pm3.meta_value AS part_num
FROM
    " . DB_NAME . ".wp_ht_posts p
JOIN " . DB_NAME . ".wp_ht_postmeta pm1
ON
    p.ID = pm1.post_id AND pm1.meta_key = 'program_title’
JOIN " . DB_NAME . ".wp_ht_postmeta pm
ON
    p.ID = pm.post_id AND pm.meta_key = 'program_image'
JOIN " . DB_NAME . ".wp_ht_postmeta pm3
ON
    p.ID = pm3.post_id AND pm3.meta_key = 'part'
LEFT JOIN " . DB_NAME . ".wp_ht_term_relationships txr
ON
    p.ID = txr.object_id
LEFT JOIN " . DB_NAME . ".wp_ht_term_taxonomy a2
ON
    a2.term_taxonomy_id = txr.term_taxonomy_id AND a2.taxonomy = 'speaker'
LEFT JOIN " . DB_NAME . ".wp_ht_terms c2
ON
    a2.term_id = c2.term_id
WHERE
    p.post_type = 'programs' AND p.post_status = 'publish'" . $qDB_TitleMatch . $qDB_DateMatch . "
GROUP BY p.ID
    ) AS p
JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
JOIN " . DB_NAME . ".wp_ht_term_taxonomy a ON a.term_taxonomy_id = txr.term_taxonomy_id AND a.taxonomy = 'series'
JOIN " . DB_NAME . ".wp_ht_terms c on a.term_id = c.term_id
GROUP BY p.ID
ORDER BY p.post_date DESC";

	$rDB_Programs = $wpdb->get_results($qDB_ProgramSearch);

	$results_array = array();

	foreach($rDB_Programs as $post){
		$thisImageURL = $post->image_url;
		if($thisImageURL == ''){
			$thisImageURL = '/wp-content/themes/haventomorrow/assets/img/missing.png';
		}
		$timestamp = $post->post_date;
		$postDatetime = explode(" ",$timestamp);
		$postDateOnly = $postDatetime[0];
		$tile = array(
			'post_id' => $post->ID,
			'post_title' => $post->post_title,
			'post_date'  => $postDateOnly,
			'post_series' => $post->name,
			'series_slug' => $post->slug,
			'post_imageurl' => $thisImageURL,
			'post_partnum'	=> $post->part_num,
			'post_guest'	=> ($post->guest_name == '-- Select a Guest --' ? ' ' : $post->guest_name)
		);

		array_push($results_array, $tile);
	}

	echo json_encode($results_array);
}

function searchByGuest($searchTerm, $guestName){
	global $wpdb;

	$qDB_ProgramSearch = "SELECT DISTINCT p.ID, p.post_title, p.post_date, c.name, c.slug,
	pm.meta_value AS image_url, pm3.meta_value AS part_num
	FROM " . DB_NAME . ".wp_ht_posts p
	JOIN " . DB_NAME . ".wp_ht_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'program_image'
	JOIN " . DB_NAME . ".wp_ht_postmeta pm2 ON p.ID = pm2.post_id
	JOIN " . DB_NAME . ".wp_ht_postmeta pm3 ON p.ID = pm3.post_id AND pm3.meta_key = 'part'
	JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
	JOIN " . DB_NAME . ".wp_ht_term_taxonomy a ON a.term_taxonomy_id = txr.term_taxonomy_id AND a.taxonomy = 'series'
	JOIN " . DB_NAME . ".wp_ht_terms c ON a.term_id = c.term_id
	WHERE p.post_type='programs' AND p.post_status='publish'";

	if ($searchTerm != ""){
		$qDB_ProgramSearch = $qDB_ProgramSearch . " AND p.post_title like '%" . $searchTerm . "%'";
		if ($guestName != ""){
			$qDB_ProgramSearch = $qDB_ProgramSearch . " AND pm2.meta_key = 'guest_speaker' AND pm2.meta_value = '" . $guestName . "'";
		}
	}
	else {
		if ($guestName != ""){
			$qDB_ProgramSearch = $qDB_ProgramSearch . " AND m.meta_key = 'guest_speaker' AND m.meta_value = '" . $guestName . "'";
		}
	}
	$qDB_ProgramSearch = $qDB_ProgramSearch . " ORDER BY p.post_date DESC;";

	$rDB_Programs = $wpdb->get_results($qDB_ProgramSearch);

	$results_array = array();

	foreach($rDB_Programs as $post){
		$thisImageURL = $post->image_url;
		if($thisImageURL == ''){
			$thisImageURL = '/wp-content/themes/haventomorrow/assets/img/missing.png';
		}
		$timestamp = $post->post_date;
		$postDatetime = explode(" ",$timestamp);
		$postDateOnly = $postDatetime[0];
		$tile = array(
			'post_id' => $post->ID,
			'post_title' => $post->post_title,
			'post_date'  => $postDateOnly,
			'post_series' => $post->name,
			'series_slug' => $post->slug,
			'post_imageurl' => $thisImageURL,
			'post_partnum'	=> $post->part_num,
			'post_guest'	=> ($post->guest_name == '-- Select a Guest --' ? ' ' : $post->guest_name)
		);

		array_push($results_array, $tile);
	}

	echo json_encode($results_array);
}

function searchByDate($searchTerm, $dateString){
	global $wpdb;

	$qDB_TitleMatch = "";
	$qDB_DateMatch = "";

	if ($searchTerm != ""){
		$qDB_TitleMatch = " AND pm1.meta_value like '%" . $searchTerm . "%'";
		if ($dateString != ""){
			$qDB_DateMatch = " AND YEAR(p.post_date) = YEAR('" . $dateString . "') AND MONTH(p.post_date) = MONTH('" . $dateString . "')";
		}
	}
	else {
		if ($dateString != ""){
			$qDB_DateMatch = " AND YEAR(p.post_date) = YEAR('" . $dateString . "') AND MONTH(p.post_date) = MONTH('" . $dateString . "')";
		}
	}

	$qDB_ProgramSearch = "SELECT DISTINCT p.ID, p.post_title, p.post_date, MAX(c.name) AS name, MAX(c.slug) AS slug, p.image_url, p.guest_name, p.part_num
FROM
(
   SELECT DISTINCT
    p.ID,
    pm1.meta_value AS post_title,
    MAX(p.post_date) as post_date,
    pm.meta_value AS image_url,
    MAX(c2.name) AS guest_name,
    pm3.meta_value AS part_num
FROM
    " . DB_NAME . ".wp_ht_posts p
JOIN " . DB_NAME . ".wp_ht_postmeta pm1
ON
    p.ID = pm1.post_id AND pm1.meta_key = 'program_title'
JOIN " . DB_NAME . ".wp_ht_postmeta pm
ON
    p.ID = pm.post_id AND pm.meta_key = 'program_image'
JOIN " . DB_NAME . ".wp_ht_postmeta pm3
ON
    p.ID = pm3.post_id AND pm3.meta_key = 'part'
LEFT JOIN " . DB_NAME . ".wp_ht_term_relationships txr
ON
    p.ID = txr.object_id
LEFT JOIN " . DB_NAME . ".wp_ht_term_taxonomy a2
ON
    a2.term_taxonomy_id = txr.term_taxonomy_id AND a2.taxonomy = 'speaker'
LEFT JOIN " . DB_NAME . ".wp_ht_terms c2
ON
    a2.term_id = c2.term_id
WHERE
    p.post_type = 'programs' AND p.post_status = 'publish'" . $qDB_TitleMatch . $qDB_DateMatch . "
GROUP BY p.ID
    ) AS p
JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
JOIN " . DB_NAME . ".wp_ht_term_taxonomy a ON a.term_taxonomy_id = txr.term_taxonomy_id AND a.taxonomy = 'series'
JOIN " . DB_NAME . ".wp_ht_terms c on a.term_id = c.term_id
GROUP BY p.ID
ORDER BY p.post_date DESC";

	$rDB_Programs = $wpdb->get_results($qDB_ProgramSearch);

	$results_array = array();

	foreach($rDB_Programs as $post){
		$thisImageURL = $post->image_url;
		if($thisImageURL == ''){
			$thisImageURL = '/wp-content/themes/haventomorrow/assets/img/missing.png';
		}
		$timestamp = $post->post_date;
		$postDatetime = explode(" ",$timestamp);
		$postDateOnly = $postDatetime[0];
		$tile = array(
			'post_id' => $post->ID,
			'post_title' => $post->post_title,
			'post_date'  => $postDateOnly,
			'post_series' => $post->name,
			'name' => $post->name,
			'query' => $qDB_ProgramSearch,
			'series_slug' => $post->slug,
			'post_imageurl' => $thisImageURL,
			'post_partnum'	=> $post->part_num,
			'post_guest'	=> ($post->guest_name == '-- Select a Guest --' || $post->guest_name == null ? ' ' : $post->guest_name)
		);
		array_push($results_array, $tile);
	}

	echo json_encode($results_array);
}

function searchByTerm($searchTerm){
	global $wpdb;

	$qDB_TitleMatch = "";
	$qDB_TagMatch = "";

	if ($searchTerm != ""){
		$qDB_TitleMatch = " AND pm1.meta_value like '%" . $searchTerm . "%'";
		$qDB_TagMatch = " AND c2.name like '%" . $searchTerm . "%'";
	}

	$qDB_ProgramSearch = "SELECT DISTINCT r.ID, r.post_title, r.post_date, r.name, r.slug, r.image_url, r.guest_name, r.part_num
            FROM (
                    SELECT DISTINCT p.ID, p.post_title, p.post_date, MAX(c.name) AS name, MAX(c.slug) AS slug, p.image_url, p.guest_name, p.part_num
                        FROM (
                                SELECT DISTINCT p.ID, pm1.meta_value AS post_title, MAX(p.post_date) as post_date, pm.meta_value AS image_url, MAX(c2.name) AS guest_name, pm3.meta_value AS part_num
                                FROM " . DB_NAME . ".wp_ht_posts p
			JOIN " . DB_NAME . ".wp_ht_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'program_title'
                                JOIN " . DB_NAME . ".wp_ht_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'program_image'
                                JOIN " . DB_NAME . ".wp_ht_postmeta pm3 ON p.ID = pm3.post_id AND pm3.meta_key = 'part'
                                LEFT JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
                                LEFT JOIN " . DB_NAME . ".wp_ht_term_taxonomy a2 ON a2.term_taxonomy_id = txr.term_taxonomy_id AND a2.taxonomy = 'speaker'
                                LEFT JOIN " . DB_NAME . ".wp_ht_terms c2 ON a2.term_id = c2.term_id
                                WHERE p.post_type='programs' AND p.post_status='publish'" . $qDB_TitleMatch . "
			GROUP BY p.ID
                            ) AS p
                        JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
                        JOIN " . DB_NAME . ".wp_ht_term_taxonomy a ON a.term_taxonomy_id = txr.term_taxonomy_id AND a.taxonomy = 'series'
                        JOIN " . DB_NAME . ".wp_ht_terms c ON a.term_id = c.term_id
		  GROUP BY p.ID
                    UNION

                    SELECT DISTINCT p.ID, p.post_title, p.post_date, MAX(c.name) AS name, MAX(c.slug) AS slug, p.image_url, p.guest_name, p.part_num
                        FROM (
                                SELECT DISTINCT p.ID, pm1.meta_value AS post_title, MAX(p.post_date) as post_date, pm.meta_value AS image_url, MAX(c2.name) AS guest_name, pm3.meta_value AS part_num
                                FROM " . DB_NAME . ".wp_ht_posts p
			JOIN " . DB_NAME . ".wp_ht_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'program_title'
                                JOIN " . DB_NAME . ".wp_ht_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'program_image'
                                JOIN " . DB_NAME . ".wp_ht_postmeta pm3 ON p.ID = pm3.post_id AND pm3.meta_key = 'part'
                                LEFT JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
                                LEFT JOIN " . DB_NAME . ".wp_ht_term_taxonomy a2 ON a2.term_taxonomy_id = txr.term_taxonomy_id AND a2.taxonomy = 'speaker'
                                LEFT JOIN " . DB_NAME . ".wp_ht_terms c2 ON a2.term_id = c2.term_id
                                WHERE p.ID IN (
                                    SELECT MIN(p.ID)
                                        FROM " . DB_NAME . ".wp_ht_posts p
                                        JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
                                        JOIN " . DB_NAME . ".wp_ht_term_taxonomy a2 ON a2.term_taxonomy_id = txr.term_taxonomy_id AND a2.taxonomy = 'post_tag'
                                        JOIN " . DB_NAME . ".wp_ht_terms c2 ON a2.term_id = c2.term_id
                                        WHERE p.post_type='programs' AND p.post_status='publish' " . $qDB_TagMatch . "
				GROUP BY p.post_date
				)
			GROUP BY p.ID
                            ) AS p
                        JOIN " . DB_NAME . ".wp_ht_term_relationships txr ON p.ID = txr.object_id
                        JOIN " . DB_NAME . ".wp_ht_term_taxonomy a ON a.term_taxonomy_id = txr.term_taxonomy_id AND a.taxonomy = 'series'
                        JOIN " . DB_NAME . ".wp_ht_terms c ON a.term_id = c.term_id
		  GROUP BY p.ID
            ) AS r 
ORDER BY r.post_date DESC, r.part_num";

	$rDB_Programs = $wpdb->get_results($qDB_ProgramSearch);

	$results_array = array();

	foreach($rDB_Programs as $post){
		$thisImageURL = $post->image_url;
		if($thisImageURL == ''){
			$thisImageURL = '/wp-content/themes/haventomorrow/assets/img/missing.png';
		}

		$timestamp = $post->post_date;
		$postDatetime = explode(" ",$timestamp);
		$postDateOnly = $postDatetime[0];

		$tile = array(
			'post_id' => $post->ID,
			'post_title' => $post->post_title,
			'post_date'  => $postDateOnly,
			'post_series' => $post->name,
			'series_slug' => $post->slug,
			'post_imageurl' => $thisImageURL,
			'post_partnum'	=> $post->part_num,
			'post_guest'	=> ($post->guest_name == '-- Select a Guest --' || $post->guest_name == null ? ' ' : $post->guest_name)
		);
		array_push($results_array, $tile);
	}

	echo json_encode($results_array);

}

?>
