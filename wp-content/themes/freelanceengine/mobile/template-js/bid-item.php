<script type="text/template" id="ae-bid-loop">
    <div class="info-bidding fade-out fade-in bid-item {{= add_class_bid}} bid-{{= ID}} bid-item-{{= project_status}} "/> 
        <div class="info-author-bidders col-xs-7">
            <div class="avatar-proflie">
                <a href="{{=author_url}}">
                    <span class="avatar-profile">{{= et_avatar }}</span>
                </a>
            </div>
            <div class="user-proflie">
                <span class="name">{{=profile_display}}</span>
                <span class="position">{{=et_professional_title}}</span>
            </div>
            
            <div class="bid-price">
                <# if( ae_globals.user_ID == project_author || ae_globals.user_ID == post_author ) { #>
                    <span class="number">{{= bid_budget_text }}</span>{{= bid_time_text }}
                <# }else{ #>
                    <span class="number"><?php _e("In Process", ET_DOMAIN); ?></span>
                <# } #>
            </div>
        </div>
        <div class="col-xs-5 action-author">
            <# if( flag == 2){ #>
                <span class="ribbon"><i class="fa fa-trophy"></i></span>
            <# } #>
            
            <div class="wrapper-achivement rating">
                <div class="out-rating">
                    <div class="rate-it" data-score="{{=rating_score }}"></div>
                    <span>
                        <# if(experience){ #>
                            <# if(experience > 1 ){ #>
                                {{=experience}} <?php printf(__('Years', ET_DOMAIN));?>
                            <# }else{ #>
                                {{=experience}} <?php printf(__('Years', ET_DOMAIN));?>
                            <# } #>
                        <# }else{ #>
                            <?php printf(__('0 Years', ET_DOMAIN));?>
                        <# } #>
                    </span>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="bid-price-wrapper">
                <p class="btn-warpper-bid col-md-3 number-price-project block-bid">
                    <# if( flag == 1 ) { #>
                        <# if(ae_globals.use_escrow) { #>
                            <button class="btn-sumary btn-bid btn-accept-bid btn-bid-status" id="{{= ID}}" title="" data-original-title="<?php _e('Accept Bid', ET_DOMAIN); ?>" href="#">
                                <?php _e('Accept', ET_DOMAIN); ?>
                            </button>
                        <# }else{ #>
                            <button class="btn-sumary btn-bid btn-accept-bid btn-bid-status" id="{{= ID}}">
                                <?php _e('Accept',ET_DOMAIN) ;?>
                            </button>
                        <# } #>
                        {{= button_message}}
                    <# } #>
                    <span class="confirm"></span>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</script>