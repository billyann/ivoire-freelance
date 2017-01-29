<?php
/**
 * Template part for employer posted project block
 # this template is loaded in page-profile.php , author.php
 * @since 1.0
 * @package FreelanceEngine
 */
?>
<div class="work-history employer-project-history">

<?php
global $user_ID;
$author_id = get_query_var('author');

$stat = array('publish','complete');
$query_args = array('is_author' => true,
                    'post_status' => $stat,
                    'post_type' => PROJECT,
                    'author' => $author_id,
                    'order' => 'DESC',
                    'orderby' => 'date');

// filter order post by status
add_filter('posts_orderby', 'fre_order_by_project_status');
query_posts( $query_args);
// remove filter order post by status

$bid_posts   = $wp_query->found_posts;
?>
    <div class="work-history-heading">
        <label class="work-history-title" >
            <?php
                printf(__('Project History & Review (%s)', ET_DOMAIN), $wp_query->found_posts );
            ?>
        </label>
        <div class="clearfix"></div>
    </div>
    <?php if(have_posts()): ?>
    <div class="filter">
        <div class="project-status-filter filter-project">
            <label for="">
                <select class="status-filter " name="post_status" data-chosen-width="100%" data-chosen-disable-search="1"
                        data-placeholder="<?php _e("Select a status", ET_DOMAIN); ?>">
                    <option value=""><?php _e("Filter by project's status", ET_DOMAIN); ?></option>
                    <option value="publish"><?php _e("ACTIVE", ET_DOMAIN); ?></option>
                    <option value="complete"><?php _e("COMPLETED", ET_DOMAIN); ?></option>
                </select>
            </label>
        </div>
    </div>
    <?php endif;?>
<?php
    // list portfolio
    if(have_posts()):
        get_template_part( 'mobile/template/author', 'employer-history-list' );
    else :
        $link_submitProject = et_get_page_link('submit-project');
        echo '<ul style="list-style:none;padding:0;" class="no-project-bid"><li><div class="no-results">'.__('<p>You have not created any projects yet.</p><p>It is time to start creating ones.</p>', ET_DOMAIN).'<div class="add-project"><a href="'.$link_submitProject.'" class="btn-submit-project s">'.__('Post a project', ET_DOMAIN).'</a></div></div></li></ul>';
    endif;
//wp_reset_postdata();
wp_reset_query();
remove_filter('posts_orderby', 'fre_order_by_project_status');
?>
</div>