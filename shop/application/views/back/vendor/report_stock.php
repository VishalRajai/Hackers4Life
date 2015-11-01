 <link rel="stylesheet" href="<?php echo base_url(); ?>template/back/amcharts/style.css"	type="text/css">
<script src="<?php echo base_url(); ?>template/back/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/back/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/back/amcharts/themes/light.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/back/amcharts/amstock.js" type="text/javascript"></script>
<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo translate('manage_product');?></h1>
	</div>
    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <div class="tab-content">
                <!-- LIST -->
                    <div class="tab-pane fade active in" id="" style="border:1px solid #ebebeb; border-radius:4px;">
						<?php
                            echo form_open(base_url() . 'index.php/vendor/report_stock', array(
                                'class' => 'form-horizontal',
                                'method' => 'post',
                                'id' => 'stock_add',
                                'enctype' => 'multipart/form-data'
                            ));
                        ?>
                                                	
                			<div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="demo-hor-inputpass"><?php echo translate('product'); ?></label>
                                    <div class="col-sm-6">
                                        <select name="method" class="demo-chosen-select method">
                                            <option value=""><?php echo translate('select_product'); ?></option>
                                        <?php
                                            $products = $this->db->get('product')->result_array();
                                            foreach ($products as $row) {
                                                if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id'))){
                                        ?>
                                            <option value="<?php echo $row['product_id']; ?>"><?php echo $row['title']; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-7 col-sm-offset-5">
                                        <button class="btn btn-primary btn-lg btn-labeled fa fa-file-text">
                                            <?php echo translate('get_stock_report');?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                         </form>
                        <div class="panel panel-bordered-primary margin-top-10 margin-all-15">
                            <?php if(isset($product)){ ?>
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo translate('stock'); ?>: <?php echo $product_name; ?></h3>
                                </div>
                                <div id="chartdiv"style="width:100%; height:600px;"></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--Panel body-->
        </div>
    </div>
</div>


<script>
	var base_url = '<?php echo base_url(); ?>'
	var user_type = 'vendor';
	var module = 'category';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';
	var loading = '<div>loading...<div>';

	var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "none",
        "pathToImages": "http://www.amcharts.com/lib/3/images/",
        "dataDateFormat": "YYYY-MM-DD",
        "valueAxes": [{
            "id":"v1",
            "axisAlpha": 0,
            "position": "left"
        }],
        "graphs": [{
			"id": "g1",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletSize": 5,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "title": "red line",
            "useLineColorForBulletBorder": true,
            "valueField": "value"
        }],
        "chartScrollbar": {
			"graph": "g1",
			"scrollbarHeight": 30
		},
        "chartCursor": {
            "cursorPosition": "mouse",
            "pan": true,
             "valueLineEnabled":true,
             "valueLineBalloonEnabled":true
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "dashLength": 1,
            "minorGridEnabled": true,
            "position": "top"
        },
        exportConfig:{
          menuRight: '20px',
          menuBottom: '50px',
          menuItems: [{
          icon: 'http://www.amcharts.com/lib/3/images/export.png',
          format: 'png'
          }]  
        },
        "dataProvider": [
            <?php
            	if(isset($product)){
    	        	$stocks = $this->crud_model->stock_report($product);
    	        	foreach ($stocks as $row) {
            ?>
            {
    			"date": "<?php echo $row['date']; ?>",
    			"value": <?php echo $row['stock']; ?>

            	},
            <?php
        			}
            	}
            ?>
            ]
        }
    );

    chart.addListener("rendered", zoomChart);

    zoomChart();
    function zoomChart(){
        chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
    }


    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    });

    function other(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    }
    function get_cat(id){
        $('#brand').html('');
        $('#sub').hide('slow');
        ajax_load(base_url+'index.php/vendor/product/sub_by_cat/'+id,'sub_cat','other');
        $('#sub').show('slow');
        $('#brn').hide('slow');
    }

    function get_sub_res(id){
        $('#brn').hide('slow');
        $('#additional_fields').hide('slow');
        ajax_load(base_url+'index.php/vendor/product/product_by_sub/'+id,'product','other');
        $('#brn').show('slow');
        $('#additional_fields').show('slow');
    }

    function get_pro_res(id){

    }
</script>
