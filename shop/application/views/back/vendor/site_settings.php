
<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_site');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="tab-base tab-stacked-left">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#demo-stk-lft-tab-2"><?php echo translate('vendor_images');?></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-4"><?php echo translate('social_media');?></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-5"><?php echo translate('SEO');?></a>
                    </li>
                </ul>

                <div class="tab-content bg_grey">
                    <span id="genset"></span>
                    <div id="demo-stk-lft-tab-2" class="tab-pane fade active in">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo translate('select_favicon');?></h3>
                                </div>
                            <?php
                                echo form_open(base_url() . 'index.php/vendor/vendor_images/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="form-group margin-top-10">
                                    <label class="col-sm-3 control-label margin-top-10" for="demo-hor-inputemail"><h5>Logo</h5> <br><i>(suggested width:height - 300px:300px*)</i></label>
                                    <div class="col-sm-9">
                                        <div class="col-sm-2">
                                            <img class="img-responsive img-md img-border" src="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $this->session->userdata('vendor_id'); ?>.png" id="blah" style="width:auto !important;" >
                                        </div>
                                        <div class="col-sm-2">
                                        <span class="pull-left btn btn-default btn-file margin-top-10">
                                            <?php echo translate('select_logo');?>
                                            <input type="file" name="logo" class="form-control" id="imgInp">
                                        </span>
                                        </div>
                                        <div class="col-sm-5"></div>
                                    </div>
                                </div><hr>
                                <div class="form-group margin-top-10">
                                    <label class="col-sm-3 control-label margin-top-10" for="demo-hor-inputemail"><h5>Banner</h5> <br><i>(suggested width:height - 1000px:500px*)</i></label>
                                    <div class="col-sm-9">
                                        <div class="col-sm-12">
                                            <img class="img-responsive img-lg img-border" src="<?php echo base_url(); ?>uploads/vendor/banner_<?php echo $this->session->userdata('vendor_id'); ?>.jpg" id="blahn" style="width:auto !important;">
                                        </div>
                                        <div class="col-sm-6">
                                        <span class="pull-left btn btn-default btn-file margin-top-10">
                                            <?php echo translate('select_banner');?>
                                            <input type="file" name="banner" class="form-control" id="imgInpn">
                                        </span>
                                        </div>
                                        <div class="col-sm-5"></div>
                                    </div>
                                </div>
                                <br />
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form> 
                            </div>              
                        </div>
                    </div>
                
                    <!--UPLOAD : SOCIAL LINKS---------->
                    <div id="demo-stk-lft-tab-4" class="tab-pane fade <?php if($tab_name=="social_links") {?>active in<?php } ?>">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('social_links');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/vendor/social_links/set/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <!--FACEBOOK---------->
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon fb_font">
                                                    <i class="fa fa-facebook-square fa-lg"></i>
                                                </span>
                                                <input type="text" name="facebook" value="<?php echo $this->crud_model->get_type_name_by_id('vendor',$this->session->userdata('vendor_id'),'facebook'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!--G+---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon g_font">
                                                    <i class="fa fa-google-plus-square fa-lg"></i>
                                                </span>
                                                <input type="text" name="google-plus" value="<?php echo $this->crud_model->get_type_name_by_id('vendor',$this->session->userdata('vendor_id'),'google_plus'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!--TWITTER---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon tw_font">
                                                    <i class="fa fa-twitter-square fa-lg"></i>
                                                </span>
                                                <input type="text" name="twitter" value="<?php echo $this->crud_model->get_type_name_by_id('vendor',$this->session->userdata('vendor_id'),'twitter'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!--PINTEREST---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon pin_font">
                                                    <i class="fa fa-pinterest fa-lg"></i>
                                                </span>
                                                <input type="text" name="pinterest" value="<?php echo $this->crud_model->get_type_name_by_id('vendor',$this->session->userdata('vendor_id'),'pinterest'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!--SKYPE---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon skype_font">
                                                    <i class="fa fa-skype fa-lg"></i>
                                                </span>
                                                <input type="text" name="skype" value="<?php echo $this->crud_model->get_type_name_by_id('vendor',$this->session->userdata('vendor_id'),'skype'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!--YOUTUBE---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon youtube_font">
                                                    <i class="fa fa-youtube fa-lg"></i>
                                                </span>
                                                <input type="text" name="youtube" value="<?php echo $this->crud_model->get_type_name_by_id('vendor',$this->session->userdata('vendor_id'),'youtube'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--SAVE---------->
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <!-- START : MANAGE SEO------>
                    <div id="demo-stk-lft-tab-5" class="tab-pane fade">
                         <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading margin-bottom-20">
                                    <h3 class="panel-title">
                                        <?php echo translate('manage_search_engine_optimization');?>
                                    </h3>
                                </div>
                            <?php 
                                $description =  $this->db->get_where('vendor',array('vendor_id' => $this->session->userdata('vendor_id')))->row()->description;
                                $keywords =  $this->db->get_where('vendor',array('vendor_id' => $this->session->userdata('vendor_id')))->row()->keywords;
                            ?>
							<?php
                                echo form_open(base_url() . 'index.php/vendor/seo_settings/set', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                        <?php echo translate('keywords'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="col-sm-">
                                            <input type="text"  data-role="tagsinput" name="keywords" value="<?php echo $keywords; ?>" class="form-control" >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                        <?php echo translate('description'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="col-sm-">
                                            <textarea name="description" class="form-control" rows='8' ><?php echo $description; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                    <?php echo translate('save');?></span>
                                </div>
                            </form>               
                        </div>
                        </div> 
                    </div>
                    <!-- END : MANAGE SEO-->
                    

                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" id="site"></div>
<!-- for logo settings -->
<script>
    function load_logos(){
        ajax_load('<?php echo base_url(); ?>index.php/vendor/logo_settings/show_all','list','');
    }
    function load_dropzone(){
        //$('#dropz').remove();
        //$('#drpzu').append('<div class="col-sm-10" id="dropz"></div>');
        //$('#dropz').load('<?php echo base_url(); ?>index.php/vendor/load_dropzone');
        // DROPZONE.JS
        // =================================================================
        // Require Dropzone
        // http://www.dropzonejs.com/
        // =================================================================
        Dropzone.options.demoDropzone = { // The camelized version of the ID of the form element
            // The configuration we've talked about above
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 25,
            maxFiles: 25,
    
            // The setting up of the dropzone
            init: function() {
                var myDropzone = this;
                this.on("queuecomplete", function (file) {
                    load_logos();
                });
            }
        }
        load_logos();
    }

	$(document).ready(function() {
		
        $('.summernotes').each(function() {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            now.closest('div').append('<input type="hidden" class="val" name="'+n+'">');
            now.summernote({
                height: h,
                onChange: function() {
                    now.closest('div').find('.val').val(now.code());
                }
            });
			now.closest('div').find('.val').val(now.code());
			now.focus();
        });
        load_dropzone();
        load_logos();
		
	});

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#wrap').hide('fast');
                $('#blah').attr('src', e.target.result);
                $('#wrap').show('fast');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });

    function readURLn(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blahn').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpn").change(function(){
        readURLn(this);
    });


    var base_url = '<?php echo base_url(); ?>'
    var user_type = 'vendor';
    var module = 'logo_settings';
    var list_cont_func = 'show_all';
    var dlt_cont_func = 'delete_logo';
</script>
<!-- for logo settings -->



<script type="text/javascript">

    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    });



    $(".range-def").on('slide', function(){
        var vals    = $("#nowslide").val();
        $(this).closest(".form-group").find(".range-def-val").html(vals);
        $(this).closest(".form-group").find("input").val(vals);
    });

    function sets(now){
        $(".range-def").each(function(){
            var min = $(this).data('min');
            var max = $(this).data('max');
            var start = $(this).data('start');
            $(this).noUiSlider({
                start: Number(start) ,
                range: {
                    'min': Number(min),
                    'max': Number(max)
                }
            }, true);
            if(now == 'first'){
                $(this).noUiSlider({
                    start: 500 ,
                    connect : 'lower',
                    range: {
                        'min': 0 ,
                        'max': 10
                    }
                },true).Link('lower').to($("#nowslide"));
                $(this).closest(".form-group").find(".range-def-val").html(start);
                $(this).closest(".form-group").find("input").val(start);
            } else if(now == 'later'){
                var than = $(this).closest(".form-group").find(".range-def-val").html();
                
                if(than !== 'undefined'){
                    $(this).noUiSlider({
                        start: than,
                        connect : 'lower',
                        range: {
                            'min': min ,
                            'max': max
                        }
                    },true).Link('lower').to($("#nowslide"));
                } 
                $(this).closest(".form-group").find(".range-def-val").html(than);
                $(this).closest(".form-group").find("input").val(than);
            }
        });
    }
	$(document).ready(function() {
        sets('later');
		$("form").submit(function(e){
			return false;
		});

	});
