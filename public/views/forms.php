<div id="sovware-directory-form " >

    <form class="form" action="" method="post" id="listing-form" enctype="multipart/form-data">
        <div id="show_msg"></div>
        <div class="sovware-directory-form-row">
            <label for="name"><?php _e( 'Title', 'sovware-directory' ); ?></label>

            <input type="text" name="title" value="" required>
        </div>

        <div class="sovware-directory-form-row">
            <label for="message"><?php _e( 'Content', 'sovware-directory' ); ?></label>

            <textarea name="content" id="content" required></textarea>
        </div>
        <div class="sovware-directory-form-row">
            <label for="message"><?php _e( 'Feature', 'sovware-directory' ); ?></label>

            <input type="file" class="thumbnail" name="featured" accept="image/*" required>
            <input type="hidden" name="featured_image" value="">
        </div>

        <div class="sovware-directory-form-row">

            <?php wp_nonce_field( 'wp_rest' ); ?>
            <input type="submit" name="send" value="<?php esc_attr_e( 'Send', 'sovware-directory' ); ?>">
        </div>

    </form>
</div>
