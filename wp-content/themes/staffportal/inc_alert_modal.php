<!-- alert modal -->
<?php
if( !isset( $alerts ) ) {
  $alerts = get_posts(
    array(
      'post_type' => 'alert',
      'post_status' => 'publish',
    )
  );
}
$removed_alert_ids = get_field('removed_alert_ids', $current_user->data->ID);
$removed_alerts = explode(",",$removed_alert_ids);
?>
<div class="alert-modal" data-userid="<?php echo $current_user->data->ID ?>" data-last-id="<?php if( count($alerts)>0 ) { echo $alerts[0]->ID; } ?>">
  <div class="container shadow-border modal-panel">
    <h1 class="container">My Alerts<span class="close-modal" id="alert-modal"><img src="/wp-content/themes/staffportal/assets/images/icons/icon_close_blu.svg" /></span></h1>
    <?php if( $alerts && count($alerts) > 0 ) { ?>
    <ul class="container">
      <?php foreach( $alerts as $alert ) { ?>
        <?php if( !array_search($alert->ID,$removed_alerts) ) { ?>
      <li class="alert-<?php echo $alert->ID ?>">
        <div class="modal-left">
          <?php if(get_field('external_link', $alert->ID)) { ?>
            <p><span class="alert-date"><?php the_field('alert_date',$alert->ID) ?>  |</span><a href="<?php the_field('external_link', $alert->ID); ?>" target="_blank" class="modal-link"><?php the_field('external_link_name', $alert->ID); ?></a>
            <?php echo $alert->post_content ?></p>
            <div class="document-files">
                <a href="<?php the_field('external_link'); ?>" target="_blank"><?php the_field('external_link_name'); ?></a>
                <span class="remove-alert text-arrow-link" data-alertid="<?php echo $alert->ID ?>" data-userid="<?php echo $current_user->data->ID ?>">Remove</span>
            </div>
          <?php } elseif( get_field('linked_page',$alert->ID) ) {
            $linked_page = get_field('linked_page',$alert->ID);
            ?>
            <p><span class="alert-date"><?php the_field('alert_date',$alert->ID) ?>  |</span><a href="<?php echo get_permalink($linked_page->ID); ?>" class="modal-link"><?php echo $linked_page->post_title; ?></a>
            <?php echo $alert->post_content ?></p>
            <div class="document-files">
                <a href="<?php echo get_permalink($linked_page->ID); ?>" class="go-to-page">view</a>
                <span class="remove-alert text-arrow-link" data-alertid="<?php echo $alert->ID ?>" data-userid="<?php echo $current_user->data->ID ?>">Remove</span>
            </div>
          <?php } elseif( get_field('linked_document', $alert->ID) ) {
            $document_file = get_field('linked_document', $alert->ID); ?>
          <p><span class="alert-date"><?php the_field('alert_date',$alert->ID) ?>  | </span><span class="alert-title"><?php echo $alert->post_title; ?></span><?php echo $alert->post_content ?></p>
          <div class="document-files">
            <a href="<?php the_field('file_path',$document_file->ID) ?>" target="_blank"><?php echo $document_file->post_title ?></a>
            <span class="remove-alert text-arrow-link" data-alertid="<?php echo $alert->ID ?>" data-userid="<?php echo $current_user->data->ID ?>">Remove</span>
          </div>
          <?php } else { ?>
            <p><span class="alert-date"><?php the_field('alert_date',$alert->ID) ?>  | </span><span class="alert-title"><?php echo $alert->post_title; ?></span><?php echo $alert->post_content ?></p>
            <div class="document-files">
              <span class="remove-alert text-arrow-link" data-alertid="<?php echo $alert->ID ?>" data-userid="<?php echo $current_user->data->ID ?>">Remove</span>
            </div>
          <?php } ?>
        </div>
      </li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <div class="container"><p>There are no alerts at this time</p></div>
    <?php } ?>
  </div>
</div>
