<?php
/**
 * Template part for user bid history block
 # This template is loaded in page-profile.php , author.php
 * @since v1.0
 * @package EngineTheme
 */
global $user_ID, $wp_query;
$author_id = get_query_var('author');
$is_author = is_author();
$status = array(
    'publish'  => __("ACTIVE", ET_DOMAIN),
    'complete' => __("COMPLETED", ET_DOMAIN)
);
add_filter('posts_where', 'fre_filter_where_bid');
query_posts( array(  'post_status' => array( 'complete'), 'post_type' => BID, 'author' => $author_id, 'accepted' => 1 , 'is_author' => $is_author,'filter_work_history' => ''));

?>
<div class="">
    <div class="btn-tabs-wrapper">
        <ul role="tablist">
            <li class="active">
                <a href="#history-tabs" role="tab" data-toggle="tab">
                    <?php printf(__('History (%s)', ET_DOMAIN), $wp_query->found_posts ) ?>
                </a>
            </li>
            <li>
                <a href="#porfolio-tabs" role="tab" data-toggle="tab">
                    <?php
                        $number_porfolio = fre_count_user_posts($author_id, PORTFOLIO);
                        if($number_porfolio > 1) {
                            if($number_porfolio == 1) {
                                printf(__('Portfolio (%s)', ET_DOMAIN), $number_porfolio );
                            }else{
                                printf(__('Portfolios (%s)', ET_DOMAIN), $number_porfolio );
                            }
                        }else{
                            printf(__('Portfolios (%s)', ET_DOMAIN), $number_porfolio );
                        }
                    ?>
                </a>
            </li>
        </ul>
    </div>
    <!-- / .btn-tabs-wrapper -->
    <div class="tab-content">
        <div class="tab-pane fade in active " id="history-tabs">
            <div class="freelancer-project-history">
                <?php
                    get_template_part('mobile/template/author', 'freelancer-history-list');
                    wp_reset_query();
                ?>
                <?php remove_filter('posts_where', 'fre_filter_where_bid');?>
                <div class="clearfix"></div>
            </div>
        </div><!-- / .tab-history -->
        <div class="tab-pane fade portfolio-container" id="porfolio-tabs">
            <?php
                query_posts( array(
                    'post_status' => 'publish',
                    'post_type'   => PORTFOLIO,
                    'author'      => $author_id
                ));
                get_template_part( 'mobile/list', 'portfolios' );
            ?>
        </div><!-- / .tab-porfolio -->
    </div><!-- / .tab-content -->
</div>
<?php 

?>
