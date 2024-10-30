<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct access forbidden.' );
}

global $MWAR_AdvancedReview;


if ( ! class_exists( 'Morphii_Questions_Table' ) ) {
    
    class Morphii_Questions_Table extends WP_List_Table {

        private $mwar;

        public function __construct() {
            global $Morphii_AdvancedReview; 

            $this->mwar = $Morphii_AdvancedReview;

            parent::__construct(
                array(
                    'singular' => 'morphii-question', 
                    'plural'   => 'morphii-questions', 
                    'ajax'     => false,
                )
            );
        }

        public function get_columns() {
            $columns = array(
                'cb'                               => '<input type="checkbox" />',
                $this->mwar->custom_column_question  => esc_html__( 'Question ID', 'morphii' ),
                $this->mwar->custom_column_question_name    => esc_html__( 'Question Name', 'morphii' ),
                $this->mwar->custom_column_morphiies => esc_html__( 'Question Morphiis', 'morphii' ),
                $this->mwar->custom_column_morphii_author  => esc_html__( 'Author', 'morphii' ),
            );

            return apply_filters( 'morphii_advanced_reviews_custom_column', $columns );
        }

        protected function row_actions( $actions, $always_visible = false ) {
            $action_count = count( $actions );
            $i = 0;

            if ( ! $action_count ) {
                return '';
            }

            $out = '<div class="' . ( $always_visible ? 'row-actions visible' : 'row-actions' ) . '">';
            foreach ( $actions as $action => $link ) {
                ++$i;
                ( $i === $action_count ) ? $sep = '' : $sep = ' | ';
                $out                           .= "<span class='$action'>$link$sep</span>";
            }
            $out .= '</div>';

            return $out;
        }

        private function get_params_for_current_view( $args ) {
            // Start the filters array, selecting the review post type.
            $params = array(
                'post_type'        => 'morphii-questions',
                'suppress_filters' => false,
            );

            // Show a single page or all items.
            $params['numberposts'] = -1;
            if ( isset( $args['page'] ) && ( $args['page'] > 0 ) && isset( $args['items_for_page'] ) && ( $args['items_for_page'] > 0 ) ) {

                // Set number of posts and offset.
                $current_page          = $args['page'];
                $items_for_page        = $args['items_for_page'];
                $offset                = ( $current_page * $items_for_page ) - $items_for_page;
                $params['offset']      = $offset;
                $params['numberposts'] = $items_for_page;

            } else {
                $params['offset'] = 0;
            }

            // Choose post status.
            if ( isset( $args['post_status'] ) && ( 'all' !== $args['post_status'] ) ) {
                $params['post_status'] = $args['post_status'];
            }

            if ( isset( $args['post_parent'] ) && ( $args['post_parent'] >= 0 ) ) {
                $params['post_parent'] = $args['post_parent'];
            }

            $order           = isset( $args['order'] ) ? $args['order'] : 'ASC';
            $params['order'] = $order;

            // if ( isset( $args['orderby'] ) ) {
            //     $order_by = $args['orderby'];
            //     switch ( $order_by ) {
            //         // case $this->mwar->custom_column_rating:
            //         //     $params['meta_key'] = $this->mwar->meta_key_rating; //phpcs:ignore slow query ok.
            //         //     $params['orderby']  = 'meta_value_num';
            //         //     break;

            //         case $this->mwar->custom_column_date:
            //             $params['orderby'] = 'post_date';
            //             break;

            //         default:
            //             $params = apply_filters( 'morphii_advanced_reviews_column_sort', $params, $order_by );
            //     }
            // }

            // if ( isset( $args['post_status'] ) ) {

            //     switch ( $args['post_status'] ) {
            //         case 'all':
            //             break;

            //         case 'trash':
            //             $params['post_status'] = 'trash';

            //             break;

            //         case 'not_approved':
            //             $params['meta_query'][] = array(
            //                 'key'     => $this->mwar->meta_key_approved,
            //                 'value'   => 1,
            //                 'compare' => '!=',
            //                 'type'    => 'numeric',
            //             );
            //             break;

            //         default:
            //             $params = apply_filters( 'morphii_advanced_reviews_filter_view', $params, $args['review_status'] );
            //     }
            // }

            return $params;
        }

        public function filter_reviews_by_search_term( $where ) {
            $filter_content = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
            $terms          = explode( '+', $filter_content );
            global $wpdb;
            $where_clause = '';
            foreach ( $terms as $term ) {
                if ( ! empty( $where_clause ) ) {
                    $where_clause .= ' OR ';
                }
                $where_clause .= "( {$wpdb->prefix}posts.post_content LIKE '%$term%' ) or ({$wpdb->prefix}posts.post_title like '%$term%') ";
            }

            $where = "$where AND ($where_clause)";

            return $where;
        }

        // public function process_bulk_action() {
        //     switch ( $this->current_action() ) {

        //         case 'untrash':
        //             $reviews = isset( $_GET['morphii-reviews'] ) ? $_GET['morphii-reviews'] : '';//phpcs:ignore --Sanitize doenst´t work. Nonce
        //             foreach ( $reviews as $review_id ) {//phpcs:ignore WordPress.Security.NonceVerification
        //                 $my_post = array(
        //                     'ID'          => $review_id,
        //                     'post_status' => 'publish',
        //                 );

        //                 // Update the post into the database.
        //                 wp_update_post( $my_post );
        //             }

        //             break;

        //         case 'trash':
        //             $reviews = isset( $_GET['morphii-reviews'] ) ? $_GET['morphii-reviews'] : ''; //phpcs:ignore --Sanitize doenst´t work. Nonce
        //             foreach ( $reviews as $review_id ) {
        //                 $my_post = array(
        //                     'ID'          => $review_id,
        //                     'post_status' => 'trash',
        //                 );

        //                 // Update the post into the database.
        //                 wp_update_post( $my_post );
        //             }

        //             break;

        //         case 'delete':
        //             $reviews = isset( $_GET['morphii-reviews'] ) ? $_GET['morphii-reviews'] : '';//phpcs:ignore --Sanitize doenst´t work. Nonce

        //             foreach ( $reviews as $review_id ) {
        //                 wp_delete_post( $review_id );
        //             }

        //             break;

        //         case 'approve':
        //             $reviews = isset( $_GET['morphii-reviews'] ) ? $_GET['morphii-reviews'] : '';//phpcs:ignore --Sanitize doenst´t work. Nonce

        //             foreach ( $reviews as $review_id ) {
        //                 update_post_meta( $review_id, $this->mwar->meta_key_approved, 1 );
        //             }

        //             break;

        //         case 'unapprove':
        //             $reviews = isset( $_GET['morphii-reviews'] ) ? $_GET['morphii-reviews'] : '';//phpcs:ignore --Sanitize doenst´t work. Nonce

        //             foreach ( $reviews as $review_id ) {
        //                 update_post_meta( $review_id, $this->mwar->meta_key_approved, 0 );
        //             }

        //             break;

        //         default:
        //             if ( isset( $_GET['morphii-reviews'] ) ) {//phpcs:ignore WordPress.Security.NonceVerification
        //                 do_action( 'morphii_advanced_reviews_process_bulk_actions', $this->current_action(), sanitize_text_field( wp_unslash( $_GET['reviews'] ) ) );
        //             }
        //     }
        // }

        /**
         * Prepare items for table
         *
         * @return void
         * @since 1.0.0
         */
        public function prepare_items() {
            //$this->process_bulk_action();

            // Sets pagination arguments.
            $current_page = absint( $this->get_pagenum() );

            // Sets columns headers.
            $columns               = $this->get_columns();
            $hidden                = array();
            //$sortable              = $this->get_sortable_columns();
            $this->_column_headers = array( $columns, $hidden);

            $review_status = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : 'all';//phpcs:ignore WordPress.Security.NonceVerification
            $orderby       = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : '';//phpcs:ignore WordPress.Security.NonceVerification
            $order         = isset( $_GET['order'] ) ? sanitize_text_field( wp_unslash( $_GET['order'] ) ) : 'asc';//phpcs:ignore WordPress.Security.NonceVerification

            // Start the filters array, selecting the review post type.
            $params = array(
                'post_type'      => 'morphii-questions',
                'items_for_page' => $this->mwar->items_for_page,
                'review_status'  => $review_status,
                'orderby'        => $orderby,
                'order'          => $order,
            );

            // Retrieve the number of items for the current filters.
            $args           = $this->get_params_for_current_view( $params );
            $args['fields'] = 'ids';
            $total_items    = count( get_posts( $args ) );

            // Retrieve only a page for the current filter.
            $params['page'] = $current_page;
            $args           = $this->get_params_for_current_view( $params );

            $filter_content = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';//phpcs:ignore WordPress.Security.NonceVerification
            if ( ! empty( $filter_content ) ) {
                // Add a filter to alter WHERE clause on following get_posts call.
                add_filter( 'posts_where', array( $this, 'filter_reviews_by_search_term' ) );
            }

            $this->items = get_posts( $args );

            // Remove the previous filter, not needed anymore.
            remove_filter( 'posts_where', array( $this, 'filter_reviews_by_search_term' ) );

            $total_pages = ceil( $total_items / $this->mwar->items_for_page );

            // Set the pagination.
            $this->set_pagination_args(
                array(
                    'total_items' => $total_items,
                    'per_page'    => $this->mwar->items_for_page,
                    'total_pages' => $total_pages,
                )
            );
        }

        // public function get_sortable_columns() {

        //     $columns = array(

        //         //$this->mwar->custom_column_rating => array( $this->mwar->custom_column_rating, false ),
        //         $this->mwar->custom_column_date   => array( $this->mwar->custom_column_date, false ),
        //     );

        //     return apply_filters( 'morphii_advanced_reviews_sortable_custom_columns', $columns );
        // }

        // public function get_bulk_actions() {
        //     $actions = array();

        //     $actions['untrash'] = esc_html__( 'Restore', 'morphii' );
        //     $actions['trash']   = esc_html__( 'Move to bin', 'morphii' );

        //     $actions['delete']    = esc_html__( 'Delete permanently', 'morphii' );
        //     $actions['approve']   = esc_html__( 'Approve reviews', 'morphii' );
        //     $actions['unapprove'] = esc_html__( 'Unapprove reviews', 'morphii' );

        //     return apply_filters( 'morphii_advanced_reviews_bulk_actions', $actions );
        // }

        protected function get_views() {
            $views = array(
                'all'          => esc_html__( 'All', 'morphii' ),
                'trash'        => esc_html__( 'Bin', 'morphii' ),
                'not_approved' => esc_html__( 'Not approved', 'morphii' ),
            );

            $views = apply_filters( 'morphii_advanced_reviews_table_views', $views );

            $current_view = $this->get_current_view();
            $args         = array( 'status' => 0 );

            $args['user_id'] = get_current_user_id();

            unset( $views['processing'] );

            foreach ( $views as $id => $view ) {
                // number of items for the view.
                $args           = $this->get_params_for_current_view(
                    array(
                        'review_status' => $id,
                    )
                );
                $args['fields'] = 'ids';

                // retrieve the number of items for the current filters.
                $total_items = count( get_posts( $args ) );

                $href           = esc_url( add_query_arg( 'status', $id ) );
                $class          = $id === $current_view ? 'current' : '';
                $args['status'] = 'unpaid' === $id ? array( $id, 'processing' ) : $id;
                $views[ $id ]   = sprintf( "<a href='%s' class='%s'>%s <span class='count'>(%d)</span></a>", $href, $class, $view, $total_items );
            }

            return $views;
        }

        public function column_default( $review, $column_name ) {

            switch ( $column_name ) {

                case $this->mwar->custom_column_question:
                    $post = get_post( $review->ID );
                    if ( empty( $post->post_title ) && empty( $post->post_content ) ) {
                        return;
                    }
                    $product_id = get_post_meta( $review->ID, 'morphii-question-id', true );
                    echo '<p class="row-title">';
                        echo '<span class="review-title">' . wp_kses( wp_trim_words( $product_id, 80 ), 'post' ) . '</span>';
                    echo '</p>';

                    break;

                case $this->mwar->custom_column_question_name:
                    $post = get_post( $review->ID );
                    if ( empty( $post->post_title ) && empty( $post->post_content ) ) {
                        return;
                    }
                    echo '<p class="row-title">';
                        echo '<span class="review-title">' . wp_kses( $post->post_title, 'post' ) . '</span>';
                    echo '</p>';

                    break;

                case $this->mwar->custom_column_morphiies:
                    $morphiis = get_post_meta( $review->ID, 'morphiis', true );

                    if(!empty($morphiis)){
                        ?>
                        <div id="morphii-lists" class="morphii-list-groups">
                        <?php
                        foreach($morphiis as $morphiiss){
                            foreach($morphiiss as $morphii_name => $morphii_image){
                               // if (preg_match('/[_]/', $morphii_image)){
                                    //$image_m = explode("_",$morphii_image);                        
                                ?>
                                   <!--  <div class="morphi-images">
                                        <img id="<?php //echo $image_m[0]; ?>" src="https://cdn1.morphii.com/morphii/images/<?php //echo $image_m[0]; ?>.jpg" class="morphii-list-image"/>  <br/>
                                        <span><?php //echo $morphii_name; ?></span>  
                                    </div>    -->                 
                                <?php //} else{ ?>
                                    <div class="morphi-images">
                                        <img id="<?php echo esc_attr($morphii_image); ?>" src="<?=MORPHII_MWAR_URL.'assets/images/'.esc_attr($morphii_image).'.jpg'; ?>" class="morphii-list-image"/> <br/>
                                        <span><?php echo esc_attr($morphii_name); ?></span>
                                    </div>   
                            <?php //} 
                        } } ?>
                        </div>
                        <?php
                    }                    

                    break;

                case $this->mwar->custom_column_morphii_author:
                    $current_user = wp_get_current_user();
                    
                    
                    echo '<p class="row-title">';
                        echo '<span class="review-title">' . esc_attr($current_user->display_name). '</span>';
                    echo '</p>';

                    break;
               

                default:
                    do_action( 'morphii_advanced_reviews_show_advanced_reviews_columns', $column_name, $review->ID );
            }

            return null;
        }
        // public function column_cb( $rec ) {

        //     return sprintf(
        //         '<input type="checkbox" name="%1$s[]" value="%2$s" />',
        //         $this->_args['plural'], // Let's simply repurpose the table's plural label.
        //         $rec->ID // The value of the checkbox should be the record's id.
        //     );
        // }

        public function no_items() {
            esc_html_e( 'No questions found.', 'morphii' );
        }


        public function get_current_view() {
            return empty( $_GET['status'] ) ? 'all' : sanitize_text_field( wp_unslash( $_GET['status'] ) );//phpcs:ignore WordPress.Security.NonceVerification
        }

        

        public function single_row( $item ) {
            $approved = 1 === intval( get_post_meta( $item->ID, $this->mwar->meta_key_approved, true ) );
            if ( ! $approved ) {
                echo '<tr class="review-unapproved">';
            } else {
                echo '<tr>';
            }

            $this->single_row_columns( $item );
            echo '</tr>';
        }
    }
}