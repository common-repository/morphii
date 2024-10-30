<?php // phpcs:ignore WordPress.NamingConventions

/**

 * morphii_advanced_Data class

 *

 * @package morphii\includes

 */



if ( ! defined( 'ABSPATH' ) ) {

    exit( 'Direct access forbidden.' );

}



global $MWAR_AdvancedReview;



if ( ! class_exists( 'Morphii_Data' ) ) {

    

    class Morphii_Data {



        private $mwar;



        protected static $instance;



        public function __construct() {



            add_action( 'init', array( $this, 'create_morphii_database' ) );



        }



        public static function get_instance() {



            if ( is_null( self::$instance ) ) {



                self::$instance = new self();



            }



            return self::$instance;



        }



        public function create_morphii_database() {

            

            global $wpdb;



            $morphii = file_get_contents(MORPHII_MWAR_URL . 'assets/data/morphii_data.json');



            $json_morphiies = json_decode($morphii);

			$post_id=0;

            if(!empty($json_morphiies)){


                foreach ($json_morphiies as $morphii_key => $morphii_value) {
					
					$dbqry=$wpdb->prepare( "SELECT post_id FROM  ".$wpdb->postmeta." WHERE meta_value = %s AND meta_key =%s", array(  $morphii_value->Question_ID, 'morphii-question-id' ) );

					$results = $wpdb->get_results( $dbqry, ARRAY_A );
					
					if($results==null){
	
						$new_post = array(
                            'post_title' => $morphii_value->Question_Name,
                            'post_content' => '',
                            'post_status' => 'publish',
                            'post_date' => date('Y-m-d H:i:s'),
                            'post_author' => get_current_user_id(),
                            'post_type' => 'morphii-questions',
                            'post_parent' => 0,
                        );

                        $post_id = wp_insert_post($new_post);

                        if(!empty($post_id)){

                            update_post_meta( $post_id, 'morphiis', $morphii_value->Morphiies);  

                            update_post_meta( $post_id, 'morphii-question-id', $morphii_value->Question_ID );

                        } 

				}
				else{
					
					$post_id=$results[0]['post_id'];
					update_post_meta( $post_id, 'morphiis', $morphii_value->Morphiies);  

                        update_post_meta( $post_id, 'morphii-question-id', $morphii_value->Question_ID );
					
					for($i=1;$i<count($results);$i++){
						wp_delete_post( $results[$i]['post_id'],true);
					}
				}



                   

                }        

            }

        }             

    }

}