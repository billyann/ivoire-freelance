<?php
/**
 * Template list all project
*/
global $wp_query, $ae_post_factory, $post;
$post_object = $ae_post_factory->get(PROJECT);
?>
<ul class="list-project project-list-container">
<?php
    $postdata = array();
    while (have_posts()) { the_post();
        $convert = $post_object->convert($post);
        $postdata[] = $convert;
        get_template_part( 'mobile/template/project', 'item' );
    }
?>
</ul>
<div class="col-md-12 col-sm-12 col-xs-12 profile-no-result" style="display: none;">
    <div class="profile-content-non">
        <p><?php _e('There are no results that match your search!', ET_DOMAIN);?></p>
        <ul>
            <li><?php _e('Try more general terms', ET_DOMAIN)?></li>
            <li><?php _e('Try another search method', ET_DOMAIN)?></li>
            <li><?php _e('Try to search by keyword', ET_DOMAIN)?></li>
        </ul>
    </div>
</div>
<?php
    $wp_query->query = array_merge(  $wp_query->query ,array('is_archive_project' => is_post_type_archive(PROJECT) ) ) ;
    echo '<div class="paginations-wrapper">';
    ae_pagination($wp_query, get_query_var('paged'), 'loadmore');
    echo '</div>';
/**
 * render post data for js
*/
echo '<script type="data/json" class="postdata" >'.json_encode($postdata).'</script>';
?>