<?php
    global $wp_query, $ae_post_factory, $post, $user_ID;

    $post_object      = $ae_post_factory->get(PROFILE);
    $author_id        = get_query_var( 'author' );
    $author_name      = get_the_author_meta('display_name', $author_id);
    $author_available = get_user_meta($author_id, 'user_available', true);
    // get user profile id
    $profile_id       = get_user_meta($author_id, 'user_profile_id', true);
    // get post profile
    $profile          = get_post($profile_id);
    $convert          = '';

    if( $profile && !is_wp_error($profile) ){
        $convert = $post_object->convert( $profile );
    }

    $user       = get_userdata( $author_id );
    $ae_users   = AE_Users::get_instance();
    $user_data  = $ae_users->convert($user);
    $user_role  = ae_user_role( $author_id );

    // try to check and add profile up current user dont have profile
    if(!$convert && $user_role == FREELANCER ) {

        $profile_post = get_posts(array('post_type' => PROFILE,'author' => $author_id));
        if(!empty($profile_post)) {

            $profile_post = $profile_post[0];
            $convert      = $post_object->convert( $profile_post );
            $profile_id   = $convert->ID;
            update_user_meta($author_id, 'user_profile_id', $profile_id);

        } else {

            $convert = $post_object->insert( array(
                'post_status'  => 'publish' ,
                'post_author'  => $author_id ,
                'post_title'   => $author_name ,
                'post_content' => ''
                )
            );

            $convert    = $post_object->convert( get_post($convert->ID) );
            $profile_id = $convert->ID;
        }

    }

    //  count author review number
    $count_review  = fre_count_reviews($author_id);
    $count_project = fre_count_user_posts_by_type($user_ID, PROJECT, 'publish');
	et_get_mobile_header();
