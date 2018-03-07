<?php
/**
 * Search item result for post type: ai1ec_event
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 4.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
if( !class_exists( 'SimplyDG\CheyenneCore\Helpers' ) ) {
	echo 'Error: Core plugin not loaded.';
	return;
}
global $wpdb;
$selected_date = isset( $_GET['date'] ) ? $_GET['date'] : null;
$selected_date_class = ' class="active"';

//$ai1ec_date_days = \SimplyDG\CheyenneCore\Helpers::
$ai1ec_date_start = get_option( '_cfd_festival_start_date' );
$ai1ec_date_end = get_option( '_cfd_festival_end_date' );
$ai1ec_date_days = round( ( strtotime( $ai1ec_date_end ) - strtotime( $ai1ec_date_start ) ) / ( 60 * 60 * 24 ) );

if( $ai1ec_date_days ):
?>

<div id="ai1ec_filter_list" style="visibility: hidden;">
	<div class="container">
		<div class="row cfd-event-filter-list-desktop">
			 <div class="col-sm-1 cfd-event-filter-item">
				<a href="<?php echo \SimplyDG\CheyenneCore\Helpers::modify_query_string( [ 'date' => '' ], '?' ) ?>"<?php if( !$selected_date ) echo $selected_date_class; ?>>ALL</a>
			</div>
			<?php for( $_day = 0; $_day <= $ai1ec_date_days; $_day++ ): ?>
			<div class="col-sm-1 cfd-event-filter-item">
				<a href="<?php echo \SimplyDG\CheyenneCore\Helpers::modify_query_string( [ 'date' => date_format( date_add(date_create($ai1ec_date_start),date_interval_create_from_date_string($_day . ' days')), 'Y-m-d' ) ], '?' ) ?>"<?php if( $selected_date == date_format( date_add(date_create($ai1ec_date_start),date_interval_create_from_date_string($_day . ' days')), 'Y-m-d' ) ) echo $selected_date_class; ?>><?php echo date_format( date_add(date_create($ai1ec_date_start),date_interval_create_from_date_string($_day . ' days')), 'F j' ); ?></a>
			</div>
			<?php endfor; ?>
		</div>
	</div>
</div>
<div class="clear-left"></div>
<div class="row cfd-event-filter-list-mobile">
	<div class="col-sm-12">
		<label>Day:</label>
		<select class="select2" id="event_filter_list_mobile" data-placeholder="— Choose —">
			<option></option>
			<?php for( $_day = 0; $_day <= $ai1ec_date_days; $_day++ ):
				$formatted_date = date_format( date_add(date_create($ai1ec_date_start),date_interval_create_from_date_string($_day . ' days')), 'Y-m-d' );
				$formatted_date_caption = date_format( date_add(date_create($ai1ec_date_start),date_interval_create_from_date_string($_day . ' days')), 'F jS, Y' );
				$formatted_date_querystring = \SimplyDG\CheyenneCore\Helpers::modify_query_string( [ 'date' => date_format( date_add(date_create($ai1ec_date_start),date_interval_create_from_date_string($_day . ' days')), 'Y-m-d' ) ], '?' );
				$date_selected = ' selected="selected"';
				?>
				<option value="?<?php echo $formatted_date_querystring; ?>"<?php if( isset( $_GET['date'] ) && $_GET['date'] == $formatted_date ) echo $date_selected; ?>><?php echo $formatted_date_caption; ?></option>
			<?php endfor; ?>
		</select>
	</div>
</div>

<?php endif; ?>
