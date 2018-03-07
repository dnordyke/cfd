<?php
/**
 * The page header displays at the top of all single pages, posts and archives.
 *
 * @see framework/page-header.php for all page header related functions.
 * @see framework/hooks/actions.php for all functions attached to the header hooks.
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div id="blueRibbon" class="vc_row wpb_row vc_row-fluid vc_custom_1510940991723 vc_row-o-equal-height vc_row-o-content-middle vc_row-flex wpex-vc_row-has-fill wpex-vc-row-boxed-layout-stretched wpex-vc-reset-negative-margin">
            	<div class="wpb_column blueRibbonDate vc_column_container vc_col-sm-2">
                	<div class="vc_column-inner ">
                    	<div class="wpb_wrapper">
							<div class="wpb_text_column wpb_content_element " >
								<div class="wpb_wrapper">
									<h3>July 20-29, 2018</h3>
                                  </div>
								</div>
							</div>
						</div>
					</div>

		<div class="wpb_column countdown vc_column_container vc_col-sm-6">
        	<div class="vc_column-inner ">
            	<div class="wpb_wrapper">
                	<div class="vcex-module vcex-countdown-wrap"><div class="vcex-countdown clr" data-countdown="2018/7/20" data-days="Days" data-hours="Hours" data-minutes="Minutes" data-seconds="Seconds"><?php do_shortcode ('[vc_column width="1/2" el_class="countdown"][vcex_countdown end_month="7" end_day="20" end_year="2018" days="Days" hours="Hours" minutes="Minutes"][/vc_column]');?>
                    </div>
                  </div>
               </div>
           </div>
        </div>
        
        <div class="wpb_column vc_column_container vc_col-sm-4">
        	<div class="vc_column-inner ">
            	<div class="wpb_wrapper">
                	<div class="textcenter theme-button-block-wrap theme-button-wrap clr"><a href="https://www.ticketmaster.com/" title="Buy Cheyenne Frontier Days Tickets" class="vcex-button theme-button align-center block buyTicketsBlue animate-on-hover wpex-data-hover" target="_blank" style="background:#2467ee;padding-top:15px;padding-right:35px;padding-bottom:16px;padding-left:35px;color:#ffffff;font-size:17px;font-weight:400;letter-spacing:0.75px;border-radius:0px;text-transform:capitalize;" data-hover-background="#4f84ef" data-hover-color="#ffffff"><span class="theme-button-inner">BUY TICKETS</span></a>
                    </div> 
                 </div>
              </div>
           </div>
        </div>
<?php wpex_hook_page_header_before(); ?>
<header class="<?php echo wpex_page_header_classes(); ?>">
	
	<?php wpex_hook_page_header_top(); ?>
	
	<div class="page-header-inner container clr">
		<?php wpex_hook_page_header_inner(); // All default content added via this hook ?>
	</div><!-- .page-header-inner -->

	<?php wpex_hook_page_header_bottom(); ?>

</header><!-- .page-header -->

<?php wpex_hook_page_header_after(); ?>