<?php
	et_get_mobile_header();
?>

<!-- block control  -->
<!-- <div class="blog-content">
    <h2 class="title-blog">
    	<?php //_e("Not Found", ET_DOMAIN); ?>
    </h2>
</div> -->
<div class="page-notfound-content">
	<h2><?php _e("404 Error", ET_DOMAIN); ?></h2>
    <h4><?php _e("Sorry, the page you were looking for doesn’t exist!", ET_DOMAIN ); ?></h4>
    <?php printf(__('Go back to <a href="%s">home</a> page or return to <a href="#" onclick="window.history.back()">previous</a> page.', ET_DOMAIN),
        			home_url()); ?></p>
</div>
<!--// block control  -->

<?php
	et_get_mobile_footer();
?>