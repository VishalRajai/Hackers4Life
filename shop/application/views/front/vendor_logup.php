<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" id="v_close_logup_modal" class="close" type="button">×</button>
            <br>
        </div>
        <div class="modal-body">
            <!--Reg Block-->
            <div class="">
                <div class="reg-block-header">
                    <h2><?php echo translate('be_a_seller');?></h2>
                    <p style="font-weight:300 !important;"><?php echo translate('already_a_seller?');?> <?php echo translate('click'); ?> <a class="color-purple" href="<?php echo base_url(); ?>index.php/vendor" ><?php echo translate('sign_in');?></a> <?php echo translate('to_login_your_account');?></p>
                </div>
				<?php
                    echo form_open(base_url() . 'index.php/home/vendor_logup/add_info/', array(
                        'class' => 'log-reg-v3 sky-form',
                        'method' => 'post',
                        'style' => 'padding:30px !important;',
                        'id' => 'login_form'
                    ));
                ?>                            
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="<?php echo translate('name'); ?>" name="name" class="form-control" >
                            </div>
                        </label>
                    </section>                   
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                <input type="text" placeholder="<?php echo translate('company'); ?>" name="company" class="form-control" >
                            </div>
                        </label>
                    </section>                     
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" placeholder="<?php echo translate('email_address'); ?>" name="email" class="form-control" >
                            </div>
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('password'); ?>" name="password1" class="form-control" >
                            </div>    
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('confirm_password'); ?>" name="password2" class="form-control" >
                            </div>    
                    		<div id='pass_note'></div> 
                        </label>
                    </section>   
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-desktop"></i></span>
                                <input type="text" placeholder="<?php echo translate('display_name'); ?>" name="display_name" class="form-control" >
                            </div>    
                        </label>
                    </section>  
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('address_line_1'); ?>" name="address1" class="form-control required" >
                            </div>    
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('address_line_2'); ?>" name="address2" class="form-control">
                            </div>    
                        </label>
                    </section>
                    
                    <div class="row margin-bottom-5">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4 text-right">
                            <div class="btn-u btn-u-cust btn-block margin-bottom-20 reg_btn v_logup_btn" data-ing='<?php echo translate('registering..'); ?>' data-msg="" type="submit">
                            	<?php echo translate('register');?>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn-u btn-u-default" type="button" id="v_clsreg" ><?php echo translate('close');?></button>
        </div>
    </div>
</div>
<script>
    var logup_success = '<?php echo translate('registration_successful!'); ?> <?php echo translate('please_check_your_email_inbox'); ?>';
    $('body').on('click','.v_logup_btn',function(){
        var here = $(this); // alert div for show alert message
        var form = here.closest('form');
        var can = '';
        var ing = here.data('ing');
        var msg = here.data('msg');
        var prv = here.html();
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: formdata ? formdata : form.serialize(), // serialize form data 
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                here.html(ing); // change submit button text
            },
            success: function(data) {
                here.fadeIn();
                here.html(prv);
                if(data == 'done'){
                    here.closest('.modal-content').find('#v_close_logup_modal').click();
                    notify(logup_success,'success','bottom','right'); 
                    sound('successful_logup');      
                } else {
                    //here.closest('.modal-content').find('#v_close_logup_modal').click();
                    notify(logup_fail+'<br>'+data,'warning','bottom','right');
                    //vend_logup();
                    sound('unsuccessful_logup');
                }
            },
            error: function(e) {
                console.log(e)
            }
        });
    });
</script>