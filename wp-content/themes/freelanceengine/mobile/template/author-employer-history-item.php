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
?>

<li class="bid-item">
    <p><?php printf(__('Worked on %s', ET_DOMAIN), $current->post_date);?></p>
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
        <div class="col-xs-12">
            <?php if($current->post_status == 'publish'){ ?>
                <p><?php _e('Project is currently available for bidders', ET_DOMAIN);?></p>
                <div class="info-bottom">
                   <p class="budget-bid"><?php _e("Budget", ET_DOMAIN); ?>: <span><?php echo $current->budget; ?></span></p>
                    <p class="date-bid"><?php echo $current->post_date; ?></p>
                </div>
            <?php }else if($current->post_status == 'complete'){ ?>
                <p><?php _e('Project is already completed', ET_DOMAIN);?></p>
            <?php } ?>
        </div>
    </div>
    <?php if(isset($current->project_comment) && !empty($current->project_comment)){ ?>
        <div class="review-rate">
            <div class="rate-it" data-score="<?php echo $current->rating_score ; ?>"></div>
            <div class="comment-author-history">
                <p><?php echo $current->project_comment; ?></p>
            </div>
        </div>
    <?php } ?>
</li>