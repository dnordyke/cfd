<?php
/**
 * Search item result for post type: ai1ec_event
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wpdb, $post;
$ai1ec_event = $post;
$thumbnail_url = get_the_post_thumbnail_url($ai1ec_event->ID) ?: null;
$event_permalink = get_permalink( $ai1ec_event->ID ) ?: null;
$event_date_caption = get_post_meta( $ai1ec_event->ID, '_cfd_ai1ec_event_date_time_caption' ) ?: 'Undefined';
if( is_array( $event_date_caption ) && isset( $event_date_caption[0] ) ) $event_date_caption = $event_date_caption[0];

/* Get event venue */
$ai1ec_event_meta = $wpdb->get_row( sprintf( 'SELECT venue, ticket_url FROM ' . $wpdb->prefix . 'ai1ec_events WHERE post_id = %d', $ai1ec_event->ID ) );
//var_dump($ai1ec_event_meta);
?>

<div class="col-sm-12 col-md-12 col-lg-6 cfd-event-item">
  <a href="<?php echo $event_permalink; ?>">
    <div class="cfd-event-item-inner lazy" style="background-image: url('<?php echo $thumbnail_url; ?>'); background-size: cover;">
      <div class="cfd-event-item-footer">
        <div class="cfd-event-item-meta-container">
          <h3><?php echo $ai1ec_event->post_title; ?></h3>
          <div class="row">
            <div class="col-sm-6">
              <?php if( $event_date_caption ): ?><i class="fa fa-calendar"></i> <?php echo $event_date_caption; ?><?php endif; ?>
            </div>
            <div class="col-sm-6">
              <?php if( $ai1ec_event_meta->venue ): ?><i class="fa fa-map-marker"></i> <?php echo $ai1ec_event_meta->venue; ?><?php endif; ?>
            </div>

            <!--
            <div class="col-sm-4">
              <?php if( $event_date_caption ): ?><i class="fa fa-calendar"></i> <?php echo $event_date_caption; ?><?php endif; ?>
            </div>
            <div class="col-sm-4">
              <?php if( $ai1ec_event_meta->venue ): ?><i class="fa fa-map-marker"></i> <?php echo $ai1ec_event_meta->venue; ?><?php endif; ?>
            </div>
            <div class="col-sm-4">
              <?php if( $ai1ec_event_meta->ticket_url ): ?><i class="fa fa-ticket"></i> Tickets<?php endif; ?>
            </div>
            -->
          </div>
        </div>
      </div>
    </div>
  </a>
</div>
