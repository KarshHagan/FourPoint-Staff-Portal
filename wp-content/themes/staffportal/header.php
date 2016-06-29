<?php
/**
 * Header template
 **/
global $theme;
global $current_user;
wp_get_current_user();
?><!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
  <title>Fourpoint Energy<?php wp_title( '|', true, 'left' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <?php
  if(!isset($pageDescription)) {
    $pageDescription = 'FourPoint Energy is a private exploration and production company founded by the leadership team of Cordillera Energy Partners following the sale to Apache Corporation in 2012.'; }
  ?>
  <meta name="description" content="<?php echo $pageDescription; ?>">
  <meta name="author" content="Karsh Hagan">
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/apple-touch-icon-144x144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="/apple-touch-icon-precomposed.png">
  <?php wp_head(); ?>
</head>
<body <?php body_class();?>>
	<nav class="sp-nav">
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
            <li class="sp-navlink alert-toggle" id="alert"><a href="#"><span class="sp-icon alert-icon">Alerts</span></a>
            <li class="sp-navlink"><a href="https://mail.fourpointenergy.com" target="_blank"><span class="sp-icon mail-icon">Mail</span></a>
            </li>
            <li class="sp-navlink alert-toggle" id="profile"><a href="#"><span class="sp-icon profile-icon">My Profile</span></a>
            </li>
            <li class="sp-navlink"><a href="#">Logout</a>
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

  <section class="hero-main">
    <div class="container">
      <div class="search-left">
        <h1><?php if(get_field('page_heading')) {
          the_field('page_heading');
        } else { the_title(); } ?></h1>
        <h3>Search for a document or resource</h3>
        <?php get_search_form(); ?>
      </div>
      <?php include_once('inc_quicklinks.php'); ?>
    </div>
  </section>

  <?php include_once('inc_alert_modal.php'); ?>
  <?php include_once('inc_profile_modal.php'); ?>
