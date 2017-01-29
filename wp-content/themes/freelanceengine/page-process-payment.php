<?php
/**
 *	Template Name: Process Payment
 */
$session	=	et_read_session ();
global $ad , $payment_return, $order_id, $user_ID;

$payment_type	= get_query_var( 'paymentType' );
if($payment_type == 'usePackage' || $payment_type == 'free' ){
	$payment_return = ae_process_payment($payment_type, $session);
	 if($payment_return['ACK']) {
        $project_url = get_the_permalink($session['ad_id']);
        // Destroy session for order data
        et_destroy_session();
        // Redirect to project detail
        wp_redirect($project_url);
        exit;
    }
}

/**
 * get order
 */
$order_id = isset($_GET['order-id']) ? $_GET['order-id'] : '';
if(empty($order_id) && isset($_POST['orderid'])){
	$order_id = $_POST['orderid'];
}
// if(isset($session['']))
$order = new AE_Order($order_id);
$order_data = $order->get_order_data();
if (($payment_type == 'paypaladaptive' || $payment_type == 'frecredit' || $payment_type == 'stripe') && !$order_id) {

	$payment_return = fre_process_escrow($payment_type , $session );
	$payment_return	=	wp_parse_args( $payment_return, array('ACK' => false, 'payment_status' => '' ));
	extract( $payment_return );
	if(isset($ACK) && $ACK):
		// Accept bid
		$ad_id		= $session['ad_id'];
		$order_id 	= $session['order_id'];
		$permalink	= get_permalink( $ad_id );
		$permalink 	= add_query_arg(array('workspace' => 1), $permalink );
		$workspace 	= '<a href="'.$permalink.'">'.get_the_title($ad_id).'</a>';
		$bid_id 	= get_post_field('post_parent', $order_id);
		$bid_budget = get_post_meta($bid_id, 'bid_budget', true);
		$content_arr = array(
				'paypaladaptive' 	=> __('Paypal', ET_DOMAIN),
				'frecredit'			=> __('Credit', ET_DOMAIN),
				'stripe'			=> __('Stripe', ET_DOMAIN)
			);

		// get commission settings
	    $commission = ae_get_option('commission', 0);
	    $commission_fee = $commission;

	    // caculate commission fee by percent
	    $commission_type = ae_get_option('commission_type');
	    if ($commission_type != 'currency') {
	        $commission_fee = ((float)($bid_budget * (float)$commission)) / 100;
	    }

	    $commission = fre_price_format($commission_fee);
	    $payer_of_commission = ae_get_option('payer_of_commission', 'project_owner');
	    if ($payer_of_commission == 'project_owner') {
	        $total = (float)$bid_budget + (float)$commission_fee;
	    }
	    else {
	        $commission = 0;
	        $total = $bid_budget;
	    }

		get_header();
?>
		<section class="blog-header-container">
			<div class="container">
				<!-- blog header -->
				<div class="row">
				    <div class="col-md-12 blog-classic-top">
				        <h2><?php the_title(); ?></h2>
				    </div>
				</div>
				<!--// blog header  -->
			</div>
		</section>

		<!-- Page Blog -->
		<section id="blog-page">
		    <div class="container page-container">
				<!-- block control  -->
				<div class="row block-posts block-page">
					<div class="col-md-12 col-sm-12 col-xs-12">
			            <div class="content-process-payment accept-bid">
							<!-- Accept bid -->							
							<h2><?php _e("THANK YOU!", ET_DOMAIN);?></h2>
							<p class="sub-text">
								<?php 
									_e("The transaction was successful, money is kept by the Admin", ET_DOMAIN);
									echo "<br>";
									_e("Please check the info below", ET_DOMAIN);
								?>
							</p>
							<div class="invoice-detail">
								<div class="row">
									<div class="col-xs-6 info-left"><span><?php _e("Date", ET_DOMAIN);?></span></div>
									<div class="col-xs-6 info-right"><span><?php echo get_the_date(get_option('date_format'), $order_id); ?></span></div>
									<div class="col-xs-6 info-left"><span><?php _e("Payment Type", ET_DOMAIN);?></span></div>
									<div class="col-xs-6 info-right"><span><?php echo $content_arr[$payment_type];?></span></div>
									<div class="col-xs-6 info-left"><span><?php _e("Total", ET_DOMAIN);?></span></div>
									<div class="col-xs-6 info-right"><span><?php echo fre_price_format($total); ?></span></div>
								</div>
							</div>
							<div class="content-footer">
								<p><?php _e("Your project is currently in process", ET_DOMAIN);?></p>
								<a class="btn-redirect" href="<?php echo $permalink;?>"><?php _e("Check It", ET_DOMAIN);?></a>
							</div>
							<!-- Accept Bid -->
						</div>
			        </div>
				</div>
		    </div>
		</section>
<?php
		get_footer();
	else:
		# code...
		// Redirect to 404
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 ); exit();
	endif;
}else if($order_id && ($user_ID == $order_data['payer'] || is_super_admin($user_ID))){
	// Process submit project
	get_header();
	$ad = get_post($order_data['product_id']);
	$project_id = (isset($session['project_id'])) ? $session['project_id'] : '';
?>
	<section class="blog-header-container">
		<div class="container">
			<!-- blog header -->
			<div class="row">
			    <div class="col-md-12 blog-classic-top">
			        <h2><?php the_title(); ?></h2>
			    </div>
			</div>
			<!--// blog header  -->
		</div>
	</section>

	<!-- Page Blog -->
	<section id="blog-page">
	    <div class="container page-container">
			<!-- block control  -->
			<div class="row block-posts block-page">
				<div class="col-md-12 col-sm-12 col-xs-12">
		            <div class="content-process-payment">
						<!-- Submit project success -->
						<h2><?php _e("PAYMENT COMPLETED", ET_DOMAIN);?></h2>
						<p class="sub-text"><?php _e("Thank you. Your payment has been received and the process is now being run!", ET_DOMAIN);?></p>
						<div class="invoice-detail">
							<div class="row">
								<div class="col-xs-6 info-left"><span><?php _e("Invoice No.", ET_DOMAIN);?></span></div>
								<div class="col-xs-6 info-right"><span><?php echo $order_data['ID']; ?></span></div>
								<div class="col-xs-6 info-left"><span><?php _e("Date", ET_DOMAIN);?></span></div>
								<div class="col-xs-6 info-right"><span><?php echo get_the_date(get_option('date_format'), $order_id); ?></span></div>
								<div class="col-xs-6 info-left"><span><?php _e("Payment Type", ET_DOMAIN);?></span></div>
								<div class="col-xs-6 info-right"><span><?php echo $order_data['payment'];?></span></div>
								<div class="col-xs-6 info-left"><span><?php _e("Total", ET_DOMAIN);?></span></div>
								<div class="col-xs-6 info-right"><span><?php echo fre_price_format($order_data['total']); ?></span></div>
							</div>
							<?php 
								if($order_data['payment'] == 'cash') :
	                            $cash_options = ae_get_option('cash');
	                            $cash_message = $cash_options['cash_message'];
	                        ?>
	                            <div class="invoice-note">
	                                <?php echo $cash_message; ?>
	                            </div>
	                        <?php endif; ?>
						</div>
						<div class="content-footer">
							<?php 
								if(isset($order_data['products'])){
									$product = current($order_data['products']);
									$type = $product['TYPE'];
									switch ($type) {
										case 'bid_plan':
											// buy bid
											if($project_id){
												$permalink = get_the_permalink($project_id);
											}else{
												$permalink =  et_get_page_link('profile');
											}
											echo "<p>".__('Now you can return to the project or profile pages', ET_DOMAIN)."</p>";
											echo "<a class='btn-redirect' href='".$permalink."'>".__('Return', ET_DOMAIN)."</a>";
											break;
										case 'fre_credit_plan':
											// deposit credit
											if($project_id){
												$permalink = get_the_permalink($project_id);
											}else{
												$permalink =  et_get_page_link('profile') .'#credits';
											}
											echo "<p>".__('Please click the button below to return to the previous page', ET_DOMAIN)."</p>";
											echo "<a class='btn-redirect' href='".$permalink."'>".__('Click here', ET_DOMAIN)."</a>";
											break;
										default:
											// Submit project
											$permalink = get_the_permalink($ad->ID);
											echo "<p>".__('Your project details is now available for you to view', ET_DOMAIN)."</p>";
											echo "<a class='btn-redirect' href='".$permalink."'>".__('Go', ET_DOMAIN)."</a>";
											break;
									}
								}
							?>
						</div>
						<!-- Submit project success -->
					</div>
		        </div>
			</div>
	    </div>
	</section>
<?php
	if($order_id && !get_post_meta($order_id, 'et_order_is_process_payment')) {
		
		//processs payment
		if ($payment_type == 'paypaladaptive' || $payment_type == 'frecredit') {
			$payment_return = fre_process_escrow($payment_type , $session );
		}else{
			$payment_type = $order_data['payment'];
			$payment_return = ae_process_payment($payment_type , $session );
		}
		update_post_meta($order_id, 'et_order_is_process_payment', true);
		et_destroy_session();
	}
	get_footer();
}else{
	// Redirect to 404
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	get_template_part( 404 ); exit();
}

	