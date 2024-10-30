<?php
/**
 * Display single product reviews (comments)
 *
 * @author Morphii Team
 */

global $product, $post;
global $Morphii_AdvancedReview;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$product_id = $product->get_id();
if (!comments_open($product_id)) {
    return;
}

// get the option
if(!empty(get_option( 'morphii-settings' ))){
    $settings_inner = json_decode(get_option( 'morphii-settings' ));
} 

// get the option
if(!empty(get_option( 'morphii-licence' ))){
    $licence_inner = json_decode(get_option( 'morphii-licence' ));
} 

$args = array(
	'post_type'=> 'morphii-questions',
	'post_status' => 'publish',
    'posts_per_page' => -1,
	'order' => 'ASC'
);      
?>

<div id="morphii" class="morphii-woocommerce-advanced-reviews">

	<?php if ( is_user_logged_in() && (get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product_id ) ) ): ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$the_query = new WP_Query( $args );
				if($the_query->have_posts() ) : 
					if(is_user_logged_in()){
						$current_user = wp_get_current_user();
						$name = $current_user->display_name;
						$email = $current_user->user_email;
						$user_id = $current_user->ID;
					}else{
						$name = '';
						$email = '';
						$user_id = '';
					}
					?>
					<div id="target-container" class="morphii-target-container">
						<input type="hidden" name="morphii-current-user" id="morphii-current-user" class="morphii-current_user" value="<?php echo esc_attr($user_id); ?>" />
						<input type="hidden" name="morphii-current-post_name" id="morphii-current-post_name" class="morphii-current-post_name" value="<?php echo esc_attr(get_the_title()); ?>" />
                        <input type="hidden" name="morphii-current-post_id" id="morphii-current-post_id" class="morphii-current-post_id" value="<?php echo esc_attr(get_the_ID()); ?>" />
                        <input type="hidden" name="morphii-current-post_type" id="morphii-current-post_type" class="morphii-current-post_type" value="product" />
                        
                        <input type="hidden" name="morphii_account_key" id="morphii_account_key" class="morphii_account_key" value="<?php echo $licence_inner->morphii_account_key ? esc_attr($licence_inner->morphii_account_key) : '349ec444-474f-4084-9dcd-b373ddb444cd'; ?>" />
                        <input type="hidden" name="morphii_account_id" id="morphii_account_id" class="morphii_account_id" value="<?php echo $licence_inner->morphii_account_id ? esc_attr($licence_inner->morphii_account_id) : '17254444'; ?>" />
                        
						<!-- <div class="morphii-form-group morphii-current-user-name">
							<label class="morphii-label">Name</label>
							<input type="text" name="morphii-user-name" id="morphii-user-name" class="morphii-user_name" value="<?php //echo $name; ?>" required/>
							<p id="morphii-error-user-name" class="error-text"></p>
						</div>
						<div class="morphii-form-group morphii-current-user-email">
							<label class="morphii-label">Email</label>
							<input type="email" name="morphii-user-email" id="morphii-user-email" class="morphii-user_email" value="<?php //echo $email; ?>" />
							<p id="morphii-error-user-email" class="error-text"></p>
						</div> -->
						<?php
							while ( $the_query->have_posts() ) : 
								$the_query->the_post(); 

							$morphiis = get_post_meta( $post->ID, 'morphiis', true );

							if(!empty($morphiis)){
								$morphii_array = unserialize($morphiis);
								echo '<input type="hidden" name="questioned-morphiies" id="questioned-morphiies_'.$post->ID.'" value="'.implode(',', $morphii_array).'" />';
							}else{
								echo '<input type="hidden" name="questioned-morphiies" id="questioned-morphiies_'.$post->ID.'" value="" />';
							}?>
							<h4 id="q_<?php echo esc_attr($post->ID); ?>" class="morphii-questions"><?php the_title(); ?></h4>
					    	<div id="widget-q_<?php echo esc_attr($post->ID); ?>"></div>
					    	<?php if($settings_inner->enable_text_reviews == 'yes'){ ?>
					    		<textarea name="morphii-comment" rows="5" id="comment_<?php echo esc_attr($post->ID); ?>" class="morphii-user_message" placeholder="Enter your review here" required></textarea>
					    	<?php } ?>

						<?php endwhile; 
						wp_reset_postdata(); ?>
					</div>
				<?php
				else: 

				endif; ?>	
					
					<div class="center-div">
						<input type="hidden" name="morphii_product_id" id="morphii_product_id" value="<?php echo esc_attr($product_id); ?>" />
					    <button id="morphii-submit-button" type="button" class="btn btn-default submit"><?php echo $settings_inner->morphii_submit_button_text ? esc_attr($settings_inner->morphii_submit_button_text) : "Submit"; ?></button>
					</div>
			</div>

			<p class="SuccessFormSubmitMorphii"></p>
			<p class="ErrorFormSubmitMorphii"></p>
		</div>
	<?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in users may share a review. Please login and share your valuable reviews with how you feel morphiis.', 'morphii-woocommerce-advanced-reviews' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>