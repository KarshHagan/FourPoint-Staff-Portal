<?php
require_once("../../../wp-load.php");
if( $_POST['alert_id'] && $_POST['user_id'] ) {
  /* track alerts removed */
  $removed_alert_ids = get_field('removed_alert_ids', $_POST['user_id']);
  $removed_alerts = explode(",",$removed_alert_ids);
  var_dump($removed_alerts);
  var_dump(array_search( $_POST['alert_id'], $removed_alerts ));
  if( !array_search( $_POST['alert_id'], $removed_alerts ) ) {
    array_push( $removed_alerts,$_POST['alert_id']  );
  }
  $removed_alert_ids = implode( ",", array_filter($removed_alerts) );
  echo("removed alert ids".$removed_alert_ids);
  // update_field('removed_alert_ids', $removed_alert_ids, $_POST['user_id']);
}
