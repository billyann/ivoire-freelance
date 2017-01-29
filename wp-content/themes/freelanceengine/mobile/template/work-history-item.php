<?php
/**
 * Template part for employer project details
 # this template is loaded in template/list-work-history.php
 * @since 1.1
 * @package FreelanceEngine
 */
	$author_id = get_query_var('author');
	if(is_page_template('page-profile.php')) {
	    global $user_ID;
	    $author_id = $user_ID;
	}

	global $wp_query, $ae_post_factory, $post;

	$post_object = $ae_post_factory->get( PROJECT );
	$current     = $post_object->current_post;

	if(!$current){
	    return;
	}

    $status = array(
        'reject'    => __("REJECTED", ET_DOMAIN) ,
        'pending'   => __("PENDING", ET_DOMAIN) ,
        'publish'   => __("ACTIVE", ET_DOMAIN),
        'close'     => __("PROCESSING", ET_DOMAIN),
        'complete'  => __("COMPLETED", ET_DOMAIN),
        'draft'     => __("DRAFT", ET_DOMAIN),
        'archive'   => __("ARCHIVED", ET_DOMAIN),
        'disputing' => __("DISPUTED" , ET_DOMAIN ),
        'disputed'  => __("RESOLVED" , ET_DOMAIN )
    );
?>

<li class="bid-item">
    <div class="info-project-top">
        <div class="avatar-author-project">
            <a href="<?php echo $current->author_url;?>">
                <?php echo $current->et_avatar;?>
            </a>
        </div>
        <h1 class="title-project">
            <a href="<?php echo $current->permalink; ?>" title="<?php echo $current->post_title; ?>" >
                <?php echo $current->post_title; ?>
            </a>
        </h1>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="info-bottom">
               <p class="budget-bid"><?php _e("Budget", ET_DOMAIN); ?>: <span><?php echo $current->budget; ?></span></p>
                <p class="date-bid"><?php echo $current->post_date; ?></p>
            </div>
            <div class="review-link">
                <?php if($current->post_status == 'complete'){ ?>
                    <a title="<?php _e('Rating & Review', ET_DOMAIN);?>" class="review" data-target="#" href="#">
                        <i class="fa fa-eye" aria-hidden="true"></i> <?php _e('Rating & Review', ET_DOMAIN);?>
                    </a>
                <?php }?>
            </div>
        </div>
        <div class="col-xs-6 project-detail-status-history">
            <p class="status-project"><?php echo $status[$current->post_status];?></p>
            <?php if( !in_array($current->post_status, array('pending','draft', 'reject')) ){?>
                <div class="total-action">
                    <p class="total-bid">
                        <?php
                            if($current->total_bids > 1){
                                printf(__('%s <span class="normal-text">Bids</span>'), $current->total_bids);
                            }else{
                                if($current->total_bids == 0 ){
                                    printf(__('%s <span class="normal-text">Bids</span>'), $current->total_bids);    
                                }else{
                                    printf(__('%s <span class="normal-text">Bid</span>'), $current->total_bids);
                                }
                            }
                        ?>
                    </p>
                    <p class="total-view">
                        <?php
                            if($post->post_views > 1 ){
                                printf(__("%d <span class='normal-text'>Views</span>", ET_DOMAIN), $post->post_views);
                            }else{
                                if($post->post_views == 0 ){
                                    printf(__("%d <span class='normal-text'>Views</span>", ET_DOMAIN), $post->post_views);
                                }else{
                                    printf(__("%d <span class='normal-text'>View</span>", ET_DOMAIN), $post->post_views);
                                }                                
                            }
                        ?>    
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="review-rate" style="display:none;">
        <div class="rate-it" data-score="<?php echo $current->rating_score ; ?>"></div>
        <span class="comment-author-history "><?php echo $current->project_comment; ?></span><br>
        <?php if($current->post_status == 'complete' && !empty($current->project_comment) && $current->rating_score != 0){?>
            <a title="<?php _e('Hide', ET_DOMAIN);?>" class="review" data-target="#" href="#">
                <?php _e('Hide', ET_DOMAIN);?><i class="fa fa-sort-asc" aria-hidden="true"></i>
            </a>
        <?php }?>
    </div>
</li>