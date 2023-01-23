<?php

class Custom_Post_Type_List_Table extends WP_List_Table
{
// Define the columns to be displayed
    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title'),
            'author' => __('Author'),
            'date' => __('Date'),
        );
    }

// Retrieve and sort the data for the custom post type
    public function prepare_items()
    {
        global $wpdb;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->items = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'sovware_listing'");
    }
}
