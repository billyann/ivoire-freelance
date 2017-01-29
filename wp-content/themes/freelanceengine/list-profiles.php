<?php
/**
 * Template list profiles
*/
global $wp_query, $ae_post_factory, $post;
$post_object = $ae_post_factory->get( PROFILE );
?>
<div class="list-profile profile-list-container">
	 <!-- block control  -->
    <?php
        if(have_posts()) {
            $postdata = array();
            while(have_posts()) { the_post();
                $convert    = $post_object->convert($post);
                $postdata[] = $convert;
                get_template_part('template/profile', 'item' );
            }
            /**
            * render post data for js
            */
            echo '<script type="data/json" class="postdata" >'.json_encode($postdata).'</script>';
        }
    ?>
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
        wp_reset_query();
    ?>
</div>
<!--// blog list  -->
<!-- pagination -->

<?php
    echo '<div class="paginations-wrapper col-md-12">';
    ae_pagination($wp_query, get_query_var('paged'));
    echo '</div>';
?>
