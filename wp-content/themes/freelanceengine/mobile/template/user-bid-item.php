<?php
$currency =  ae_get_option('currency',array('align' => 'left', 'code' => 'USD', 'icon' => '$'));
global $wp_query, $ae_post_factory, $post;
//get bid data
$bid_object     = $ae_post_factory->get( BID );
$bid            = $bid_object->current_post;
//get project data
$project        = get_post( $bid->post_parent );

if(!$project || is_wp_error($project) ) {
    return false;
}

$project_object = $ae_post_factory->get( PROJECT );
$project        = $project_object->convert($project);
//get all fields
$total_bids     = $project->total_bids ? $project->total_bids : 0;
$bid_average    = $project->bid_average ? $project->bid_average: 0;
$bid_budget     = $bid->bid_budget ? $bid->bid_budget : 0;
$bid_time       = $bid->bid_time ? $bid->bid_time : 0;
$type_time      = $bid->type_time ? $bid->type_time : 0;
$status_text    = $project->status_text;

?>

<li class="user-bid-item">
    <div class="info-single-project-wrapper">
        <div class="container">
            <div class="info-project-top">
                <div class="avatar-author-project">
                    <a href="<?php echo get_author_posts_url( $project->post_author ); ?>">
                        <?php echo get_avatar( $project->post_author, 35, true, $bid->project_title ); ?>
                    </a>
                </div>
                <h1 class="title-project">
                    <a href="<?php echo get_permalink($project->ID);?>">
                        <?php echo $bid->project_title; ?>
                    </a>
                </h1>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="info-bid-wrapper">
        <ul class="bid-top col-xs-6">
            <li>
                <p><span><?php _e("Bidding:", ET_DOMAIN) ?></span> <span class="number"><?php echo $bid->bid_budget_text ?></span></p>
            </li>
            <li>
            <?php
                if($total_bids > 1 || $total_bids == 0) {
                    printf(__('<span>Bids:</span><span class="number">%s</span>', ET_DOMAIN), $total_bids);
                }else{
                    _e('<span>Bid:</span> <span class="number">1</span>', ET_DOMAIN);
                }
            ?>
            </li>
            <li>
                <?php printf( __('Avg Bid:', ET_DOMAIN)); ?>
                <span class="number">
                    <?php echo fre_price_format($bid_average); ?>
                </span>
            </li>
        </ul>
        <ul class="col-xs-6 action-bid-projects">
            <li class="stt-bid">
                <?php if($bid->post_status == 'unaccept' && ae_user_role() == 'freelancer'){ ?>
                    <div class="time">
                        <span class="number"><?php _e('Processing', ET_DOMAIN); ?></span>
                    </div>
                    <p class="status-bid-project"><?php _e('Your bid is not accepted.', ET_DOMAIN); ?></p>
                <?php }else if($bid->post_status == 'accept' && ae_user_role() == 'freelancer'){?>
                    <div class="time">
                        <span class="number"><?php _e('Processing', ET_DOMAIN); ?></span>
                    </div>
                    <p class="status-bid-project"><?php _e('Your bid is accepted.', ET_DOMAIN); ?></p>
                    <p class="btn-warpper-bid button-status">
                        <a href="<?php echo add_query_arg(array('workspace' => 1), $project->permalink) ?>" class="btn-sumary btn-bid">
                            <?php _e("Workspace", ET_DOMAIN) ?>
                        </a>
                    </p>
                <?php }else if($bid->post_status == 'publish' && ae_user_role() == 'freelancer'){?>
                    <div class="time">
                        <span class="number"><?php _e('Active', ET_DOMAIN); ?></span>
                    </div>
                    <p class="status-bid-project"><?php echo $bid->et_expired_date; ?></p>
                    <p class="btn-warpper-bid button-status">
                        <a href="<?php echo $project->permalink ?>" class="btn-sumary btn-bid">
                            <?php _e("Cancel", ET_DOMAIN) ?>
                        </a>
                    </p>
                <?php }?>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</li>