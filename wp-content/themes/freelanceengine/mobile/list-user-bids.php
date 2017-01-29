<?php
/**
 * Template list all freelancer current bid
 # This template is load page-profile.php
 * @since 1.0
*/
global $wp_query, $ae_post_factory;
$post_object = $ae_post_factory->get( BID );
?>
<div class="">
    <ul class="list-user-bid-container">
        <?php
            $postdata = array();
            if(have_posts()){
                while (have_posts()) { the_post();
                    $convert    = $post_object->convert($post);
                    $postdata[] = $convert;
                    get_template_part( 'mobile/template/user', 'bid-item' );
                }
            } else {
                ?>
                <li>
                    <div class="no-results no-padding-top">
                        <?php _e("<p>Oops! You haven't had any project bids yet. Let's find the appropriate project and bid on them right now.</p>", ET_DOMAIN);?>
                        <div class="add-project">
                            <a href="<?php echo get_post_type_archive_link( PROJECT ); ?>" class="btn-submit-project"><?php _e('Find a project', ET_DOMAIN);?></a>
                        </div>
                    </div>
                </li>';
                <?php 
            }
        ?>
    </ul>
</div>
 <!-- </ul> -->
<?php
    if(have_posts()){
        echo '<div class="paginations-wrapper">';
        ae_pagination($wp_query, get_query_var('paged'), 'load');
        echo '</div>';
        /**
         * render post data for js
        */
        echo '<script type="data/json" class="postdata" >'.json_encode($postdata).'</script>';
    }
?>