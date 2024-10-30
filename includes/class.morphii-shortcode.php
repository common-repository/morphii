<?php // phpcs:ignore WordPress.NamingConventions
/**
 * morphii_advanced_Shortcode class
 *
 * @package morphii\includes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct access forbidden.' );
}

global $MWAR_AdvancedReview;


if ( ! class_exists( 'Morphii_Shortcode' ) ) {
    
    class Morphii_Shortcode {

        private $mwar;

        protected static $instance;

        public function __construct() {

            add_shortcode( 'morphii-reviews',  array( $this, 'create_morphii_shortcode' ));

        }

        public static function get_instance() {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self();

            }

            return self::$instance;

        }

        public function create_morphii_shortcode($atts) {
            
            global $post;
            
            $current_post_type = get_post_type( get_the_ID() );
            if(!empty($atts)){
                $question_id = $atts['question_ids'];
            }            
            // get the option
            if(!empty(get_option( 'morphii-settings' ))){
                $settings_inner = json_decode(get_option( 'morphii-settings' ));
            }
            // get the option
            if(!empty(get_option( 'morphii-settings' ))){
                $settings = json_decode(get_option( 'morphii-settings' ));
                $fontSize = $settings->morphii_question_font_size ? $settings->morphii_question_font_size : "16px";
                $linkColor  = $settings->morphii_submit_color ? $settings->morphii_submit_color : "#ffc940";
                $fontFamily = $settings->morphii_font_family ? $settings->morphii_font_family : "inherit";
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
            
            ob_start();?>
            <style type="text/css">
                #morphii-submit-button {
                   background: <?php echo esc_attr($linkColor); ?>;
                   font-family: <?php echo esc_attr($fontFamily); ?>;
                   width: 100%;
                   border-radius: 0px;
                   height: 50px;
                }
                .morphii-form-group {
                    margin-bottom: 20px;
                }
                .morphii-label {
                   font-family: <?php echo esc_attr($fontFamily); ?>;
                }
                .morphii-item-name-no-wrap span{
                   font-family: <?php echo esc_attr($fontFamily); ?>;
                }
                .morphii-target-container h4{
                   font-family: <?php echo esc_attr($fontFamily); ?>;
                   font-size: <?php echo esc_attr($fontSize); ?>;
                }
                .error-text {
                   font-family: <?php echo esc_attr($fontFamily); ?>;
                   color: red;
                }
                .morphii-slider-left-label,.morphii-slider-right-label{
                   font-family: <?php echo esc_attr($fontFamily); ?>;
                }
				.morphii-container .morphii-list .morphii-item .morphii-item-name-no-wrap {
					font-size: 10px;
				}
            </style>
            <?php if(!isset($licence_inner)){ ?>
                <div id="morphii" class="morphii">
                    You can't use morphii shortcode without license. So please add license key and account id to your license page.
                </div>
            <?php } else{?>
            <div id="morphii" class="morphii">
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
                                        <input type="hidden" name="morphii-current-post_type" id="morphii-current-post_type" class="morphii-current-post_type" value="<?php echo esc_attr($current_post_type); ?>" />

                                        <input type="hidden" name="morphii_account_key" id="morphii_account_key" class="morphii_account_key" value="<?php echo isset($licence_inner) && $licence_inner->morphii_account_key ? esc_attr($licence_inner->morphii_account_key) : '349ec444-474f-4084-9dcd-b373ddb444cd'; ?>" />
                                        <input type="hidden" name="morphii_account_id" id="morphii_account_id" class="morphii_account_id" value="<?php echo isset($licence_inner) && $licence_inner->morphii_account_id ? esc_attr($licence_inner->morphii_account_id) : '17254444'; ?>" />
										<input type='hidden' id='slider_moved'/>
                                        <?php
                                            if(!empty($question_id)){
                                                $questions = explode(",", $question_id);
                                                    while ( $the_query->have_posts() ) : 
                                                        $the_query->the_post(); 
                                                        $question_ids = get_post_meta( $post->ID, 'morphii-question-id', true );
                                                        if(in_array($question_ids, $questions)){
                                                            $morphiis = get_post_meta( $post->ID, 'morphiis', true );
                                                            $all_morphiis = [];
                                                            if(!empty($morphiis)){
                                                                //$morphii_array = json_decode($morphiis,true);
                                                                foreach($morphiis as $morphiiss){
                                                                    foreach($morphiiss as $morphii_name => $morphii_image){
                                                                        array_push($all_morphiis, $morphii_image);
                                                                    }
                                                                }
                                                                echo '<input type="hidden" name="questioned-morphiies" id="questioned-morphiies_'.$question_ids.'" value="'.esc_attr(implode(',', $all_morphiis)).'" />';
                                                            }else{
                                                                echo '<input type="hidden" name="questioned-morphiies" id="questioned-morphiies_'.$question_ids.'" value="" />';
                                                            }?>
                                                            <h4 id="q_<?php echo esc_attr($question_ids); ?>" class="morphii-questions"><?php the_title(); ?></h4>
                                                            <div id="widget-q_<?php echo esc_attr($question_ids); ?>"></div>
                                                            <?php if(isset($settings_inner) && $settings_inner->enable_text_reviews == 'yes'){ ?>
                                                                <textarea name="morphii-comment" rows="5" id="comment_<?php echo esc_attr($question_ids); ?>" class="morphii-user_message" placeholder="Enter your review here" required></textarea>
                                                            <?php } ?>                                                         
                                                        
                                                        <?php } 
                                                    endwhile; 

                                            }else {

                                                while ( $the_query->have_posts() ) : 
                                                    $the_query->the_post();

                                                    $morphiis = get_post_meta( $post->ID, 'morphiis', true );

                                                    if(!empty($morphiis)){
                                                        //$morphii_array = json_decode($morphiis,true);
                                                        $all_morphiis = [];
                                                        foreach($morphiis as $morphiiss){
                                                            foreach($morphiiss as $morphii_name => $morphii_image){
                                                                array_push($all_morphiis, $morphii_image);
                                                            }
                                                        }
                                                        echo '<input type="hidden" name="questioned-morphiies" id="questioned-morphiies_'.$question_ids.'" value="'.esc_attr(implode(',', $all_morphiis)).'" />';
                                                    }else{
                                                            echo '<input type="hidden" name="questioned-morphiies" id="questioned-morphiies_'.$question_ids.'" value="" />';
                                                    }?>
                                                    <h4 id="q_<?php echo esc_attr($question_ids); ?>" class="morphii-questions"><?php the_title(); ?></h4>
                                                    <div id="widget-q_<?php echo esc_attr($question_ids); ?>"></div>
                                                    <?php if($settings_inner->enable_text_reviews == 'yes'){ ?>
                                                        <textarea name="morphii-comment" rows="5" id="comment_<?php echo esc_attr($question_ids); ?>" class="morphii-user_message" placeholder="Enter your review here" required></textarea>
                                                    <?php } ?> 
                                                        
                                                    <?php endwhile; 
                                            }
                                                
                                            wp_reset_postdata(); ?>
                                        </div>
                                    <?php
                                    else: 

                                    endif; ?>   
                                        
                                        <div class="center-div">
                                            <input type="hidden" name="morphii_product_id" id="morphii_product_id" value="<?php echo esc_attr($question_ids); ?>" />
                                            <button id="morphii-submit-button" type="button" class="btn btn-default submit"><?php echo isset($settings_inner) && $settings_inner->morphii_submit_button_text ? esc_attr($settings_inner->morphii_submit_button_text) : "Submit"; ?></button>
                                        </div>
                                </div>
                                <p class="SuccessFormSubmitMorphii"></p>
                                <p class="ErrorFormSubmitMorphii"></p>
                            </div>

                        <div class="clear"></div>
                    </div>
            <?php } return ob_get_clean(); 

        }
        
    }
}