<!-- Staff Portal Home Page -->
<?php
/**
 * Header template
 **/
global $theme;
get_header();
?>
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
      ?>
      <?php
        foreach($terms as $office) {
      ?>
      <div class="address">
        <h3><?php echo $office->name ?></h3>
        <p><?php the_field('address',$office) ?></p>
        <a href="tel:<?php echo preg_replace("/[^0-9]/", "", get_field('phone',$office)); ?>"><?php the_field('phone',$office) ?></a>
        <!-- <a href="<?php the_field('org_chart_file',$office) ?>" target="_blank"><?php echo $office->name ?> Organizational Chart</a> -->
      </div>
      <?php } ?>
    </div>
  </div>

  <div class="employees-wrapper">
    <div class="container">
      <div class="office-sort" data-active-office="all">
        <h3>Choose Office:</h3>
        <ul>
          <li><a href="#" class="button btn-white active office-btn" data-office-selected="all">All</a></li>
          <?php
            foreach($terms as $office) {
          ?>
            <li><a href="#" class="button btn-white office-btn" data-office-selected="<?php echo $office->slug ?>"><?php echo $office->name ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <div class="name-sort" data-active-name="all">
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

          $profile_photo = get_profile_photo($employee->ID);
          $last_name_category = $theme->get_last_name_filer($employee->last_name);
          // $offices = get_field('employee_office','user_'.$employee->ID);
          $offices = wp_get_object_terms( $employee->ID, 'office' );
          if( count($offices) > 0 ) {
            $office = $offices[0];
            $office_name = $office->name;
            $office_slug = $office->slug;
          } else {
            $office_name = '&nbsp;';
            $office_slug = '';
          }
        ?>
        <li class="employee-bio-container" data-office="<?php echo $office_slug ?>" data-name="<?php echo $last_name_category ?>">
          <div class="employee-bio">
            <div class="front shadow-border">
              <img class="profile-img" src="<?php echo $profile_photo ?>">
              <h2><?php echo($employee->first_name." ".$employee->last_name) ?></h2>
              <h3><?php echo $user_title ?></h3>
              <p class="office"><?php echo $office_name ?></p>
              <ul class="contact-info">
                <li class="email-addr">Email: <span><?php echo $employee->user_email ?></span></li>
                <li>Direct Line: <span><?php echo $outside_dial ?></span></li>
                <li>Ext: <span><?php echo $extension ?></span></li>
                <li>Mobile: <span><?php echo $mobile_number ?></span></li>
              </ul>
              <a href="#" class="more-flip">More</a>
            </div>

            <div class="back shadow-border">
              <img class="profile-img" src="<?php echo $profile_photo ?>">
              <div class="inner">
                <p><?php echo $employee->description ?></p>
              </div>
              <a href="#" class="more-flip">Less</a>
            </div>

          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
<?php get_footer(); ?>
