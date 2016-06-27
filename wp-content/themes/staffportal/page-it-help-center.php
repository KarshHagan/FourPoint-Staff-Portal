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
<?php if ( $ticket_qry->have_posts() ) : ?>
  <div class="copy_split">
    <?php while ( $ticket_qry->have_posts() ) : $ticket_qry->the_post(); ?>
       <div class="side-content">
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
