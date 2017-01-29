<?php
/**
 * Template part for freelancer bid history 
 # this template is loaded in template/bid-history.php
 * @since 1.0	
 * @package FreelanceEngine
 */
global $wp_query, $ae_post_factory;
$author_id = get_query_var('author');
$post_object = $ae_post_factory->get(BID);

?>
<ul class="list-history-author list-history-profile">
	<?php
		if(have_posts()):
			$postdata = array();
			while (have_posts()) { the_post();
			    $convert = $post_object->convert($post,'thumbnail');
			    $postdata[] = $convert;
			    get_template_part( 'mobile/template/author', 'freelancer-history-item' );
		    }
	    else:
        _e('<span class="no-results">There are no activities yet.</span>',ET_DOMAIN);
    	endif;
    ?>
</ul>

<?php
/**
 * render post data for js
*/
if(have_posts()):
	echo '<script type="data/json" class="postdata" >'.json_encode($postdata).'</script>';
?>
<!-- pagination -->
<?php
	$wp_query->query = array_merge(  $wp_query->query) ;   
	echo '<div class="paginations-wrapper">';
	ae_pagination($wp_query, get_query_var('paged'), 'load');
	echo '</div>';    
endif; 
wp_reset_query();        
?>

