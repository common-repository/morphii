<?php
$product_reviews = new Morphii_List_Table();
$product_reviews->prepare_items();
?>

<div class="wrap">

    <h2><?php _e( 'Reviews', 'morphii' ) ?></h2>

    <form id="morphii-reviews" method="get">
        <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
        <?php $product_reviews->search_box( esc_html__( 'Search reviews', 'morphii' ), 'morphii' ); ?>
        <?php $product_reviews->display(); ?>
    </form>
</div>
