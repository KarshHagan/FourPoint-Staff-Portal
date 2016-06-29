<?php
/**
 * Template for displaying the home page
 */
global $theme;
get_header(); ?>
<section class="latest-docs">
  <div class="container">
    <div class="quick-links shadow-border recently-viewed">
      <h3 class="blue-caps-headline">Recently Viewed</h3>
      <ul>
        <?php
        $args = array(
          'post_type' => 'document-file',
          'post_status' => 'publish',
          'posts_per_page' => 5
        );
        if( get_field('recently_viewed_ids',$current_user->ID) ) {
          $most_recent_ids = explode(",",get_field('recently_viewed_ids',$current_user->ID));
          $args['post__in'] = $most_recent_ids;
          $args['orderby'] = 'post__in';
        }
        // var_dump($args);
          $document_files = get_posts($args);
          foreach($document_files as $document_file) {
            $file_parts = explode("/",get_field('file_path',$document_file->ID));
            $filename = $file_parts[count($file_parts)-1];
        ?>
        <li><a href="<?php the_field('file_path',$document_file->ID) ?>" class="document-file" data-documentid="<?php echo $document_file->ID ?>" data-userid="<?php echo $current_user->ID ?>" target="_blank"><?php echo $filename ?></a></li>
        <?php } ?>
      </ul>
    </div>
    <div class="quick-links shadow-border most-popular">
      <h3 class="blue-caps-headline">Most Popular</h3>
      <ul>
        <?php
          $args = array(
            'post_type' => 'document-file',
            'post_status' => 'publish',
          );
          $document_files = get_posts($args);
          foreach($document_files as $document_file) {
            $file_parts = explode("/",get_field('file_path',$document_file->ID));
            $filename = $file_parts[count($file_parts)-1];
        ?>
        <li><a href="<?php the_field('file_path',$document_file->ID) ?>" class="document-file" data-documentid="<?php echo $document_file->ID ?>" data-userid="<?php echo $current_user->ID ?>" target="_blank"><?php echo $filename ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</section>

<!-- Holiday schedule -->
<section class="holiday-schedule">
  <div class="holiday-wrapper">
    <h3 class="blue-caps-headline">Fourpoint Holiday Schedule</h3>
    <a href="/wp-content/uploads/2016/06/Holiday-Schedule-2016-1.pdf" target="_blank">View Holiday Schedule</a>

    <div class="holiday-container">
      <?php $holidays = get_posts(
        array(
          'post_type' => 'holiday',
          'post_status' => 'publish',
          'meta_key'			=> 'calendar_date',
	        'orderby'			=> 'meta_value_num',
          'order'				=> 'ASC'
        )
      );
      foreach($holidays as $holiday) { ?>
      <div class="holiday shadow-border">
        <h4><?php echo $holiday->post_title ?></h4>
        <div class="date">
          <p><span><?php the_field('holiday_date_day',$holiday->ID) ?></span><?php the_field('holiday_date',$holiday->ID) ?></p>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</section>
  <?php get_footer(); ?>
