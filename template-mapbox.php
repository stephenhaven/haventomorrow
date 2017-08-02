<?php
/**
 * Template Name: Mapbox Template
 */

get_header();
get_template_part( 'template-parts/content', 'title' ); ?>

<section class="c-padding-75">
  <div class="container map">
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.31.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.31.0/mapbox-gl.css' rel='stylesheet' />
    <style>
      #map {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 100%;
      }
    </style>
  </head>
  <body>
    <div id='map'></div>
    <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiaGF2ZW50b2RheSIsImEiOiJjajVpYmtoNHkxdDJ1MndvMjlyOTVwOTB3In0.AMtahE06rTDqqwKEgkLihA'; // replace this with your access token
    var map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/haventoday/cj5tsg4ry4u2y2rrv15mw9w6y' // replace this with your style URL
    });
    // code from the next step will go here
    map.on('click', function(e) {
  var features = map.queryRenderedFeatures(e.point, {
    layers: ['haven-stations'] // replace this with the name of the layer
  });

  if (!features.length) {
    return;
  }

  var feature = features[0];

  var popup = new mapboxgl.Popup({ offset: [0, -15] })
    .setLngLat(feature.geometry.coordinates)
    .setHTML('<h3>' + feature.properties.City + '</h3><p>' + feature.properties.State + '</p>' + feature.properties.Program + '</p>'+ feature.properties.Station + '</p>'+ feature.properties.Frequency + '</p>' + feature.properties.Time + '</p>'+ feature.properties.Days + '</p>' )
    .setLngLat(feature.geometry.coordinates)
    .addTo(map);
});
    </script>
  </div>
  <div class="container">
    <?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
  </div>
</section>

<?php get_footer(); ?>
