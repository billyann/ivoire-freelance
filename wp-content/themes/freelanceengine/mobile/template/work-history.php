<?php
/**
 * Template part for employer posted project block
 # this template is loaded in page-profile.php , author.php
 * @since 1.0
 * @package FreelanceEngine
 */
?>
<div class="work-history project-history">

<?php
if(is_page_template('page-profile.php')) {
    $status = array(
        'close'     => __("PROCESSING", ET_DOMAIN),
        'complete'  => __("COMPLETED", ET_DOMAIN),
        'disputing' => __("DISPUTED" , ET_DOMAIN ),
        'disputed'  => __("RESOLVED" , ET_DOMAIN ),
        'publish'   => __("ACTIVE", ET_DOMAIN),
        'pending'   => __("PENDING", ET_DOMAIN),
        'draft'     => __("DRAFT", ET_DOMAIN),
        'reject'    => __("REJECTED", ET_DOMAIN),
        'archive'   => __("ARCHIVED", ET_DOMAIN),
    );
} else {
    $status = array(
        'publish'  => __("ACTIVE", ET_DOMAIN),
        'complete' => __("COMPLETED", ET_DOMAIN)
    );
}
global $user_ID;
$author_id = get_query_var('author');
$is_page_profile = is_page_template('page-profile.php');
$stat = array('publish','complete');
$query_args = array('is_author' => true,
                    'post_status' => $stat,
                    'post_type' => PROJECT,
                    'author' => $author_id,
                    'order' => 'DESC',
                    'orderby' => 'date');

if(is_page_template('page-profile.php')) {
    $author_id = $user_ID;
    $stat = array('pending','publish','close', 'complete', 'disputing', 'disputed', 'reject', 'archive', 'draft');
    $query_args = array('is_profile' => $is_page_profile,
                    'post_status' => $stat,
                    'post_type' => PROJECT,
                    'author' => $author_id,
                    'order' => 'DESC',
                    'orderby' => 'date');
}
// filter order post by status
add_filter('posts_orderby', 'fre_order_by_project_status');
query_posts( $query_args);
// remove filter order post by status

$bid_posts   = $wp_query->found_posts;
?>
    <div class="work-history-heading">
        <label class="work-history-title" >
            <?php
            if(fre_share_role()) {
                printf(__('Posted Projects (%s)', ET_DOMAIN), $wp_query->found_posts );
            }else {
                printf(__('Your Projects (%s)', ET_DOMAIN), $wp_query->found_posts );
            }
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
                    <?php foreach ($status as $key => $stat) {
                        echo '<option value="'.$key.'">'.$stat.'</option>' ;
                    }  ?>
                </select>
            </label>
        </div>
    </div>
    <?php endif;?>
<?php
    // list portfolio
    if(have_posts()):
        get_template_part( 'mobile/template/work', 'history-list' );
    else :
        $link_submitProject = et_get_page_link('submit-project');
        echo '<ul style="list-style:none;padding:0;" class="no-project-bid"><li><div class="no-results">'.__('<p>You have not created any projects yet.</p><p>It is time to start creating ones.</p>', ET_DOMAIN).'<div class="add-project"><a href="'.$link_submitProject.'" class="btn-submit-project s">'.__('Post a project', ET_DOMAIN).'</a></div></div></li></ul>';
    endif;
//wp_reset_postdata();
wp_reset_query();
remove_filter('posts_orderby', 'fre_order_by_project_status');
?>
</div>