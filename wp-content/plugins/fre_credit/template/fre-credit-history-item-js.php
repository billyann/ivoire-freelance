<script type="text/template" id="fre-credit-history-loop">

    <div class="information-detail">
        <p>
	       <span class="cate-credit">{{= post_title }}</span>
	        <span class="{{= style.color}}">{{= amount_text }}</span> {{= info_changelog}}
        </p>
        <p><?php _e('Balance:', ET_DOMAIN); ?> <span class="price">{{= user_balance }}</span></p>
        <p class="status {{= style.color}}">{{= history_status }}</p>
    </div>
    <div class="information-status">
        <p class="date">{{= history_time }}</p>
    </div>

</script>