<?php
	foreach($coupon_data as $row){
?>
    <div>
        <?php
			echo form_open(base_url() . 'index.php/admin/coupon/update/' . $row['coupon_id'], array(
				'class' => 'form-horizontal',
				'method' => 'post',
				'id' => 'coupon_edit',
				'enctype' => 'multipart/form-data'
			));
		?>
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('coupon_title');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="title" id="demo-hor-1" value="<?php echo $row['title']; ?>" 
                            placeholder="<?php echo translate('title'); ?>" class="form-control required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('valid_till');?></label>
                    <div class="col-sm-6">
                        <input type="date" name="till" id="demo-hor-1" value="<?php echo $row['till']; ?>" class="form-control">
                    </div>
                </div>
                <?php
                     $spec = json_decode($row['spec'],true);
                ?>                
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo translate('coupon_discount_for');?></label>
                    <div class="col-sm-6">
                        <?php
                            $array = array('all_products','category','sub_category','product');
                            echo $this->crud_model->select_html($array,'set_type','','edit','demo-chosen-select required chos', $spec['set_type']); 
                        ?>
                    </div>
                </div>

                <div class="form-group category" <?php if($spec['set_type'] !== 'category'){ ?>style="display:none;"<?php } ?>>
                    <label class="col-sm-4 control-label"><?php echo translate('category');?></label>
                    <div class="col-sm-6">
                        <?php 
                            if($spec['set_type'] == 'category'){
                                echo $this->crud_model->select_html('category','category','category_name','edit','demo-cs-multiselect', $spec['set']);
                            } else {
                                echo $this->crud_model->select_html('category','category','category_name','add','demo-cs-multiselect');  
                            }
                        ?>
                    </div>
                </div>
                
                <div class="form-group sub_category" <?php if($spec['set_type'] !== 'sub_category'){ ?>style="display:none;"<?php } ?>>
                    <label class="col-sm-4 control-label"><?php echo translate('sub_category');?></label>
                    <div class="col-sm-6">
                        <?php 
                            if($spec['set_type'] == 'sub_category'){
                                echo $this->crud_model->select_html('sub_category','sub_category','sub_category_name','edit','demo-cs-multiselect', $spec['set']);
                            } else {
                                echo $this->crud_model->select_html('sub_category','sub_category','sub_category_name','add','demo-cs-multiselect');  
                            }
                        ?>
                    </div>
                </div>
                
                <div class="form-group product" <?php if($spec['set_type'] !== 'product'){ ?>style="display:none;"<?php } ?>>
                    <label class="col-sm-4 control-label"><?php echo translate('product');?></label>
                    <div class="col-sm-6">
                        <?php 
                            if($spec['set_type'] == 'product'){
                                echo $this->crud_model->select_html('product','product','title','edit','demo-cs-multiselect', $spec['set']);
                            } else {
                                echo $this->crud_model->select_html('product','product','title','add','demo-cs-multiselect');  
                            }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('coupon_code');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="code" id="demo-hor-1"  value="<?php echo $row['code']; ?>"
                            placeholder="<?php echo translate('code'); ?>" class="form-control required">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo translate('discount_type');?></label>
                    <div class="col-sm-6">
                        <?php
                            $array = array('percent','amount');
                            echo $this->crud_model->select_html($array,'discount_type','','edit','demo-chosen-select required',$spec['discount_type']); 
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('discount_value');?></label>
                    <div class="col-sm-6">
                        <input type="number" name="discount_value" id="demo-hor-1"  value="<?php echo $spec['discount_value']; ?>"
                            placeholder="<?php echo translate('discount_value'); ?>" class="form-control required">
                    </div>
                </div>
            </div>
        </form>
    </div>

<?php
	}
?>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>


