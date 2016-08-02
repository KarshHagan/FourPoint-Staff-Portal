<?php
/**
 * Header template
 **/
global $theme;
global $current_user;
wp_get_current_user();
$alerts = get_posts(
  array(
    'post_type' => 'alert',
    'post_status' => 'publish',
  )
);
$last_alert_id = '';
$unread_alerts = false;
if( count($alerts)>0 ) { $last_alert_id = $alerts[0]->ID; }
$last_alert_viewed = get_field('last_alert_viewed',$current_user->data->ID);
if( count($alerts)>0 && $last_alert_id != $last_alert_viewed ) {
  $unread_alerts = true;
}
?><!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
  <title>Fourpoint Energy<?php wp_title( '|', true, 'left' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <?php
  if(!isset($pageDescription)) {
    $pageDescription = 'FourPoint Energy is a private exploration and production company founded by the leadership team of Cordillera Energy Partners following the sale to Apache Corporation in 2012.'; }
  ?>
  <meta name="description" content="<?php echo $pageDescription; ?>">
  <meta name="author" content="Karsh Hagan">
  <?php wp_head(); ?>
</head>
<body <?php body_class();?>>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46816205-2', 'auto');
  ga('send', 'pageview');
  </script>
	<nav class="sp-nav" id="top">
    <section>
      <a class="logo" href="/">
        <img src="<?php $theme->images_path() ?>/fp-logo.svg" alt="FourPoint Energy Logo">
      </a>
			<div class="nav_wrap">
        <div id="mobile_menu" class="mobile_nav_icon"><i class="fa fa-bars fa-2"></i></div>
        <div class="main_nav_wrap">
          <ul id="main_nav">
            <li class="nav-buttons nav-btn-big-mobile nav-btn-big"><a href="/employee-benefits" class="btn-blue btn-wide button"><span class="sp-icon"></span>Benefits</a></li>
            <li class="nav-buttons nav-btn-big-mobile nav-btn-big"><a href="/documents-forms" class="btn-blue btn-wide button"><span class="sp-icon"></span>Documents &amp; Forms</a></li>
            <li class="nav-buttons nav-btn-big-mobile nav-btn-big"><a href="/brand-center" class="btn-blue btn-wide button"><span class="sp-icon"></span>Brand Center</a></li>
            <li class="sp-navlink alert-toggle" id="alert"><a href="#"><span class="sp-icon alert-icon">Alerts<?php if($unread_alerts) { ?><span class="alert-notification"></span><?php } ?></span></a>
            <li class="sp-navlink"><a href="https://mail.fourpointenergy.com" target="_blank"><span class="sp-icon mail-icon">Mail</span></a>
            </li>
            <?php if( $current_user ) {
              $profile_photo = get_profile_photo($current_user->data->ID,true);
              echo("<!-- Profile Photo:".$profile_photo." -->");
              ?>
            <li class="sp-navlink alert-toggle<?php if( array_key_exists('profile_open',$_REQUEST) && $_REQUEST['profile_open'] == true ) { ?> open<?php } ?>" id="profile">
              <a href="#">
                <img src="<?php $theme->images_path() ?>/icons/icon_profile_blue-01.svg" class="profile-img-nav" />
                <span class="sp-icon">My Profile</span>
              </a>
            </li>

            <li class="sp-navlink current-user"><span class="welcome-text">Welcome back <?php echo $current_user->first_name ?></span><a href="<?php echo wp_logout_url( "/" ); ?> ">Logout</a>
            <?php } ?>
            </li>
          </ul>
        </div>
      </div>
    </section>
  </nav>
  <div class="sp-subnav">
    <ul class="container">
      <li class="nav-btn-big"><a href="/employee-benefits" class="btn-blue btn-wide button"><span class="sp-icon"></span>Benefits</a></li>
      <li class="nav-btn-big"><a href="/documents-forms" class="btn-blue btn-wide button"><span class="sp-icon"></span>Documents &amp; Forms</a></li>
      <li class="nav-btn-big"><a href="/brand-center" class="btn-blue btn-wide button"><span class="sp-icon"></span>Brand Center</a></li>
    </ul>
  </div>
  <section class="hero-main"<?php if(get_field('page_heading_bg')) { ?> style="background-image:url('<?php the_field('page_heading_bg'); ?>')"<?php } ?>>
    <div class="container">
      <div class="search-left">
        <h1><?php if(get_field('page_heading')) {
          the_field('page_heading');
        } elseif(is_search()) { echo('Search Results'); } else { the_title(); } ?></h1>
        <h3>Search for a document or resource</h3>
        <?php get_search_form(); ?>
      </div>
      <?php include_once('inc_quicklinks.php'); ?>
    </div>
  </section>

  <?php include_once('inc_alert_modal.php'); ?>
  <?php include_once('inc_profile_modal.php'); ?>
