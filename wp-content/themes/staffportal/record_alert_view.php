<?php
require_once("../../../wp-load.php");
if( $_POST['alert_id'] && $_POST['user_id'] ) {
  /* track personal alert view */
  update_field('last_alert_viewed', $_POST['alert_id'], $_POST['user_id']);
}
