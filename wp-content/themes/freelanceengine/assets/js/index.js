(function($, Models, Collections, Views) {
    $(document).ready(function() {
        $('.trim-text .show-more').click(function(event){
            $('.full-text').removeClass('hide');
            $('.trim-text').addClass('hide');
        });
        $('.full-text .show-less').click(function(event){
            $('.full-text').addClass('hide');
            $('.trim-text').removeClass('hide');
        });
        $('.btn-fre-credit-payment, .btn-withdraw, .not-have-bid, .btn-submit-price-plan').popover({
            trigger: 'hover',
            placement: 'auto',
        });
        $('#datetimepicker5').datetimepicker({
            defaultDate: new Date(),
            format: 'DD/MM/YYYY',
            icons: {
                previous: 'fa fa-angle-left',
                next: 'fa fa-angle-right',
            }

        });
        $('#datetimepicker6').datetimepicker({
            defaultDate: new Date(),
            format: 'DD/MM/YYYY',
            icons: {
                previous: 'fa fa-angle-left',
                next: 'fa fa-angle-right',
            }

        });
        
        $.fn.trimContent = function() {
            var showChar = 90;  // How many characters are shown by default
            var ellipsestext = "...";
            $('.comment-author-history p').each(function() {
                var content = $(this).html();
                if(content.length > showChar && !$(this).parent().find('.show-more').length) {
                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);
                    var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent" style="display:none;"><span>' + h + '</span>&nbsp;&nbsp;</span>';
                    $(this).html(html);
                    var html_view = '<a class="show-more">' + ae_globals.text_view.more + '</a>';
                    $(this).parent().append(html_view);
                }     
            });
         
            $(".show-more").click(function(e){
                e.preventDefault();
                var content = $(this).parent();
                if($(this).hasClass("less")) {
                    $(content).find('p .morecontent').hide();
                    $(content).find('p .moreellipses').show();
                    $(this).removeClass("less");
                    $(this).html(ae_globals.text_view.more);
                } else {
                    $(content).find('p .morecontent').show();
                    $(content).find('p .moreellipses').hide();                
                    $(this).addClass("less");
                    $(this).html(ae_globals.text_view.less);
                }
            });
       }; 
        var load_more_home = $('.section-project-home .paginations-wrapper a.load-more-post');
        if(load_more_home.length > 0){
            //load_more_home.text('');
        }
        // blog list control
        if ($('#posts_control').length > 0) {
            if ($('#posts_control').find('.postdata').length > 0) {
                var postsdata = JSON.parse($('#posts_control').find('.postdata').html()),
                    posts = new Collections.Blogs(postsdata);
            } else {
                posts = new Collections.Blogs();
            }
            /**
             * init list blog view
             */
            new ListBlogs({
                itemView: BlogItem,
                collection: posts,
                el: $('#posts_control').find('.post-list')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: posts,
                el: $('#posts_control')
            });
        }
        /**
         * // end blog list control
         */
        // projects list control
        $('.section-archive-project, .tab-project-home').each(function() {
            if ($(this).find('.postdata').length) {
                var postdata = JSON.parse($(this).find('.postdata').html()),
                    collection = new Collections.Projects(postdata);
            } else {
                var collection = new Collections.Projects();
            }
            var skills = new Collections.Skills();
            /**
             * init list blog view
             */
            new ListProjects({
                itemView: ProjectItem,
                collection: collection,
                el: $(this).find('.project-list-container')
            });
            //post-type-archive-project
            //old block-projects
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: collection,
                skills: skills,
                el: $(this),
                onAfterLoadMore: function( result, resp){
                    var view = this;
                    view.addViewAll();
                },
                onAfterFetch: function( result, resp){
                    var view = this;
                    view.addViewAll();
                    if(result.length > 0){
                        $('.profile-no-result').hide();
                        $('.title-tab-project').show();
                    }else{
                        $('.plural').show().removeClass('hide');
                        $('.singular').hide();
                        $('.profile-no-result').show();
                        $('.title-tab-project').hide();
                    }
                },
                addViewAll: function(){
                     $('.vs-tab-project-home').each( function(){
                        if( $(this).find('.paginations-wrapper a.view-all').length > 0){
                            $(this).find('.paginations-wrapper a.view-all').remove();
                            $(this).find('.paginations-wrapper').append(ae_globals.view_all_text);
                        }
                        else{
                            $(this).find('.paginations-wrapper').append(ae_globals.view_all_text);
                        }
                    });
                },
                onAfterOrder : function($target , view){             
                    var buttons = view.$el.find('.orderby');
                    $.each(buttons, function(key, value){
                        if(!$(value).hasClass('active')){
                            $(value).find('i.fa').attr('class','fa fa-sort');
                        }
                    });

                    var order = $target.attr('data-order');
                    if(order == 'ASC'){
                        $target.attr('data-order', 'DESC');
                        $target.find('i.fa').removeClass('fa-sort');
                        $target.find('i.fa').removeClass('fa-sort-desc').addClass('fa-sort-asc');
                    }
                    if(order == 'DESC'){
                        $target.attr('data-order', 'ASC');
                        $target.find('i.fa').removeClass('fa-sort');
                        $target.find('i.fa').removeClass('fa-sort-asc').addClass('fa-sort-desc');
                    }
                }
            });

        });
        if ($('.info-project-items').length > 0) {
            if ($('.info-project-items').find('.postdata').length > 0) {
                var postdata = JSON.parse($('.info-project-items').find('.postdata').html()),
                    collection = new Collections.Bids(postdata);
            } else {
                collection = new Collections.Bids();
            }
            
            // init list blog view
             
            new User_ListBids({
                itemView: User_BidItem,
                collection: collection,
                el: $('.info-project-items').find('.bid-list-container')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: collection,
                el: $('.info-project-items'),
                onBeforeFetch: function(){
                    if($('.info-project-items').find('.no-results').length > 0 ){
                        $('.info-project-items').find('.no-results').remove();
                    }
                },
                onAfterFetch: function(result, res){
                    if( !res.success || result.length == 0){
                        $('.info-project-items').find('.bid-list-container').html(ae_globals.text_message.no_project);
                    }
                }
            });
        }
        /**
         * // end project list control
         */
        //profile list control
        $('.section-archive-profile, .tab-profile-home').each(function() {
            if ($(this).find('.postdata').length > 0) {
                var postdata = JSON.parse($(this).find('.postdata').html()),
                    collection = new Collections.Profiles(postdata);
            } else {
                var collection = new Collections.Profiles();
            }
            var skills = new Collections.Skills();
            /**
             * init list blog view
             */
            new ListProfiles({
                itemView: ProfileItem,
                collection: collection,
                el: $(this).find('.profile-list-container')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: collection,
                skills: skills,
                el: $(this),
                onBeforeLoadMore: function(){

                },
                onAfterLoadMore: function( result, resp){
                    var view = this;
                    view.addViewAllProfile();
                },
                onAfterFetch: function( result, resp){
                    var view = this;
                    view.addViewAllProfile();
                    if(result.length > 0){
                        $('.profile-no-result').hide();
                    }else{
                        $('.plural').show().removeClass('hide');
                        $('.singular').hide();
                        $('.profile-no-result').show();
                    }
                },
                addViewAllProfile: function(){
                    $('.vs-tab-profile-home').each( function(){
                        if( $(this).find('.paginations-wrapper a.view-all').length > 0){
                            $(this).find('.paginations-wrapper a.view-all').remove();
                            $(this).find('.paginations-wrapper').append(ae_globals.view_all_text_profile);
                        }
                        else{
                            $(this).find('.paginations-wrapper').append(ae_globals.view_all_text_profile);
                        }
                    });
                }
            });
        });

        if ($('.freelancer-project-history').length > 0) {
            var $container = $('.freelancer-project-history');
            if ($container.find('.postdata').length > 0) {
                var postdata = JSON.parse($container.find('.postdata').html()),
                    collection = new Collections.Bids(postdata);
            } else {
                var collection = new Collections.Bids();
            }
            /**
             * init list bid view
             */
            new AuthorFreelancerHistory({
                itemView: AuthorFreelancerHistoryItem,
                collection: collection,
                el: $container.find('.list-work-history-profile')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: collection,
                el: $container,
                onBeforeFetch: function(){
                    if($container.find('.no-results').length > 0 ){
                        $container.find('.no-results').remove();
                    }
                },
                onAfterFetch: function(result, res){
                    $.fn.showHideReview();
                    if( !res.success || result.length == 0){
                        $container.find('.list-history-profile').html(ae_globals.text_message.no_project);
                    }
                }
            });
        }
        if ($('.employer-project-history').length > 0) {
            var $container = $('.employer-project-history');
            if ($container.find('.postdata').length > 0) {
                var postdata = JSON.parse($container.find('.postdata').html()),
                    collection = new Collections.Projects(postdata);
            } else {
                var collection = new Collections.Projects();
            }
            /**
             * init list bid view
             */
            new AuthorEmployerHistory({
                itemView: AuthorEmployerHistoryItem,
                collection: collection,
                el: $container.find('.list-work-history-profile')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: collection,
                el: $container,
                onBeforeFetch: function(){
                    if($container.find('.no-results').length > 0 ){
                        $container.find('.no-results').remove();
                    }
                },
                onAfterFetch: function(result, res){
                    $.fn.showHideReview();
                    $.fn.trimContent();
                    if( !res.success || result.length == 0){
                        $container.find('.list-work-history-profile').html(ae_globals.text_message.no_project);
                    }
                }
            });
            $.fn.trimContent();
        }

        /**
         * // end profile list control
         */
        if ($('.portfolio-container').length > 0) {
            var $container = $('.portfolio-container');
            //portfolio list control
            if ($('.portfolio-container').find('.postdata').length > 0) {
                var postdata = JSON.parse($container.find('.postdata').html()),
                    collection = new Collections.Portfolios(postdata);
            } else {
                var collection = new Collections.Portfolios();
            }
            /**
             * init list blog view
             */
            new ListPortfolios({
                itemView: PortfolioItem,
                collection: collection,
                el: $container.find('.list-item-portfolio')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: collection,
                el: $container
            });
        }
        /**
         * // end porfolio list control
         */
        if ($('.bid-history').length > 0) {
            var $container = $('.bid-history');
            // $('.profile-history').each(function(){
            if ($container.find('.postdata').length > 0) {
                var postdata = JSON.parse($container.find('.postdata').html()),
                    collection = new Collections.Bids(postdata);
            } else {
                var collection = new Collections.Bids();
            }
            
            /**
             * init list bid view
             */
            new ListBids({
                itemView: BidHistoryItem,
                collection: collection,
                el: $container.find('.list-history-profile')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: collection,
                el: $container,
                onBeforeFetch: function(){
                    if($container.find('.no-results').length > 0 ){
                        $container.find('.no-results').remove();
                    }
                },
                onAfterFetch: function(result, res){
                    $.fn.trimContent();
                    if( !res.success || result.length == 0){
                        $container.find('.list-history-profile').html(ae_globals.text_message.no_work_history);
                    }
                }
            });
            // });
        }
        if ($('.project-history').length > 0) {
            var $container = $('.project-history');
            // $('.profile-history').each(function(){
            if ($container.find('.postdata').length > 0) {
                var postdata = JSON.parse($container.find('.postdata').html()),
                    collection = new Collections.Projects(postdata);
            } else {
                var collection = new Collections.Projects();
            }
            /**
             * init list bid view
             */
            new ListWorkHistory({
                itemView: WorkHistoryItem,
                collection: collection,
                el: $container.find('.list-history-profile')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: collection,
                el: $container,
                onBeforeFetch: function(){
                    if($container.find('.no-results').length > 0 ){
                        $container.find('.no-results').remove();
                    }
                },
                onAfterFetch: function(result, res){
                    $.fn.showHideReview();
                    if( !res.success || result.length == 0){
                        $container.find('.list-history-profile').html(ae_globals.text_message.no_project);
                    }
                }
            });
            // });
        }
        if ($('.section-archive-testimonial').length > 0) {
            if ($('.section-archive-testimonial').find('.testimonial_data').length > 0) {
                var postsdata = JSON.parse($('.section-archive-testimonial').find('.testimonial_data').html()),
                    posts = new Collections.Posts(postsdata);
            } else {
                posts = new Collections.Posts();
            }
            /**
             * init list blog view
             */
            new ListTestimonials({
                itemView: TestimonialItem,
                collection: posts,
                el: $('.section-archive-testimonial').find('.testimonial-list-container')
            });
            /**
             * init block control list blog
             */
            new Views.BlockControl({
                collection: posts,
                el: $('.section-archive-testimonial'),
            });
        }

        if(ae_globals.gg_captcha == '1' && ae_globals.is_submit_project == '1'){
            $('#modal_register').on('shown.bs.modal', function() {
               if($('.signup_form_submit .container_captcha .gg-captcha').length > 0){
                    var captchaHTML = $('.signup_form_submit .container_captcha .gg-captcha').appendTo('#modal_register .container_captcha');
                   // reset Recaptcha
                   grecaptcha.reset();
                }
            });
            $('#modal_register').on('hidden.bs.modal', function() {
                if($('#modal_register .container_captcha .gg-captcha').length > 0){
                    var captchaHTML = $('#modal_register .container_captcha .gg-captcha').appendTo('.signup_form_submit .container_captcha');
                   // reset Recaptcha
                   grecaptcha.reset();
                }
            });
        }
        $.fn.showHideReview = function() {
            var $container = $('.project-history, .employer-project-history');
            
            $( 'li.bid-item .review', $container).click(function(e){
                e.preventDefault();
                var $target = $(e.currentTarget),
                    $bidItem = $target.parents('.bid-item ');
                    if ( $bidItem.find('.review-rate').css('display') == 'none' ){
                        $('.review i', $bidItem).each(function(){
                            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                            $bidItem.find('.review-rate').show();
                        });
                    }else{
                        $('.review i', $bidItem).each(function(){
                            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                            $bidItem.find('.review-rate').hide();
                        });
                    }
            });

            $('.comment-author-history .comment-viewmore, .comment-author-history .comment-viewless').on('click', function() {
                $(this).parent().toggleClass('active');
            });  
        };
        $.fn.showHideReview();

       
    });
})(jQuery, window.AE.Models, window.AE.Collections, window.AE.Views);
