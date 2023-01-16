<div id="sovware-directory-form " >

    <form class="form" action="" method="post" id="listing-form">

        <div class="sovware-directory-form-row">
            <label for="name"><?php _e( 'Name', 'sovware-directory' ); ?></label>

            <input type="text" id="name" name="name" value="">
        </div>

        <div class="sovware-directory-form-row">
            <label for="message"><?php _e( 'Message', 'sovware-directory' ); ?></label>

            <textarea name="message" id="message"></textarea>
        </div>

        <div class="sovware-directory-form-row">

<!--            --><?php //wp_nonce_field( 'wp_rest_action' ); ?>

            <input type="hidden" name="action" value="directory">
            <input type="submit" name="send" value="<?php esc_attr_e( 'Send', 'sovware-directory' ); ?>">
        </div>

    </form>
</div>
