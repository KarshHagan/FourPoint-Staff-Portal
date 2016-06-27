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
        <img src="<?php $theme->images_path() ?>/FourPoint_Logo.svg" alt="FourPoint Energy Logo">
      </a>
			<div class="nav_wrap">
        <div id="mobile_menu" class="mobile_nav_icon"><i class="fa fa-bars fa-2"></i></div>
        <div class="main_nav_wrap">
          <ul id="main_nav">
            <li class="nav-buttons"><a href="/employee-benefits" class="btn-blue btn-wide button"><span class="sp-icon">%</span>Benefits</a></li>
            <li class="nav-buttons"><a href="/documents-forms" class="btn-blue btn-wide button"><span class="sp-icon">%</span>Documents &amp; Forms</a></li>
            <li class="nav-buttons"><a href="/brand-center" class="btn-blue btn-wide button"><span class="sp-icon">%</span>Brand Center</a></li>
            <li class="sp-navlink alert-toggle" id="alert"><a href="#"><span class="sp-icon">%</span>Alerts</a>
            <li class="sp-navlink"><a href="#"><span class="sp-icon">%</span>Mail</a>
            </li>
            <li class="sp-navlink alert-toggle" id="profile"><a href="#"><span class="sp-icon">%</span>My Profile</a>
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
      <li><a href="/employee-benefits" class="btn-blue btn-wide button"><span class="sp-icon"></span>Benefits</a></li>
      <li><a href="/documents-forms" class="btn-blue btn-wide button"><span class="sp-icon"></span>Documents &amp; Forms</a></li>
      <li><a href="/brand-center" class="btn-blue btn-wide button"><span class="sp-icon"></span>Brand Center</a></li>
    </ul>
  </div>

  <!-- alert modal -->
  <div class="alert-modal">
    <div class="container shadow-border modal-panel">
      <h1 class="container">My Alerts<span class="close-modal" id="alert-modal"><img src="/wp-content/themes/staffportal/assets/images/icons/icon_close_blu.svg" /></span></h1>
      <ul class="container">
        <li>
          <div class="modal-left">
            <p><span class="alert-date">June 20, 2016  |</span><a href="#" class="modal-link">Link to a document</a>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</p>
            <div class="document-files">
                <a href="http://fp-portal.wigwamcreative.com/wp-content/uploads/2016/06/Anthem-DORA-Health-Enrollment-Form.pdf" target="_blank">Enrollment Form</a>
                <img src="/wp-content/themes/staffportal/assets/images/icons/icon_minus_blu-01-01.svg" class="remove-alert"/>
            </div>
          </div>
        </li>

        <li>
          <div class="modal-left">
            <p><span class="alert-date">June 20, 2016  |</span><a href="#" class="modal-link">Link to a page</a>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</p>
            <div class="document-files">
                <a href="#" class="go-to-page">view</a>
                <img src="/wp-content/themes/staffportal/assets/images/icons/icon_minus_blu-01-01.svg" class="remove-alert"/>
            </div>
          </div>
        </li>

        <li>
          <div class="modal-left">
            <p><span class="alert-date">June 20, 2016  |</span><a href="#" class="modal-link">Link to something(if necessary)</a>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</p>
            <div class="document-files">
                <a href="http://fp-portal.wigwamcreative.com/wp-content/uploads/2016/06/Anthem-DORA-Health-Enrollment-Form.pdf" target="_blank">Enrollment Form</a>
                <img src="/wp-content/themes/staffportal/assets/images/icons/icon_minus_blu-01-01.svg" class="remove-alert"/>
            </div>
          </div>
        </li>

      </ul>
    </div>
  </div>

  <!-- profile modal -->
  <div class="profile-modal">
    <div class="container shadow-border modal-panel">
      <h1 class="container">profile modal<span class="close-modal" id="profile-modal"><img src="/wp-content/themes/staffportal/assets/images/icons/icon_close_blu.svg" /></span></h1>
      <p>Instructions Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua.</p>
      <div class="photo-edit">
        <img class="profile-img" src="/wp-content/themes/fourpoint/assets/images/frenchy.jpg">
        <form>
          <label for="profile-photo-upload">Edit Photo</label>
          <input type="file" id="profile-photo-upload">
        </form>
      </div>
      

      <div class="container">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>

          <button type="submit" class="btn btn-default">Submit</button>
        </form>
      </div>


    </div>
  </div>
