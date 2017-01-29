<?php
$author_id = get_query_var('author');
//if(fre_share_role() || ae_user_role($author_id) == FREELANCER ) { ?>
<script type="text/template" id="ae-bid-history-loop">
    <div class="info-project-top">
        <div class="avatar-author-project">
            {{= project_author_avatar }}
        </div>
        <h1 class="title-project">
            <a href="{{= project_link }}" title="{{= project_title }}">{{= project_title }}</a>
        </h1>
        <div class="clearfix"></div>
    </div>
    <div class="info-bottom">
        <# if(project_status == 'complete'){ #>
            <span class="star-project">
                <div class="rate-it" data-score="{{= rating_score }}"></div>
            </span>
            <# if(typeof project_comment !== 'undefined' && project_comment){ #>
                <span class="comment-stt-project">
                    <p>{{= project_comment }}</p>
                </span>
            <# } #>
        <# } else if(project_status == 'disputing'){ #>
            <p class="status"><?php _e('In disputing process', ET_DOMAIN);?></p>
            <a href="{{= project_link}}" class="btn-dispute"><?php _e('Dispute Page', ET_DOMAIN);?></a>
        <# } else if(project_status == 'disputed'){ #>
            <p class="status"><?php _e('Resolved by Admin', ET_DOMAIN);?></p>
        <# } #>
        <div class="clearfix"></div>
    </div>
</script>

<?php //}

//if(fre_share_role() || ae_user_role($author_id) != FREELANCER ) { ?>
<script type="text/template" id="ae-work-history-loop">
    <div class="info-project-top">
        <div class="avatar-author-project">
            <a href="{{= author_url}}">{{= et_avatar }}</a>
        </div>
        <h1 class="title-project">
            <a href="{{= permalink }}" title="{{= post_title }}">{{= post_title }}</a>
        </h1>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="info-bottom">
                <p class="budget-bid"><?php _e("Budget", ET_DOMAIN); ?>: 
                    <span>{{= budget}}</span>
                </p>
                <p class="date-bid">{{= post_date}}</p>
            </div>
            <div class="review-link">
                <# if(post_status == 'complete' && project_comment != '' && rating_score != 0){ #>
                    <a title="<?php _e('Rating & Review', ET_DOMAIN);?>" class="review" data-target="#" href="#">
                        <i class="fa fa-eye" aria-hidden="true"></i> <?php _e('Rating & Review', ET_DOMAIN);?>
                    </a>
                <# } #>
            </div>
        </div>
        <div class="col-xs-6 project-detail-status-history">
            <p class="status-project">{{= status_text}}</p>
            <# if(post_status != 'pending' && post_status != 'draft' && post_status != 'reject'){ #>
                <div class="total-action">
                    <p class="total-bid">
                        <# if(total_bids > 1){ #>
                            {{= total_bids}} <span class="normal-text"><?php _e('Bids', ET_DOMAIN);?></span>
                        <# }else if(total_bids == 0){ #>
                            {{= total_bids}} <span class="normal-text"><?php _e('Bids', ET_DOMAIN);?></span>
                        <# }else{ #>
                            {{= total_bids}} <span class="normal-text"><?php _e('Bid', ET_DOMAIN);?></span>
                        <# } #>
                    </p>
                    <p class="total-view">
                        <# if(post_views > 1){ #>
                            {{= post_views}} <span class="normal-text"><?php _e( 'Views' , ET_DOMAIN ); ?></span>
                        <# }else if(post_views == 0){ #>
                            {{= post_views}} <span class="normal-text"><?php _e( 'Views' , ET_DOMAIN ); ?></span>
                        <# }else{ #>
                            {{= post_views}} <span class="normal-text"><?php _e( 'View' , ET_DOMAIN ); ?></span>
                        <# } #>
                    </p>
                </div>
            <# } #>
        </div>
    </div>
    <div class="review-rate" style="display:none;">
        <div class="rate-it" data-score="{{= rating_score}}"></div>
        <span class="comment-author-history ">{{= project_comment}}</span><br>
        <# if(post_status == 'complete'){ #>
            <a title="<?php _e('Hide', ET_DOMAIN);?>" class="review" data-target="#" href="#">
                <?php _e('Hide', ET_DOMAIN);?><i class="fa fa-sort-asc" aria-hidden="true"></i>
            </a>
        <# } #>
    </div>
</script>



<!-- Template use to page author, role is Freelancer-->
<script type="text/template" id="ae-freelancer-history-loop">
    <p><?php _e('Worked on', ET_DOMAIN);?> {{=project_post_date}}</p>
    <div class="info-project-top">
        <div class="avatar-author-project">
            <a href="{{= author_url}}">{{=project_author_avatar}}</a>
        </div>
        <h1 class="title-project">
            <a href="{{=project_link}}" title="{{=project_title}}" >{{=project_title}}</a>
        </h1>
        <div class="clearfix"></div>
    </div>
    <div class="info-bottom">
        <span class="star-project">
            <div class="rate-it" data-score="{{=rating_score}}"></div>
        </span>
        <span class="comment-stt-project">
            <p>{{=project_comment}}</p>
        </span>
        <div class="clearfix"></div>
    </div>
</script>


<!-- Template use to page author, role is Employer-->
<script type="text/template" id="ae-employer-history-loop">
    <p><?php _e('Worked on', ET_DOMAIN);?> {{= post_date}}</p>
    <div class="info-project-top">
        <div class="avatar-author-project">
            <a href="{{= author_url}}">{{=et_avatar}}</a>
        </div>
        <h1 class="title-project">
            <a href="{{=permalink}}" title="{{=post_title}}" >{{=post_title}}</a>
        </h1>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <# if(post_status == 'publish'){ #>
                <p><?php _e('Project is currently available for bidders', ET_DOMAIN);?></p>
                <div class="info-bottom">
                   <p class="budget-bid"><?php _e("Budget", ET_DOMAIN); ?>: <span>{{= budget}}</span></p>
                   <p class="date-bid">{{= post_date}}</p>
                </div>
            <# }else if(post_status == 'complete'){ #>
                <p><?php _e('Project is already completed', ET_DOMAIN);?></p>
            <# } #>
        </div>
    </div>
    <# if(project_comment){ #>
    <div class="review-rate">
            <div class="rate-it" data-score="{{= rating_score}}"></div>
            <div class="comment-author-history">
                <p>{{= project_comment}}</p>
            </div>
        </div>
    <# } #>
</script>