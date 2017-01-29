<?php
/**
 * Template part for freelancer work (bid success a project) 
 # this template is loaded in template/bid-history-list.php
 * @since 1.0	
 * @package FreelanceEngine
 */
$author_id = get_query_var('author');
if(is_page_template('page-profile.php')) {
    global $user_ID;
    $author_id = $user_ID;
}

global $wp_query, $ae_post_factory, $post;

$post_object = $ae_post_factory->get( BID );
$current     = $post_object->current_post;

if(!$current || !isset( $current->project_title )){
    return;
}
?>

<li class="bid-item">
    <div class="info-project-top">
        <div class="avatar-author-project">
            <?php echo $current->project_author_avatar;?>
        </div>
        <h1 class="title-project">
            <a href="<?php echo $current->project_link; ?>" title="<?php echo $current->project_title; ?>" >
                <?php echo $current->project_title; ?>
            </a>
        </h1>
        <div class="clearfix"></div>
    </div>
    <div class="info-bottom">
        <?php
            switch ($current->project_status) {
                case 'complete':
                    # code...
        ?>
                    <span class="star-project">
                        <div class="rate-it" data-score="<?php echo $current->rating_score; ?>"></div>
                    </span>
                    <?php if(isset($current->project_comment)){ ?>
                        <span class="comment-stt-project">
                            <p><?php echo $current->project_comment; ?></p>
                        </span>
                    <?php } ?>
        <?php       break;

                case 'disputing':
                    # code...
        ?>
                    <p class="status"><?php _e('In disputing process', ET_DOMAIN);?></p>
                    <?php if(!$wp_query->query['is_author']){ ?>
                        <a href="<?php echo $current->project_link; ?>" class="btn-dispute"><?php _e('Dispute Page', ET_DOMAIN);?></a>
                    <?php } ?>
        <?php       break;
                case 'disputed':
                    # code...
        ?>
                    <p class="status"><?php _e('Resolved by Admin', ET_DOMAIN);?></p>
        <?php       break;
            }
        ?>
        <div class="clearfix"></div>
    </div>
</li>