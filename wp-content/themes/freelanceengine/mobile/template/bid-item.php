<?php
    global $wp_query, $ae_post_factory, $post,$project,$user_ID;
    $post_object    = $ae_post_factory->get( BID );
    $convert        = $post_object->convert($post);
    $bid_accept     = get_post_meta($project->ID, 'accepted', true);
    $project_status = $project->post_status;
    $role           = ae_user_role();
    $time = $convert->bid_time;
    $type = $convert->type_time;

    $flag = 0;
    if( $user_ID == $project->post_author && $project_status == 'publish' ){
        $flag = 1;
    }else if($bid_accept && $project->accepted == $convert->ID && in_array($project_status, array('complete','close','disputing') ) ){
        $flag = 2;
    }
    $bid_of_user = '';
    if($convert->post_author == $user_ID){
        $bid_of_user = 'bid-of-user';
    }
?>
<li class="info-bidding">
    <div class="bid-item <?php echo $convert->add_class_bid;?> bid-item-<?php echo $project_status;?>">
        <div class="info-author-bidders col-xs-7">
            <div class="avatar-proflie">
                <a href="<?php echo get_author_posts_url( $convert->post_author ); ?>"><span class="avatar-profile"> <?php echo $convert->et_avatar; ?></span></a>
            </div>
            <div class="user-proflie">
                <span class="name"><?php echo $convert->profile_display ;?></span>
                <span class="position"><?php echo $convert->et_professional_title ?></span>
            </div>
            <div class="bid-price">
                <?php if( ( $user_ID && $user_ID == $project->post_author )
                            || ( $user_ID && $user_ID == $convert->post_author )
                        ){ ?>
                    <span class="number">
                        <?php echo $convert->bid_budget_text; ?>
                    </span><?php echo $convert->bid_time_text; ?>
                <?php } else { ?>
                    <span class="number"><?php _e("In Process", ET_DOMAIN); ?></span>
                <?php } ?>
            </div>
        </div>
        <div class="col-xs-5 action-author">
            <?php if( $convert->flag == 2 ) { ?>
                <span class="ribbon"><i class="fa fa-trophy"></i></span>
            <?php } ?>
            
            <div class="wrapper-achivement rating">
                <div class="out-rating">
                    <div class="rate-it" data-score="<?php echo $convert->rating_score ; ?>"></div>
                    <span>
                        <?php 
                            if(!empty($convert->experience)) {
                                if((float)$convert->experience > 1){
                                    printf(__('%s Years', ET_DOMAIN), $convert->experience);
                                }else{
                                    printf(__('%s Year', ET_DOMAIN), $convert->experience);
                                }
                            }else{
                                printf(__('0 Years', ET_DOMAIN));
                            }
                        ?>
                    </span>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="bid-price-wrapper">
                <p class="btn-warpper-bid col-md-3 number-price-project block-bid">
                <?php
                    /**
                     *project accept button
                     *only project owner can see & use this button
                     */
                    if( $convert->flag == 1){ ?>
                        <?php if(ae_get_option('use_escrow')) { ?>
                            <button href="#" id="<?php the_ID();?>" rel="<?php echo $project->ID;?>" class="btn-sumary btn-bid btn-accept-bid btn-bid-status">
                                <?php _e('Accept',ET_DOMAIN) ; ?>
                            </button>
                        <?php }else{ ?>
                            <button href="#" id="<?php the_ID();?>" rel="<?php echo $project->ID;?>" class="btn-sumary btn-bid btn-accept-bid-no-escrow btn-bid-status">
                                <?php _e('Accept',ET_DOMAIN) ; ?>
                            </button>
                        <?php } ?>
                        
                        <?php do_action('ae_bid_item_template', $convert, $project ); ?>
                        <span class="confirm"></span>
                <?php
                    }
                ?>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</li>