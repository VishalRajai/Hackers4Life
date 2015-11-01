    <!--=== Content Medium Part ===-->
    <div class="content-md margin-bottom-30">
        <div class="container">
            <?php
                echo form_open(base_url() . 'index.php/home/cart_finish/go', array(
                    'class' => 'shopping-cart',
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                    'id' => 'cart_form'
                ));
            ?>    
                <div>
                    <div class="header-tags">
                        <div class="overflow-h">
                            <h2><?php echo translate('shopping_cart');?></h2>
                            <p><?php echo translate('review_&_edit_your_product');?></p>
                            <i class="rounded-x fa fa-check"></i>
                        </div>    
                    </div>
                    <section>
                        <div class="table-responsive cart_list">
                            <table class="table" style="border: 1px solid #ddd;">
                                <thead>
                                    <tr>
                                        <td><?php echo translate('product');?></td>
                                        <td><?php echo translate('choices');?></td>
                                        <td><?php echo translate('price');?></td>
                                        <td><?php echo translate('qty');?></td>
                                        <td><?php echo translate('total');?></td>
                                        <td style="text-align:right !important;"><?php echo translate('option');?></td>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($carted as $items){ ?>

                                    <tr data-rowid="<?php echo $items['rowid']; ?>" >
                                        <td class="product-in-table">
                                            <img class="img-responsive" src="<?php echo $items['image']; ?>" alt="">
                                            <div class="product-it-in">
                                                <h3><?php echo $items['name']; ?></h3>
                                            </div>    
                                        </td>
                                        <td class="shop-product">
                                            <?php 
                                                $color = $this->crud_model->is_added_to_cart($items['id'],'option','color');
                                                    if($color){
                                            ?>
                                            <div style="background:<?php echo $color; ?>; height:25px; width:25px;" ></div>
                                            <?php
                                                }
                                            ?>
                                            <?php
                                                $all_o = json_decode($items['option'],true);
                                                foreach ($all_o as $l => $op) {
                                                    if($l !== 'color' && $op['value'] !== '' && $op['value'] !== NULL){
                                            ?>
                                                <?php echo $op['title'] ?> : 
                                                <?php 
                                                    if(is_array($va = $op['value'])){ 
                                                        echo $va = join(', ',$va); 
                                                    } else {
                                                        echo $va;
                                                    }
                                                ?>
                                                <br>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            <a href="<?php echo $this->crud_model->product_link($items['id']); ?>"><?php echo translate('change_choices'); ?></a>
                                        </td>
                                        <td class="pric"><?php echo currency().$this->cart->format_number($items['price']); ?></td>
                                        <td>
                                            <button type='button' class="quantity-button minus" value='minus'>-</button>
                                            <input type='text' disabled step='1' class="quantity-field quantity_field" data-rowid="<?php echo $items['rowid']; ?>" data-limit='no' value="<?php echo $items['qty']; ?>" id='qty1' onblur="check_ok(this);" />
                                            <button type='button' class="quantity-button plus" value='plus'>+</button>
                                            <span class="button limit" style="display:none;"></span>
                                        </td>
                                        <td class="shop-red sub_total"><?php echo currency().$this->cart->format_number($items['subtotal']); ?></td>
                                        <td class="text-center">
                                            <button type="button" class="close">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </section>

                    <script>
                        var add_to_cart = '<?php echo translate('add_to_cart'); ?>';
                        var base_url = '<?php echo base_url(); ?>';
                        set_cart_form();
                    </script>
                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false"></script>
                    <script src="<?php echo base_url(); ?>template/front/assets/js/custom/cart.js"></script>

                    <div class="header-tags">
                        <div class="overflow-h">
                            <h2><?php echo translate('shipping_info'); ?></h2>
                            <p><?php echo translate('shipping_and_address_info'); ?></p>
                            <i class="rounded-x fa fa-home"></i>
                        </div>    
                    </div>
                    <section class="billing-info">
                        <div class="row">
                            <div class="col-md-12 md-margin-bottom-40">
                                <h2 class="title-type"><?php echo translate('shipping_address');?></h2>
                                <div class="billing-info-inputs checkbox-list">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input id="name" type="text" placeholder="<?php echo translate('first_name'); ?>" name="firstname" class="form-control required">
                                            <input id="email" type="text" placeholder="<?php echo translate('email'); ?>" name="email" class="form-control  email required">
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="surname" type="text" placeholder="<?php echo translate('last_name'); ?>" name="lastname" class="form-control required">
                                            <input id="phone" type="tel" placeholder="<?php echo translate('phone'); ?>" name="phone" class="form-control required">
                                        </div>
                                    </div>
                                    <input id="address_1" type="text" placeholder="<?php echo translate('address_line_1'); ?>" name="address1" class="form-control address required">
                                    <input id="address_2"  type="text" placeholder="<?php echo translate('address_line_2'); ?>" name="address2" class="form-control address required">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input id="city" type="text" placeholder="<?php echo translate('city'); ?>" name="city" class="form-control address required">
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="zip" type="text" placeholder="<?php echo translate('zip/postal_code'); ?>" name="zip" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" id="lnlat" style="display:none;" >
                                        <div class="col-sm-12">
                                            <input id="langlat" type="text" placeholder="langitude - latitude" name="langlat" class="form-control required" readonly>
                                        </div>
                                    </div>
                                    <div class="" id="maps" style="height:400px;" >
                                        <div id="map-canvas" style="height:400px;"></div>
                                    </div>


                                </div>
                            </div>
                        </div> 
                    </section>
                    
                    <div class="header-tags">
                        <div class="overflow-h">
                            <h2><?php echo translate('payment');?></h2>
                            <p><?php echo translate('select_payment_method');?></p>
                            <i class="rounded-x fa fa-credit-card"></i>
                        </div>    
                    </div>
                    <section>
                        <div class="row">
                            <div class="col-md-6 md-margin-bottom-50">
                                <h2 class="title-type"><?php echo translate('choose_a_payment_method');?></h2>
                                <div class="cc-selector">
                                    <?php
                                        $p_set = $this->db->get_where('business_settings',array('type'=>'paypal_set'))->row()->value;
                                        $c_set = $this->db->get_where('business_settings',array('type'=>'cash_set'))->row()->value;
                                        $s_set = $this->db->get_where('business_settings',array('type'=>'stripe_set'))->row()->value;
                                        if($p_set == 'ok'){
                                    ?>
                                    <input id="visa" type="radio" name="payment_type" value="paypal" />
                                    <label class="drinkcard-cc visa" for="visa"></label>
                                    <?php
                                        } if($s_set == 'ok'){
                                    ?>
                                    <input id="mastercardd" type="radio" name="payment_type" value="stripe" />
                                    <label class="drinkcard-cc stripe" id="customButton" for="mastercardd"></label>
                                    <script src="https://checkout.stripe.com/checkout.js"></script>
                                    <script>
                                      var handler = StripeCheckout.configure({
                                        key: '<?php echo $this->db->get_where('business_settings' , array('type' => 'stripe_publishable'))->row()->value; ?>',
                                        image: '<?php echo base_url(); ?>template/front/assets/img/stripe.png',
                                        token: function(token) {
                                          // Use the token to create the charge with a server-side script.
                                          // You can access the token ID with `token.id`
                                          
                                          $('#cart_form').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
                                          if($( "#visa" ).length){
                                            $( "#visa" ).prop( "checked", false );
                                          }
                                          if($( "#mastercard" ).length){
                                            $( "#mastercard" ).prop( "checked", false );
                                          }
                                          $( "#mastercardd" ).prop( "checked", true );
                                          notify('<?php echo translate('your_card_details_verified!'); ?>','success','bottom','right');
                                          setTimeout(function(){ $('#cart_form').submit(); }, 500); 
                                        }
                                      });

                                      $('#customButton').on('click', function(e) {
                                        // Open Checkout with further options
                                        var total = $('#grand').html();
                                        total = total.replace("<?php echo currency(); ?>", '');
                                        total = parseFloat(total.replace(",", ''));
                                        total = total/parseFloat(<?php echo $this->crud_model->get_type_name_by_id('business_settings', '8', 'value'); ?>);
                                        total = total*100;
                                        handler.open({
                                          name: '<?php echo $system_title; ?>',
                                          description: '<?php echo translate('pay_with_stripe'); ?>',
                                          amount: total
                                        });
                                        e.preventDefault();
                                      });

                                      // Close Checkout on page navigation
                                      $(window).on('popstate', function() {
                                        handler.close();
                                      });
                                    </script>
                                    <?php
                                        } if($c_set == 'ok'){
                                    ?>
                                        <input id="mastercard" type="radio" name="payment_type" value="cash_on_delivery" checked />
                                        <label class="drinkcard-cc mastercard"for="mastercard"></label>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h2 class="title-type"><?php echo translate('frequently_asked_questions');?></h2>
                                <!-- Accordion -->
                                <div class="accordion-v2 plus-toggle">
                                    <div class="panel-group" id="accordion-v2">
                                        <?php
                                            $i = 0;
                                            $faqs = json_decode($this->db->get_where('business_settings',array('type'=>'faqs'))->row()->value,true);
                                            foreach ($faqs as $row) {
                                                $i++;
                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion-v2" href="#collapseOne-v<?php echo $i; ?>">
                                                        <?php echo $row['question']; ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne-v<?php echo $i; ?>" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <?php echo $row['answer']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!-- End Accordion -->    
                            </div>
                        </div>
                    </section>

                    <div class="coupon-code">
                        <div class="row">
                            <div class="col-sm-4 sm-margin-bottom-30">
                                <h3>Discount Code</h3>
                                <p>Enter your coupon code</p>
                                <span id="coupon_report">
                                    <?php if($this->cart->total_discount() <= 0 && $this->session->userdata('couponer') !== 'done' && $this->cart->get_coupon() == 0){ ?>
                                        <input class="form-control margin-bottom-10 coupon_code" type="text">
                                        <button type="button" class="btn-u btn-u-sea-shop coupon_btn"><?php echo translate('apply_coupon'); ?></button>
                                    <?php } else { ?>
                                        <h3><?php echo translate('coupon_already_activated'); ?></h3>  
                                    <?php } ?>
                                </span>
                            </div>
                            <script type="text/javascript">
                                $('.coupon_btn').on('click',function(){
                                    var txt = $(this).html();
                                    var code = $('.coupon_code').val();
                                    $('#coup_frm').val(code);
                                    var form = $('#coupon_set');
                                    var formdata = false;
                                    if (window.FormData){
                                        formdata = new FormData(form[0]);
                                    }
                                    var datas = formdata ? formdata : form.serialize();
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/home/coupon_check/',
                                        type        : 'POST', // form submit method get/post
                                        dataType    : 'html', // request type html/json/xml
                                        data        : datas, // serialize form data 
                                        cache       : false,
                                        contentType : false,
                                        processData : false,
                                        beforeSend: function() {
                                            $(this).html("<?php echo translate('applying..'); ?>");
                                        },
                                        success: function(result){
                                            if(result == 'nope'){
                                                notify("<?php echo translate('coupon_not_valid'); ?>",'warning','bottom','right');
                                            } else {
                                                var re = result.split(':-:-:');
                                                var ty = re[0];
                                                var ts = re[1];
                                                $("#coupon_report").fadeOut();
                                                notify("<?php echo translate('coupon_discount_successful'); ?>",'success','bottom','right');
                                                if(ty == 'total'){
                                                    $(".coupon_disp").show();
                                                    $("#disco").html(re[2]);
                                                }
                                                $("#coupon_report").html('<h3>'+ts+'</h3>');
                                                $("#coupon_report").fadeIn();
                                                update_calc_cart();
                                                update_prices();
                                            }
                                        }
                                    });
                                });
                            </script>
                            <div class="col-sm-4 col-sm-offset-4">
                                <div class="table-responsive cart_list">
                                    <table class="table" style="border: 1px solid #ddd;">
                                        <tr>
                                            <td><?php echo translate('subtotal');?></td>
                                            <td><span class="text-right" id="total"></span></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><?php echo translate('tax');?></td>
                                            <td><span class="text-right" id="tax"></span></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo translate('shipping');?></td>
                                            <td><span class="text-right" id="shipping"></span></td>
                                        </tr>
                                        <tr <?php if($this->cart->total_discount() <= 0){ ?>style="display:none;"<?php } ?> class="coupon_disp">
                                            <td><?php echo translate('coupon_discount');?></td>
                                            <td><span class="text-right" id="disco"><?php echo currency().$this->cart->total_discount(); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo translate('total');?></td>
                                            <td class="total-result-in"><span class="grand_total" id="grand"></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </form>
        </div><!--/end container-->
    </div>
    <input type="hidden" id="first" value="yes" />
    <!--=== End Content Medium Part ===-->  
<script>

    jQuery(document).ready(function() {
        App.init();
        StepWizard.initStepWizard();
    });

    $(document).ready(function() {
        update_calc_cart();
    });

</script>

<?php
    echo form_open('', array(
        'method' => 'post',
        'id' => 'coupon_set'
    ));
?>
<input type="hidden" id="coup_frm" name="code">
</form>

