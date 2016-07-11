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
  <p class="it-tel">Help Line: <a href="tel:<?php the_field('help_line_phone_number') ?>"><?php the_field('help_line_phone_number') ?></a></p>
  <hr>
  <div class="it-sort" data-active-btn="all">
    <ul>
      <li><a href="#" class="button btn-white active it-btn" data-it-selected="all">All</a></li>
      <li><a href="#" class="button btn-white it-btn" data-it-selected="tool">Helpful Tools</a></li>
      <li><a href="#" class="button btn-white it-btn" data-it-selected="guide">A/V User Guides</a></li>
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
