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

<!-- Holiday schedule -->
<section class="holiday-schedule">
  <div class="holiday-wrapper">
    <h3 class="blue-caps-headline">Fourpoint Holiday Schedule</h3>
    <a href="#">View Holiday Schedule</a>

    <div class="holiday-container">
      <div class="holiday shadow-border">
        <img src="/wp-content/themes/fourpoint/assets/images/icons/icon-qmark.svg" class="sp-cal-icon" />
        <h4>Labor Day</h4>
        <div class="date">
          <p><span>Monday</span>September 5, 2016</p>
        </div>
      </div>

      <div class="holiday shadow-border">
        <img src="/wp-content/themes/fourpoint/assets/images/icons/icon-qmark.svg" class="sp-cal-icon" />
        <h4>Labor Day</h4>
        <div class="date">
          <p><span>Monday</span>September 5, 2016</p>
        </div>
      </div>

      <div class="holiday shadow-border">
        <img src="/wp-content/themes/fourpoint/assets/images/icons/icon-qmark.svg" class="sp-cal-icon" />
        <h4>Labor Day</h4>
        <div class="date">
          <p><span>Monday</span>September 5, 2016</p>
        </div>
      </div>

      <div class="holiday shadow-border">
        <img src="/wp-content/themes/fourpoint/assets/images/icons/icon-qmark.svg" class="sp-cal-icon" />
        <h4>Labor Day</h4>
        <div class="date">
          <p><span>Monday</span>September 5, 2016</p>
        </div>
      </div>

      <div class="holiday shadow-border">
        <img src="/wp-content/themes/fourpoint/assets/images/icons/icon-qmark.svg" class="sp-cal-icon" />
        <h4>Labor Day</h4>
        <div class="date">
          <p><span>Monday</span>September 5, 2016</p>
        </div>
      </div>

      <div class="holiday">
        <img src="/wp-content/themes/fourpoint/assets/images/icons/icon-qmark.svg" class="sp-cal-icon" />
        <h4>Labor Day</h4>
        <div class="date">
          <p><span>Monday</span>September 5, 2016</p>
        </div>
      </div>

    </div>
  </div>
</section>
  <?php get_footer(); ?>
