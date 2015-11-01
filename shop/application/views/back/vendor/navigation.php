<nav id="mainnav-container">
    <div id="mainnav">
        <!--Menu-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">
                        <!--Category name-->
                        <li class="list-header"></li>
            
                        <!--Menu list item-->
                        <li <?php if($page_name=="dashboard"){?> class="active-link" <?php } ?> 
                        	style="border-top:1px solid rgba(69, 74, 84, 0.7);">
                            <a href="<?php echo base_url(); ?>index.php/vendor/">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">
									<?php echo translate('dashboard');?>
                                </span>
                            </a>
                        </li>
                        
            			<?php
                        	if( $this->crud_model->vendor_permission('product') || 
									$this->crud_model->vendor_permission('stock') ){
						?>
                        <!--Menu list item-->
                        <li <?php if( $page_name=="product" || 
                                            $page_name=="stock" ){?>
                                                 class="active-sub" 
                                                    <?php } ?> >
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-title">
                                        <?php echo translate('my_products');?>
                                    </span>
                                	<i class="fa arrow"></i>
                            </a>
            
                            <!--PRODUCT------------------>
                            <ul class="collapse <?php if( $page_name=="product" || 
                                                            $page_name=="stock" ){?>
                                                                 in
                                                                    <?php } ?> >" >
                                
                                <?php
                                 if($this->crud_model->vendor_permission('product')){
                                ?>
                                    <li <?php if($page_name=="product"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/vendor/product">
                                        	<i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('product_list');?>
                                        </a>
                                    </li>
								<?php
									} if($this->crud_model->vendor_permission('stock')){
                                ?>
                                    <li <?php if($page_name=="stock"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/vendor/stock">
                                        	<i class="fa fa-circle fs_i"></i>
                                        		<?php echo translate('product_stock');?>
                                        </a>
                                    </li>
								<?php
									}
                                ?>
                            </ul>
                        </li>
                      
            			<?php
							}
						?>  
                        
                        <!--SALE-------------------->
						<?php
							if($this->crud_model->vendor_permission('sale')){
						?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="sales"){?> class="active-link" <?php } ?>>
                            <a href="<?php echo base_url(); ?>index.php/vendor/sales/">
                                <i class="fa fa-usd"></i>
                                    <span class="menu-title">
                                		<?php echo translate('sale');?>
                                    </span>
                            </a>
                        </li>
                        <?php
							}
						?>
						
                        <?php
							if($this->crud_model->vendor_permission('report')){
						?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="report" || 
                                        $page_name=="report_stock" ||
                                            $page_name=="report_wish" ){?>
                                                     class="active-sub" 
                                                        <?php } ?>>
                            <a href="#">
                                <i class="fa fa-file-text"></i>
                                    <span class="menu-title">
                                		<?php echo translate('reports');?>
                                    </span>
                                		<i class="fa arrow"></i>
                            </a>
                            
                            <!--REPORT-------------------->
                            <ul class="collapse <?php if($page_name=="report" || 
                                                            $page_name=="report_stock" ||
                                                                $page_name=="report_wish" ){?>
                                                                             in
                                                                                <?php } ?> ">
                                <li <?php if($page_name=="report"){?> class="active-link" <?php } ?> >
                                	<a href="<?php echo base_url(); ?>index.php/vendor/report/">
                                    	<i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('product_compare');?>
                                    </a>
                                </li>
                                <li <?php if($page_name=="report_stock"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/vendor/report_stock/">
                                    	<i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('product_stock');?>
                                    </a>
                                </li>
                                <li <?php if($page_name=="report_wish"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/vendor/report_wish/">
                                    	<i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('product_wishes');?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
							}
						?>

                                                
                        <?php
                            if($this->crud_model->vendor_permission('coupon')){
                        ?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="coupon"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/coupon/">
                                <i class="fa fa-tags"></i>
                                    <span class="menu-title">
                                        <?php echo translate('discount_coupon');?>
                                    </span>
                            </a>
                        </li>
                        <!--Menu list item-->
                        <?php
                            }
                        ?>
                        
                                                
                        <?php
                            if($this->crud_model->vendor_permission('site_settings')){
                        ?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="site_settings"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/site_settings/general_settings/">
                                <i class="fa fa-wrench"></i>
                                    <span class="menu-title">
                                        <?php echo translate('settings');?>
                                    </span>
                            </a>
                        </li>
                        <!--Menu list item-->
                        <?php
                            }
                        ?>
                        
                        <?php
                            if($this->crud_model->vendor_permission('business_settings')){
                        ?>
                        <li <?php if($page_name=="business_settings"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/business_settings/">
                                <i class="fa fa-dollar"></i>
                                <span class="menu-title">
                                    <?php echo translate('payment_settings');?>
                                </span>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        
                        <?php
                            if($this->crud_model->vendor_permission('business_settings')){
                        ?>
                        <li <?php if($page_name=="package"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/package/">
                                <i class="fa fa-gift"></i>
                                <span class="menu-title">
                                    <?php echo translate('my_packages');?>
                                </span>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        
                        <li <?php if($page_name=="manage_vendor"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/manage_vendor/">
                                <i class="fa fa-lock"></i>
                                <span class="menu-title">
                                	<?php echo translate('manage_vendor_profile');?>
                                </span>
                            </a>
                        </li>
                </div>
            </div>
        </div>
    </div>
</nav>