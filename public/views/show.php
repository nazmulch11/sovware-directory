<?php
$the_query = new WP_Query( array('posts_per_page'=> 5,
        'post_type'=>'sovware_listing',
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1)
);
?>
<table>
    <thead>
        <th>Title</th>
        <th>Content</th>
        <th>author</th>
    </thead>

    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
    <tbody>
        <td><?php echo get_the_title(); ?></td>
        <td><?php the_content(); ?></td>
        <td><?php the_author(); ?></td>
    </tbody>
    <?php
    endwhile;
    $big = 999999999; // need an unlikely integer
    ?>
</table>

<?php
echo paginate_links( array(
    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $the_query->max_num_pages
) );

wp_reset_postdata();
?>


