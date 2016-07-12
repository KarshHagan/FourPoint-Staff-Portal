<?php
/**
 * Template for displaying the IT Help Center
 */
global $theme;
get_header();
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div class="container it-top">
  <div class="it-copy"><?php the_content(); ?></div>
  <a href="#" class="button btn-blue it-sys-btn">IT Ticketing System</a>
  <hr>
  <div class="it-sort" data-active-btn="all">
    <ul>
      <li><a href="#" class="button btn-white active it-btn" data-it-selected="all">All</a></li>
      <?php
      $terms = get_terms( array(
        'taxonomy' => 'ticket_category',
        'hide_empty' => true,
      ) );
      // $terms = get_categories($args);
      foreach($terms as $term) { ?>
      <li><a href="#" class="button btn-white it-btn" data-it-selected="<?php echo $term->slug ?>"><?php echo $term->name ?></a></li>
      <?php } ?>
      <!-- <li><a href="#" class="button btn-white it-btn" data-it-selected="tool">Helpful Tools</a></li> -->
      <!-- <li><a href="#" class="button btn-white it-btn" data-it-selected="guide">A/V User Guides</a></li> -->
    </ul>
  </div>
</div>
<?php endwhile;// end of the loop. ?>
<?php
$args = array(
  'post_type' => 'ticket',
  'post_status' => 'publish',
  'orderby'	=> 'meta_value_num',
	'order'		=> 'DESC',
  'meta_query' => array(
				'key' => 'speaking_event_date',
				'value' => date('Ymd'),
				'type' => 'DATE',
			)
);
$ticket_qry = new WP_Query( $args );
 ?>

<?php if ( $ticket_qry->have_posts() ) : ?>
  <div class="copy_split it-items">
    <?php while ( $ticket_qry->have_posts() ) : $ticket_qry->the_post();
    $categories = wp_get_object_terms( $post->ID, 'ticket_category' );
    if( count($categories) > 0 ) {
      $category = $categories[0];
      $category_name = $category->name;
      $category_slug = $category->slug;
    } else {
      $category_name = '&nbsp;';
      $category_slug = '';
    }

    ?>
       <div class="side-content" data-it-selected="<?php echo $category_slug ?>">
       <!-- the other type will be data-type="guide"-->
         <aside>
           <p><?php the_title(); ?>
           <p class="ticket-details">
             <?php the_field('ticket_date') ?></p>
         </aside>
         <article><p><?php the_excerpt(); ?></p>
           <a href="<?php the_permalink(); ?>">Learn More</a>
         </article>
       </div>
    <?php endwhile; ?>
  </div>
<?php endif; ?>
<?php get_footer(); ?>
