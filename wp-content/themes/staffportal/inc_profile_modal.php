<!-- profile modal -->
<div class="profile-modal">
  <div class="container shadow-border modal-panel">
  <div class="intro-wrap">
    <h1 class="container">My Profile<span class="close-modal" id="profile-modal"><img src="/wp-content/themes/staffportal/assets/images/icons/icon_close_blu.svg" /></span></h1>
  </div>
    <div class="photo-edit">
      <?php
        $profile_photo = get_field('profile_photo','user_'.$current_user->data->ID);
        var_dump($profile_photo);
      ?>
      <div class="profile-img-wrapper">
        <img class="profile-img" src="<?php echo get_field('profile_photo','user_'.$current_user->data->ID); ?>">
      </div>
    </div>
    <div class="form-container">
      <?php gravity_form( 'Edit Profile', false, false, false, null, true); ?>
    </div>
  </div>
</div>
