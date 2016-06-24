<!-- Staff Portal Home Page -->
<?php
/**
 * Header template
 **/
global $theme;
?>
  <!-- section w/bg image, search, quick links box -->
  <section class="hero-main">
    <div class="container">
      <div class="search-left">
        <h1>Fourpoint energy company directory</h1>
        <h3>Search for a document or resource</h3>
        <form>SEARCH BOX GOES HERE</form>
      </div>
      <div class="quick-links shadow-border">
        <h3 class="blue-caps-headline">Quick Links</h3>
        <ul>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
        </ul>
      </div>
    </div>
  </section>

  <div class="address-container">
    <div class="container">
      <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile;// end of the loop. ?>
      <?php
      $terms = get_terms( array(
        'taxonomy' => 'office',
        'hide_empty' => false,
      ) );
      // $terms = get_field('office')
      ?>
      <?php
        foreach($terms as $office) {
      ?>
      <div class="address">
        <?php the_field('',$office) ?>
        <p>100 St. Paul Street, Ste. 400 Denver, CO 80206</p>
        <a href="tel:3033033030">303.300.3030</a>
        <a href="#">Denver Organizational Chart</a>
      </div>
      <?php } ?>
    </div>
  </div>

  <div class="employees-wrapper">
    <div class="container">
      <div class="office-sort">
        <h3>Choose Office:</h3>
        <ul>
          <li><a href="#" class="button btn-white active" data-office="all">All</a></li>
          <li><a href="#" class="button btn-white" data-office="borger">Borger</a></li>
          <li><a href="#" class="button btn-white" data-office="denver">Denver</a></li>
          <li><a href="#" class="button btn-white" data-office="elk-city">Elk City</a></li>
          <li><a href="#" class="button btn-white" data-office="shamrock">Shamrock</a></li>
          <li><a href="#" class="button btn-white" data-office="woodward">Woodward</a></li>
        </ul>
      </div>
      <div class="name-sort">
        <h3>Filter by Last Name:</h3>
        <ul>
          <li><a href="#" class="button btn-white active name-btn" data-name-selected="all">All</a></li>
          <li><a href="#" class="button btn-white name-btn" data-name-selected="a-f">A-F</a></li>
          <li><a href="#" class="button btn-white name-btn" data-name-selected="g-m">G-M</a></li>
          <li><a href="#" class="button btn-white name-btn" data-name-selected="n-s">N-S</a></li>
          <li><a href="#" class="button btn-white name-btn" data-name-selected="t-z">T-Z</a></li>
        </ul>
      </div>


      <ul>
        <?php
        $args = array(
          'role' => 'employee'
        );
        $employees = get_users($args);
        foreach($employees as $employee) {
          $user_title = get_field('title','user_'.$employee->ID);
          $outside_dial = get_field('outside_dial','user_'.$employee->ID);
          $extension = get_field('extension','user_'.$employee->ID);
          $mobile_number = get_field('mobile_number','user_'.$employee->ID);
          $conf_call_id = get_field('conf_call_id','user_'.$employee->ID);
          $profile_photo = get_field('profile_photo','user_'.$employee->ID);
          $last_name_category = $theme->get_last_name_filer($employee->last_name);
          $offices = get_field('employee_office','user_'.$employee->ID);
          $office = $offices[0];
        ?>
        <li class="employee-bio-container">
          <div class="employee-bio" data-office="<?php echo $office->slug ?>" data-name="<?php echo $last_name_category ?>">
            <div class="front">
              <img src="<?php echo $profile_photo['sizes']['thumbnail'] ?>">
              <h2><?php echo $employee->display_name ?></h2>
              <h3><?php echo $user_title ?></h3>
              <p class="office"><?php echo $office->name ?></p>
              <ul class="contact-info">
                <li>Email: <span><?php echo $employee->user_email ?></span></li>
                <li>Outside Dial: <span><?php echo $outside_dial ?></span></li>
                <li>Ext: <span><?php echo $extension ?></span></li>
                <li>Conf Call ID: <span><?php echo $conf_call_id ?></span></li>
                <li>Mobile: <span><?php echo $mobile_number ?></span></li>
              </ul>
              <p href="#">More</p>
            </div>

            <div class="back">
              <img src="<?php echo $profile_photo['sizes']['thumbnail'] ?>">
              <div class="inner">
                <p><?php echo $employee->description ?></p>
              </div>
              <p href="#">Less</p>
            </div>

          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
<?php get_footer(); ?>
