<?php
$morphii_questions = new Morphii_Questions_Table();
$morphii_questions->prepare_items();
?>

<div class="wrap">

    <h2><?php _e( 'Questions', 'morphii' ) ?></h2>

    <form id="morphii-questions" method="get">
        <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']) ?>" />
        <?php $morphii_questions->search_box( esc_html__( 'Search Questions', 'morphii' ), 'morphii' ); ?>
        <?php $morphii_questions->display(); ?>
    </form>
</div>
