<?php
$get_review_id = sanitize_text_field($_GET['review_id']);
$args = array('p' => $get_review_id, 'post_type' => 'morphii-reviews');
$loop = new WP_Query($args);

$reviewer_name = get_post_meta($get_review_id,'_morphii_reviewer_user_name',true);
$reviewer_email = get_post_meta($get_review_id,'_morphii_reviewer_user_email',true);
$current_post_name = get_post_meta($get_review_id,'morphii-current-post_name',true);
$post_type_review = get_post_meta($get_review_id,'morphii-current-post_type',true);
$morphii_final_review = get_post_meta($get_review_id,'_morphii_final_review',true);
if(!empty($morphii_final_review)){
    $morphii_final_review_array = json_decode($morphii_final_review);
}
?>

<div class="wrap">

    <h2><?php _e( 'Single Review', 'morphii' ) ?></h2>        

        <h2>Review's Post Details</h2>

        <table class="form-table">
            <tbody>
                <tr class="post_type_review-wrap">
                    <th><label for="post_type_review">Post Type</label></th>
                    <td><input type="text" name="post_type_review" value="<?php echo esc_attr($post_type_review); ?>" disabled="disabled" class="regular-text"></td>
                </tr>

                <tr class="current_post_name-wrap">
                    <th><label for="current_post_name">Post/Page Name(On Which user given reviews)</label></th>
                    <td><input type="text" name="current_post_name" value="<?php echo esc_attr($current_post_name); ?>" disabled="disabled" class="regular-text"></td>
                </tr>

        </tbody></table>

        <h2>Question's Reviews Details</h2>
        <table class="form-table questions-table">
            <tbody>
        <?php if(!empty($morphii_final_review_array)){
            foreach ($morphii_final_review_array as $key => $review) {
                $intensity =  $review->reaction_record->morphii->intensity;
				$part_name=$review->reaction_record->morphii->part_name;
				
                $percent = round((float)$intensity * 100 ) . '%';
                ?>
            <tr class="question_name">
                <th><u>Question :</u> <?php echo esc_attr($review->reaction_record->target->metadata[2]->value); ?></th>
            </tr>
            <tr class="question_answer">
                <th><u>Answer:</u></th>
            </tr>   
            <tr class="question_morphiiname">
                <td><strong>Morphii: </strong><i><?php if(strtolower($part_name)!=strtolower($review->reaction_record->morphii->name)) echo ucfirst(esc_attr($part_name));
				else echo esc_attr($review->reaction_record->morphii->name); ?></i></td>
            </tr>
            <tr class="question_morphiiname">
                <td><strong>Morphii Intensity:</strong> <i><?php echo esc_attr($percent); ?></i></td>
            </tr>
            <tr class="question_morphii_url">
                <td><img src="<?php echo esc_attr($review->reaction_record->morphii->urls->png); ?>" class="morphii_answer_url"/></td>
            </tr> 
        <?php } } ?>

</div>