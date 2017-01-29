<?php $currency =  ae_get_option('currency',array('align' => 'left', 'code' => 'USD', 'icon' => '$')); ?>
<script type="text/template" id="ae-user-bid-loop">

    <div class="info-single-project-wrapper">
        <div class="container">
            <div class="info-project-top">
                <div class="avatar-author-project">
                    <a href="{{=author_url }}">{{= project_author_avatar }}</a>
                </div>
                <h1 class="title-project">
                    <a href="{{=project_link }}">{{=project_title }}</a>
                </h1>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="info-bid-wrapper">
        <ul class="bid-top col-xs-6">
            <li>
                <p>
                    <span><?php _e("Bidding:", ET_DOMAIN) ?></span> 
                    <span class="number">{{= bid_budget_text}}</span>
                </p>
            </li>
            <li>
                <# if(total_bids > 1 || total_bids == 0 ) { #>
                    <span><?php _e('Bids: ', ET_DOMAIN); ?></span><span class="number">{{= total_bids}}</span>
                <# } else { #>
                    <span><?php _e('Bid: ', ET_DOMAIN); ?></span><span class="number">{{= total_bids}}</span>
                <# }#>
            </li>
            <li>
                <?php printf( __('Avg Bid:', ET_DOMAIN) ) ?>
                <span class="number">
                    {{=bid_average}}
                </span>
                 
            </li>
        </ul>
        <ul class="col-xs-6 action-bid-projects">
            <li class="stt-bid">
                <# if(post_status == 'unaccept') { #>
                    <div class="time">
                        <span class="number"><?php _e('Processing', ET_DOMAIN); ?></span>
                    </div>
                    <p class="status-bid-project"><?php _e('Your bid is not accepted.', ET_DOMAIN); ?></p>
                <# }else if(post_status == 'accept'){#>
                    <div class="time">
                        <span class="number"><?php _e('Processing', ET_DOMAIN); ?></span>
                    </div>
                    <p class="status-bid-project"><?php _e('Your bid is accepted.', ET_DOMAIN); ?></p>
                    <p class="btn-warpper-bid button-status">
                        <a href="{{= project_workspace_link }}" class="btn-sumary btn-bid">
                            <?php _e("Workspace", ET_DOMAIN) ?>
                        </a>
                    </p>
                <# }else if(post_status == 'publish'){#>
                    <div class="time">
                        <span class="number"><?php _e('Active', ET_DOMAIN); ?></span>
                    </div>
                    <p class="status-bid-project">{{= et_expired_date}}</p>
                    <p class="btn-warpper-bid button-status">
                        <a href="{{= project_link }}" class="btn-sumary btn-bid">
                            <?php _e("Cancel", ET_DOMAIN) ?>
                        </a>
                    </p>
                <# } #>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</script>