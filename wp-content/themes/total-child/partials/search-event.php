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
global $wpdb, $ai1ec_event;
$thumbnail_url = get_the_post_thumbnail_url( $ai1ec_event->ID, 'event_card' ) ?: null;
$event_permalink = get_permalink( $ai1ec_event->ID ) ?: null;
$event_date_caption = get_post_meta( $ai1ec_event->ID, '_cfd_ai1ec_event_date_time_caption' ) ?: 'Undefined';
if( is_array( $event_date_caption ) && isset( $event_date_caption[0] ) ) $event_date_caption = $event_date_caption[0];

/* Get event venue */
$ai1ec_event_meta = $wpdb->get_row( sprintf( 'SELECT venue, ticket_url FROM ' . $wpdb->prefix . 'ai1ec_events WHERE post_id = %d', $ai1ec_event->ID ) );
$meta_column_sizes = $event_date_caption ? [ 'date_caption' => '4', 'venue' => '7' ] : [ 'date_caption' => '0', 'venue' => '11' ];
?>

<div class="col-sm-12 col-md-12 col-lg-6 cfd-event-item">
	<div class="cfd-event-item-footer">
		<div class="row cfd-event-item-meta-container">
			<div class="row cfd-event-item-meta-caption">
				<div class="col-sm-12">
					<a href="<?php echo $event_permalink; ?>"><h3><?php echo $ai1ec_event->post_title; ?></h3></a>
				</div>
			</div>
			<div class="row cfd-event-item-meta">
				<?php if( $event_date_caption ): ?>
				<div class="col-sm-<?php echo $meta_column_sizes['date_caption'] ?>">
					<i class="fa fa-calendar tippy" title="Schedule" role="tooltip" data-tippy-theme="light bordered" data-tippy-placement="top" data-tippy-arrow="on"></i> <?php echo $event_date_caption; ?>
				</div>
				<?php endif; ?>
				<div class="col-sm-<?php echo $meta_column_sizes['venue'] ?>">
					<?php if( $ai1ec_event_meta->venue ): ?><i class="fa fa-map-marker tippy" title="Location" role="tooltip" data-tippy-theme="light bordered" data-tippy-placement="top" data-tippy-arrow="on"></i> <?php echo $ai1ec_event_meta->venue; ?><?php endif; ?>
				</div>
				<div class="col-sm-1 text-right">
					<?php if( $ai1ec_event_meta->ticket_url ): ?><a href="<?php echo $ai1ec_event_meta->ticket_url; ?>" class="ticket-button"><i class="fa fa-ticket tippy" title="Tickets" role="tooltip" data-tippy-theme="light bordered" data-tippy-placement="top" data-tippy-arrow="on"></i></a><?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<a href="<?php echo $event_permalink; ?>"><img src="<?php echo $thumbnail_url; ?>" class="img-fluid cfd-event-item-image" alt="<?php echo htmlspecialchars( $event_date_caption ); ?>" /></a>
</div>
