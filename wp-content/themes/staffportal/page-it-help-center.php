<?php
/**
 * Template for displaying the home page
 */
global $theme;
get_header();

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




<div class="container it-top">
  <p class="it-copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
  quis nostrud exercitation ullamco</p>
  <a href="#" class="button btn-blue it-sys-btn">IT Ticketing System</a>
  <p class="it-tel">Help Line: <a href="tel:#####">303.303.0303</a></p>
  <hr>
  <div class="it-sort" data-active-btn="all">
    <ul>
      <li><a href="#" class="button btn-white active it-btn" data-it-selected="all">All</a></li>
      <li><a href="#" class="button btn-white it-btn" data-it-selected="tool">Helpful Tools</a></li>
      <li><a href="#" class="button btn-white it-btn" data-it-selected="guide">A/V User Guides</a></li>
    </ul>
  </div>
</div>




<?php if ( $ticket_qry->have_posts() ) : ?>
  <div class="copy_split it-items">
    <?php while ( $ticket_qry->have_posts() ) : $ticket_qry->the_post(); ?>
       <div class="side-content" data-type="tool">
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
