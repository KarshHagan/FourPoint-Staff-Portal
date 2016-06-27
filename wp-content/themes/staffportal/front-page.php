<?php
/**
 * Template for displaying the home page
 */
global $theme;
get_header(); ?>
<!-- section w/bg image, search, quick links box -->
<section class="hero-main">
  <div class="container">
    <div class="search-left">
      <h1>Fourpoint energy employee resource center</h1>
      <h3>Search for a document or resource</h3>
      <?php get_search_form(); ?>
    </div>
    <?php include_once('inc_quicklinks.php'); ?>
  </div>
</section>

<section class="latest-docs">
  <div class="container">
    <div class="quick-links shadow-border recently-viewed">
      <h3 class="blue-caps-headline">Recently Viewed</h3>
    </div>
    <div class="quick-links shadow-border most-popular">
      <h3 class="blue-caps-headline">Most Popular</h3>
    </div>
  </div>
</section>

<!-- Holiday schedule -->
<section class="holiday-schedule">
  <div class="holiday-wrapper">
    <h3 class="blue-caps-headline">Fourpoint Holiday Schedule</h3>
    <a href="#">View Holiday Schedule</a>

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
