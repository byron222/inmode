<?php

/*** Child Theme Function  ***/

function qodef_child_theme_enqueue_scripts() {
	wp_register_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css'  );
	wp_enqueue_style( 'childstyle' );
	wp_enqueue_script( 'footerfixed', get_stylesheet_directory_uri() . '/js/footerFixed.js', '20140319', true );
	wp_enqueue_script( 'furigana', get_stylesheet_directory_uri() . '/js/jquery.autoKana.js', '20140319', true );
}
add_action('wp_enqueue_scripts', 'qodef_child_theme_enqueue_scripts', 11);


add_filter( 'woocommerce_product_tabs', 'bbloomer_remove_product_tabs', 98 );
 
function bbloomer_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] ); 
    return $tabs;
}

//WordPress自体の読み込みをキャンセル
wp_deregister_script( 'jquery' );
//バージョンの指定
wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');



add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );


//add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );
	if ( strcmp( $password, $password2 ) !== 0 ) {
		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
	}
	return $reg_errors;
}
//add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );
function wc_register_form_password_repeat() {
	?>
	<p class="form-row form-row-wide">
		<label for="reg_password2"><?php _e( 'パスワード確認', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
	</p>
	<?php
}


function wooc_extra_register_fields() {
       ?>
       
       

      <p class="form-row form-row-last">

       <label for="reg_shipping_yomigana_first_name"><?php _e( '名（カタカナ）', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="shipping_yomigana_first_name" id="reg_shipping_yomigana_first_name" value="<?php if ( ! empty( $_POST['shipping_yomigana_first_name'] ) ) esc_attr_e( $_POST['shipping_yomigana_first_name'] ); ?>" />

       </p>
       
       <p class="form-row form-row-last">

       <label for="reg_shipping_yomigana_last_name"><?php _e( '氏（カタカナ）', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="shipping_yomigana_last_name" id="reg_shipping_yomigana_last_name" value="<?php if ( ! empty( $_POST['shipping_yomigana_last_name'] ) ) esc_attr_e( $_POST['shipping_yomigana_last_name'] ); ?>" />

       </p>
      
       <p class="form-row form-row-last">

       <label for="reg_shipping_romaji_first_name"><?php _e( '名（ローマ字）', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="shipping_romaji_first_name" id="reg_shipping_romaji_first_name" value="<?php if ( ! empty( $_POST['shipping_romaji_first_name'] ) ) esc_attr_e( $_POST['shipping_romaji_first_name'] ); ?>" />

       </p>
       
       <p class="form-row form-row-last">

       <label for="reg_shipping_romaji_last_name"><?php _e( '氏（ローマ字）', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="shipping_romaji" id="reg_shipping_romaji_last_name" value="<?php if ( ! empty( $_POST['shipping_romaji_last_name'] ) ) esc_attr_e( $_POST['shipping_romaji_last_name'] ); ?>" />

       </p>
       <?php

}

add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );



function wc_limit_account_menu_items(){
 
 $items = array(
 //'dashboard'       => __( 'Dashboard', 'woocommerce' ),
 'orders'          => __( 'Orders', 'woocommerce' ),
 //'downloads'       => __( 'Downloads', 'woocommerce' ),
 'edit-address'    => __( 'Addresses', 'woocommerce' ),
 'payment-methods' => __( 'Payment methods', 'woocommerce' ),
 'edit-account'    => __( 'Account details', 'woocommerce' ),
 //'customer-logout' => __( 'Logout', 'woocommerce' ),
 );
 

 return $items;
}
add_filter( 'woocommerce_account_menu_items', 'wc_limit_account_menu_items' );



add_action('woocommerce_checkout_init','disable_billing');
function disable_billing($checkout){
  $checkout->checkout_fields['billing']=array();
  return $checkout;
  }


add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_city']);
    return $fields;
}



add_filter( 'wp_get_attachment_image_attributes', 'remove_image_text');
 function remove_image_text( $attr ) {
 unset($attr['alt']);
 unset($attr['title']);
 unset($attr['data-image-title']);
 unset($attr['data-image-description']);
 return $attr;
}


function remove_caption( $fields ) {
    unset( $fields['image_alt'] );
    return $fields;
}
add_filter( 'attachment_fields_to_edit', 'remove_caption', 999, 1 );


// remove the action 
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20 );




// define the woocommerce_after_single_product callback 
function action_woocommerce_after_single_product(  ) { 
    //echo do_shortcode('[wmvp_most_viewed_products number_of_products_in_row="10" posts_per_page="10"]');
	//echo do_shortcode('[wrvp_recently_viewed_products number_of_products_in_row="10" posts_per_page="10"]');
}; 
         
// add the action 
add_action( 'woocommerce_after_single_product', 'action_woocommerce_after_single_product', 10, 0 ); 


/*
 * Content below "Add to cart" Button.
 */
if ( is_user_logged_in() ) {
	//add_action( 'woocommerce_before_add_to_cart_button', 'add_content_before_addtocart_button_func' );
} else {

}

function add_content_before_addtocart_button_func() {
        echo do_shortcode('[contact-form-7 id="973" title="Contact form 1"]');
}

//add_filter( 'woocommerce_product_tabs', 'product_enquiry_tab' );
function product_enquiry_tab( $tabs ) {

    $tabs['contact'] = array(
        'title'     => __( 'コメント', 'woocommerce' ),
        'priority'  => 50,
        'callback'  => 'product_enquiry_tab_form'
    );

    return $tabs;

}
function product_enquiry_tab_form() {
    global $product;
    //If you want to have product ID also
    //$product_id = $product->id;
    $subject    =   $product->post->post_title;

    echo "<h3>".$subject."</h3>";
    echo do_shortcode('[contact-form-7 id="973" title="Contact form 1"]'); //add your contact form shortcode here ..

    ?>

    <script>
    (function($){
        $(".product_name").val("<?php echo $subject; ?>");
    })(jQuery);
    </script>   
    <?php   
}
    ?>