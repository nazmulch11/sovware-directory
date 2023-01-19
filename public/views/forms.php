<div id="sovware-directory-form " >

    <form class="form" action="" method="post" id="listing-form" enctype="multipart/form-data">

        <div class="sovware-directory-form-row">
            <label for="name"><?php _e( 'Name', 'sovware-directory' ); ?></label>

            <input type="text" id="name" name="title" value="">
        </div>

        <div class="sovware-directory-form-row">
            <label for="message"><?php _e( 'Content', 'sovware-directory' ); ?></label>

            <textarea name="content" id="content"></textarea>
        </div>
        <div class="sovware-directory-form-row">
            <label for="message"><?php _e( 'Feature', 'sovware-directory' ); ?></label>

            <input type="file" class="post-thumb" name="featured" >
        </div>

        <div class="sovware-directory-form-row">

<!--            --><?php //wp_nonce_field( 'wp_nonce_action' ); ?>
            <input type="submit" name="send" value="<?php esc_attr_e( 'Send', 'sovware-directory' ); ?>">
        </div>

    </form>
</div>
