<?php
global $ae_post_factory, $post;
$his_obj = $ae_post_factory->get('fre_credit_history');
$convert = $his_obj->convert($post);
$style = $convert->style;

?>
<li class="history-item">
    <div class="information-detail">
        <p><span class="cate-credit"><?php echo $convert->post_title; ?></span>
        	<span class="<?php echo $style['color'];?>"><?php echo $convert->amount_text ?></span> <?php echo $convert->info_changelog;?>
        </p>
        <p><?php _e('Balance:', ET_DOMAIN); ?> <span class="price"><?php echo $convert->user_balance; ?></span></p>
        <p class="status <?php echo $style['color'];?>"><?php echo $convert->history_status; ?></p>
    </div>
    <div class="information-status">
        <p class="date"><?php echo $convert->history_time ?></p>
    </div>
</li>