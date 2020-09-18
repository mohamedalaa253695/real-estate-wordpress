<form method="post" action="" id="apus-save-search-form">
    <h3><?php echo trim(homesweet_get_config('save_search_title', 'Save Search')); ?></h3>
    <div class="description"><?php echo trim(homesweet_get_config('save_search_description','')); ?></div>
    <div class="msg"></div>
    <?php wp_nonce_field('ajax-save-search-nonce', 'save-search-security'); ?>
    <div class="form-group">
        <label for="ere_title"><?php echo esc_html__( 'Title', 'homesweet' ); ?></label>
        <input class="form-control" name="title" placeholder="<?php echo esc_html__( 'Title', 'homesweet' ); ?>" required="required" type="text">
    </div>
    <button class="button btn btn-theme-second btn-save" type="submit" name="save-form"><?php echo esc_html__( 'Save', 'homesweet' ); ?></button>
</form>