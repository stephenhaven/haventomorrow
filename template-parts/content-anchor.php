<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

 $anchor_title = get_field('anchor_title');
 $anchor_verse = get_field('anchor_verse');
 $anchor_scripture = get_field('anchor_scripture');
 $anchor_description = get_field('anchor_description');
 $anchor_image = get_field('anchor_image');
 $anchor_product = get_field('anchor_product');
 $anchor_scripture_focus = get_field('anchor_scripture_focus');
 $anchor_insight = get_field('anchor_insight');
 $anchor_bible_reading_1 = get_field('anchor_bible_reading_1');
 $anchor_bible_reading_2 = get_field('anchor_bible_reading_2');
 $anchor_bible_reading_3 = get_field('anchor_bible_reading_3');

 $anchor_subtitle = get_the_date('m.d.y');

 ?>

 <section class="c-padding-25">
   <div class="container">
     <h3 style="margin-bottom:"><?php echo $anchor_subtitle; ?></h3>
    <h1 class="entry-title"><?php echo $anchor_title; ?></h1>
    <h3 class="author">Written by <?php the_author(); ?> </h3>
    </hr>

   <div class="content">
     <div class="verse">
       <?php echo $anchor_scripture; ?>
       <span><?php echo $anchor_verse; ?></span>
     </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <?php echo $anchor_description; ?>
      </div>
      <div class="col-md-4">
        <?php if( $anchor_image ): ?>
          <img src="<?php echo $anchor_image; ?>">
        <?php endif; ?>
      </div>
      <div class="is-center-100"><?php get_sidebar(); ?></div>
    </div>
   </div>

   <hr/>
   <section class="c-padding-50">
     <div class="container">
       <div class="slider-premium">
       <?php
           if( have_rows('anchor_product_slider', 'option') ):

             // loop through the rows of data
               while ( have_rows('anchor_product_slider', 'option') ) : the_row();

                   // display a sub field value
                   $label = get_sub_field('label', 'option');
                   $premium = get_sub_field('premium', 'option');
                   $desc = get_sub_field('brief_description', 'option');
                   $img = get_sub_field('premium_image', 'option');
                   $link = get_sub_field('premium_link', 'option');
               ?>

               <div>
                 <div class="row">
                 <div class="col-md-4">
                   <div class="">
                     <?php if( $label ): ?>
                     <h3><?php echo $label; ?></h3>
                     <?php endif; ?>
                     <?php if( $premium ): ?>
                     <h4><?php echo $premium; ?></h4>
                     <?php endif; ?>
                     <?php if( $desc ): ?>
                     <p><?php echo $desc; ?></p>
                     <?php endif; ?>
                 </div>
                 </div>
                 <div class="col-md-4 text-center">
                   <?php if( $link ): ?>
                   <?php if( $img ): ?>
                   <a href="<?php echo $link; ?>"><img src="<?php echo $img; ?>" width="80%"></a>
                   <?php endif; ?>
                   <?php endif; ?>
                 </div>
                 <div class="col-md-4 text-center">
                   <div class="v-middle-absolute">
                     <?php if( $link ): ?>
                   <a href="<?php echo $link; ?>" class="o-button">GET THIS RESOURCE</a>
                   <?php endif; ?>
                 </div>
                 </div>
               </div>
               </div>

       <?php endwhile; ?>

     </div>

     <?php endif; ?>
   </div>
   </section>
   <script>
     $(document).ready(function(){
       $('.slider-premium').slick({});
     });
   </script>

   <div class="section anchorDetails grey">
     <div class="row">
       <div class="col-md-4">
       		<div class="anchorCol">
       			<h2>Scripture Focus</h2>
            <?php echo $anchor_scripture_focus; ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="anchorCol">
            <h2>Insight</h2>
            <div class="insightText">
              <?php echo $anchor_insight; ?>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="anchorCol">
      			<h2>Bible In A Year</h2>
      			<ul>
      				<li><?php echo $anchor_bible_reading_1; ?></li>
      				<li><?php echo $anchor_bible_reading_2; ?></li>
      				<li><?php echo $anchor_bible_reading_3; ?></li>
      			</ul>
      		</div>
        </div>
    </div>
  </div>
  </div>
  <div class="anchorBtns">
    <div class="buttons">
      <a class="o-button" href="/product/anchor-devotional-subscription/">Subscribe to Anchor</a><a class="o-button" href="/anchor-archive/">View Previous Devotionals</a>
    </div>
  </div>
 </section>