?>
<section class="section section-single-profile">
	<div class="single-profiles-top">
        <div class="avatar-proflie">
            <?php echo get_avatar( $author_id, 48 ); ?>
        </div><!-- / avatar-proflie -->
        <div class="user-proflie">
            <div class="profile-infor">
                <span class="name">
                    <?php echo $author_name ?>
                </span>
                
                <?php if($user_role == FREELANCER) { ?>
                    <span class="position">
                        <?php echo $profile->et_professional_title; ?>
                    </span>
                <?php }else{ ?>
                    <span class="number-review-profile">
                        <?php echo $count_review; ?>
                        Review
                    </span>
                <?php } ?>
                </span>
            </div>
        </div><!-- / user-proflie -->
        <div class="clearfix"></div>
        <?php if(fre_share_role() || $user_role == FREELANCER) { ?>
            <ul class="list-skill">
                <?php
                    if(isset($convert->tax_input['skill']) && $convert->tax_input['skill']){
                        foreach ($convert->tax_input['skill'] as $tax){
                ?>
            	<li>
                    <a href="#">
                        <span class="skill-name"><?php echo $tax->name; ?></span>
                    </a>
                </li>
                <?php
                        }
                    }
                ?>
            </ul>
        <?php } ?>
    </div>
    <?php if( fre_share_role() || $user_role == FREELANCER) {
        add_filter('posts_orderby', 'fre_reset_order_by_project_status');
        add_filter('posts_where', 'fre_filter_where_bid');
        query_posts( array(  'post_status' => array('complete'), 'post_type' => BID, 'author' => $author_id, 'accepted' => 1  ));
        $bid_posts = $wp_query->found_posts;
        wp_reset_query();
        remove_filter('posts_where', 'fre_filter_where_bid');
        remove_filter('posts_orderby', 'fre_reset_order_by_project_status');
     ?>
    <!-- freelancer info -->
    <div class="info-bid-wrapper">
        <div class="info-bid-freelancer">
            <span class="more-info-freelancer"><?php _e('More Info', ET_DOMAIN);?> <i class="fa fa-angle-double-down" aria-hidden="true"></i></span>
            <span class="less-info-freelancer"><?php _e('Less Info', ET_DOMAIN);?> <i class="fa fa-angle-double-up" aria-hidden="true"></i></span>
            <ul class="bid-top">
                <li>
                    <span class="number">
                        <?php echo fre_price_format($convert->hour_rate); ?>
                    </span>
                    <?php _e('Hourly Rate', ET_DOMAIN) ?>
                </li>
                <li>
                    <span class="number">
                        <div class="rate-it" data-score="<?php echo $convert->rating_score ; ?>"></div>
                    </span>
                    <?php _e('Rating', ET_DOMAIN) ?>
                </li>
                <li>
                    <span class="number">
                        <?php echo $convert->experience; ?>
                    </span>
                    <?php _e('Experience', ET_DOMAIN) ?>
                </li>
            </ul>
            <ul class="bid-top">
                <li>
                    <span class="number"><?php echo $bid_posts; ?></span>
                    <?php _e('Job Worked', ET_DOMAIN) ?>
                </li>
                <li>
                    <span class="number"><?php echo fre_price_format(fre_count_total_user_earned($author_id)); ?></span>
                    <?php _e('Total earned', ET_DOMAIN) ?>
                </li>
                <li>
                    <span class="number"><?php if($convert->tax_input['country']){ echo $convert->tax_input['country']['0']->name;} ?></span>
                    <?php _e('Location', ET_DOMAIN) ?>
                </li>
            </ul>
        </div>
        

        <div class="clearfix"></div>
    </div>
    <?php 
        if( fre_share_role() || ( ae_user_role($author_id) == FREELANCER && (ae_user_role($user_ID) == EMPLOYER || current_user_can('manage_options'))) ) {
            if($author_available == 'on' || $author_available == '' ){ ?>
            <div class="btn-warpper-bid">
                <a href="#" data-toggle="modal" class="btn-bid invite-freelancer <?php if ( is_user_logged_in() ) { echo 'invite-open';}else{ echo 'login-btn';} ?>"  data-user="<?php echo $convert->post_author ?>">
                    <?php _e("Invite me to join", ET_DOMAIN) ?>
                </a>
                <?php /*
                <span><?php _e("Or", ET_DOMAIN); ?></span>
                <a href="#" class="<?php if ( is_user_logged_in() ) {echo 'contact-me';} else{ echo 'login-btn';} ?> fre-contact"  data-user="<?php echo $convert->post_author ?>" data-user="<?php echo $convert->post_author ?>">
                    <?php _e("Contact me", ET_DOMAIN) ?>
                </a>
                */
                ?>
            </div>
        <?php }
        } ?>
    <!--// freelancer info -->
    <?php } else { ?>
        <!-- employer info  !-->
        <div class="info-bid-wrapper">
            <div class="info-bid-employer">
                <span class="more-info-employer"><?php _e('More Info', ET_DOMAIN);?> <i class="fa fa-angle-double-down" aria-hidden="true"></i></span>
                <span class="less-info-employer"><?php _e('Less Info', ET_DOMAIN);?> <i class="fa fa-angle-double-up" aria-hidden="true"></i></span>
                <ul class="bid-top">
                    <li>
                        <span class="number"><?php echo 'July 20, 2020' ?></span>
                        <?php _e('Member Since', ET_DOMAIN) ?>
                    </li>
                    <li>
                        <span class="number"><?php echo $user_data->location; ?></span>
                        <?php _e('Address', ET_DOMAIN) ?>
                    </li>
                    <li>
                        <span class="number"><?php echo fre_count_user_posts_by_type($author_id,'project','"publish","complete","close","disputing","disputed" ', true); ?></span>
                        <?php _e("Project posted", ET_DOMAIN); ?>
                    </li>
                    <li>
                        <span class="number"><?php echo   fre_price_format(fre_count_total_user_spent($author_id));;?></span>
                        <?php _e('Total spent ', ET_DOMAIN) ?>
                    </li>
                    <li>
                        <span class="number">
                            <?php echo fre_count_user_posts_by_type($author_id,'project', 'complete');?>
                        </span>
                        <?php _e('Complete project(s)', ET_DOMAIN) ?>
                    </li>
                </ul>
            </div>
            
            <div class="clearfix"></div>
        </div>
        <div class="space-empty-section"></div>

        <!-- end employer info !-->
    <?php } ?>
    <!-- Author overview -->
    <?php if($convert) { ?>
    <div class="content-project-wrapper">
   		<h2 class="title-content">
            <?php _e('Overview:', ET_DOMAIN) ?>
        </h2>
        <?php
            echo $convert->post_content;
            if(function_exists('et_render_custom_field')) {
                et_render_custom_field($convert);
            }
        ?>
    </div>
    <?php } ?>

    <div class="history-cmt-wrapper">
        <?php
        if(fre_share_role() || $user_role == FREELANCER) {
            get_template_part('mobile/template/author', 'freelancer-history');
        }
        if(fre_share_role() || $user_role != FREELANCER ) {
            get_template_part('mobile/template/author', 'employer-history');
        }
         ?>
    </div>
</section>
<?php
	et_get_mobile_footer();
?>