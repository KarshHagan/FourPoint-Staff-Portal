<?php
/**
 * Template for displaying the login page
 */
global $theme;
$failed_login = false;
if(array_key_exists('login',$_REQUEST) && $_REQUEST['login']=='failed' && array_key_exists('login_type',$_REQUEST)) {
  if($_REQUEST['login_type']=='staff') {
    $failed_login = true;
  }
} ?>

<!DOCTYPE html>
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
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <header>
  	<h1><?php the_title(); ?></h1>
  	<p><?php the_field('page_description'); ?></p>
  </header>
  <div class="container">
      <aside class="card login">
        <span style="text-align:left"><?php the_content(); ?></span>
            <?php if($failed_login) { ?>
              <p class="login-error"><?php the_field('login_failed_error_message') ?></p>
            <?php } ?>
            <div class="form_wrap login-form">
             <div class="general-form">
             <form name="loginform" class="loginform" action="<?php echo site_url('/wp-login.php') ?>" method="post">
               <p class="login-username">
                 <label for="user_login">Email/Username</label>
                 <input type="text" name="log" id="user_login" class="input" value="" size="20">
               </p>
               <p class="login-password">
                 <label for="user_pass">Password</label>
                 <input type="password" name="pwd" id="user_pass" class="input" value="" size="20">
               </p>
               <!-- <p><a href="/wp-login.php?action=lostpassword">Forgot Password?</a></p> -->
               <p class="login-submit">
                 <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-blue" value="Log In">
                 <input type="hidden" name="redirect_to" value="<?php echo site_url('/') ?>">
                 <input type="hidden" name="login_type" value="employee">
               </p>
             </form>
           </div>
            </div>
      </aside>
  </div>
<?php endwhile;// end of the loop. ?>