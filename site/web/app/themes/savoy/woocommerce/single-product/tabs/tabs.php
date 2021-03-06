<?php
/**
 * Single Product tabs
 *
 * @author 	WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $nm_theme_options, $product;

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

// Description
$nm_product_description_layout_meta = get_post_meta( $product->id, 'nm_product_description_full', true );
if ( $nm_theme_options['product_description_layout'] == 'full' || ! empty( $nm_product_description_layout_meta ) ) {
    $description_layout_full = true;
    $description_layout_class = ' description-full';
} else {
    $description_layout_full = false;
    $description_layout_class = '';
}

if ( ! empty( $tabs ) ) : ?>

    <div class="woocommerce-tabs wc-tabs-wrapper<?php echo esc_attr( $description_layout_class ); ?>">
        <div class="nm-product-tabs-col">
        	<div class="nm-row">
                <div class="col centered col-md-10 col-xs-12">
                    <ul class="tabs wc-tabs">
                        <?php foreach ( $tabs as $key => $tab ) : ?>
            
                            <li class="<?php echo esc_attr( $key ); ?>_tab">
                                <a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ) ?></a>
                            </li>
            
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <?php
                foreach ( $tabs as $key => $tab ) :
                
					if ( $key == 'description' ) {
						$tab_panel_class = $description_layout_class . ' entry-content'; // Only add "entry-content" class to the "description" tab-panel
						$tab_is_description = true;
					} else {
						$tab_panel_class = '';
						$tab_is_description = false;
					}
            ?>
                <div class="panel wc-tab<?php echo esc_attr( $tab_panel_class ); ?>" id="tab-<?php echo esc_attr( $key ); ?>">
                    <?php
                        if ( $tab_is_description && $description_layout_full ) :
							call_user_func( $tab['callback'], $key, $tab );
						else :
                    ?>
                    <div class="nm-row">
                        <div class="col centered col-md-10 col-xs-12">
                            <?php call_user_func( $tab['callback'], $key, $tab ); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>