</script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js">
</script>
<style>
.img-fixed{
	width: 100px;	
}
.tr-bg{
background-image: url(http://www.mikechambers.com/files/html5/canvas/exportWithBackgroundColor/images/transparent_graphic.png)	
}

.cc-selector input{
    margin:0;padding:0;
    -webkit-appearance:none;
       -moz-appearance:none;
            appearance:none;
}
 
.cc-selector input:active +.drinkcard-cc
{
	opacity: 1;
	border:4px solid #169D4B;
}
.cc-selector input:checked +.drinkcard-cc{
	-webkit-filter: none;
	-moz-filter: none;
	filter: none;
	border:4px solid black;
}
.drinkcard-cc{
	cursor:pointer;
	background-size:contain;
	background-repeat:no-repeat;
	display:inline-block;
	-webkit-transition: all 100ms ease-in;
	-moz-transition: all 100ms ease-in;
	transition: all 100ms ease-in;
	-webkit-filter:opacity(.3);
	-moz-filter:opacity(.3);
	filter:opacity(.3);
	transition: all .6s ease-in-out;
	border:4px solid transparent;
	border-radius:5px !important;
}
.drinkcard-cc:hover{
	-webkit-filter:opacity(1);
	-moz-filter: opacity(1);
	filter:opacity(1);
	transition: all .6s ease-in-out;
	border:4px solid #8400C5;
			
}

</style>

