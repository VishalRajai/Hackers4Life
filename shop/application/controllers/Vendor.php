<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Vendor extends CI_Controller
{
    /*  
     *  Developed by: Active IT zone
     *  Date    : 14 July, 2015
     *  Active Supershop eCommerce CMS
     *  http://codecanyon.net/user/activeitezone
     */
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('paypal');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->crud_model->ip_data();
		$vendor_system	 =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
		if($vendor_system !== 'ok'){
			redirect(base_url(), 'refresh');
		}
    }
    
    /* index of the vendor. Default: Dashboard; On No Login Session: Back to login page. */
    public function index()
    {
        if ($this->session->userdata('vendor_login') == 'yes') {
            $page_data['page_name'] = "dashboard";
            $this->load->view('back/index', $page_data);
        } else {
            $page_data['control'] = "vendor";
            $this->load->view('back/login',$page_data);
        }
    }
    
    /* Login into vendor panel */
    function login($para1 = '')
    {
        if ($para1 == 'forget_form') {
            $page_data['control'] = 'vendor';
            $this->load->view('back/forget_password',$page_data);
        } else if ($para1 == 'forget') {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');         
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $query = $this->db->get_where('vendor', array(
                    'email' => $this->input->post('email')
                ));
                if ($query->num_rows() > 0) {
                    $vendor_id         = $query->row()->vendor_id;
                    $password         = substr(hash('sha512', rand()), 0, 12);
                    $data['password'] = sha1($password);
                    $this->db->where('vendor_id', $vendor_id);
                    $this->db->update('vendor', $data);
                    if ($this->email_model->password_reset_email('vendor', $vendor_id, $password)) {
                        echo 'email_sent';
                    } else {
                        echo 'email_not_sent';
                    }
                } else {
                    echo 'email_nay';
                }
            }
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $login_data = $this->db->get_where('vendor', array(
                    'email' => $this->input->post('email'),
                    'password' => sha1($this->input->post('password'))
                ));
                if ($login_data->num_rows() > 0) {
                    if($login_data->row()->status == 'approved'){
                        foreach ($login_data->result_array() as $row) {
                            $this->session->set_userdata('login', 'yes');
                            $this->session->set_userdata('vendor_login', 'yes');
                            $this->session->set_userdata('vendor_id', $row['vendor_id']);
                            $this->session->set_userdata('vendor_name', $row['display_name']);
                            $this->session->set_userdata('title', 'vendor');
                            echo 'lets_login';
                        }
                    } else {
                        echo 'unapproved';
                    }
                } else {
                    echo 'login_failed';
                }
            }
        }
    }
    
    
    /* Loging out from vendor panel */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/vendor', 'refresh');
    }
    
    /*Product coupon add, edit, view, delete */
    function coupon($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('coupon')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == 'do_add') {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $data['spec'] = json_encode(array(
                                'set_type'=>'product',
                                'set'=>json_encode($this->input->post('product')),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->insert('coupon', $data);
        } else if ($para1 == 'edit') {
            $page_data['coupon_data'] = $this->db->get_where('coupon', array(
                'coupon_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/coupon_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['spec'] = json_encode(array(
                                'set_type'=>'product',
                                'set'=>json_encode($this->input->post('product')),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->where('coupon_id', $para2);
            $this->db->update('coupon', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('coupon_id', $para2);
            $this->db->delete('coupon');
        } elseif ($para1 == 'list') {
            $this->db->order_by('coupon_id', 'desc');
            $page_data['all_coupons'] = $this->db->get('coupon')->result_array();
            $this->load->view('back/vendor/coupon_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/coupon_add');
        } elseif ($para1 == 'publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('coupon_id', $product);
            $this->db->update('coupon', $data);
        } else {
            $page_data['page_name']      = "coupon";
            $page_data['all_coupons'] = $this->db->get('coupon')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Sale Comparison Reports*/
    function report($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'index.php/vendor');
        }
        $page_data['page_name'] = "report";
        $page_data['products']  = $this->db->get('product')->result_array();
        $this->load->view('back/index', $page_data);
    }
    
    /*Product Stock Comparison Reports*/
    function report_stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'index.php/vendor');
        }
        $page_data['page_name'] = "report_stock";
        if ($this->input->post('product')) {
            $page_data['product_name'] = $this->crud_model->get_type_name_by_id('product', $this->input->post('product'), 'title');
            $page_data['product']      = $this->input->post('product');
        }
        $this->load->view('back/index', $page_data);
    }
    
    /*Product Wish Comparison Reports*/
    function report_wish($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'index.php/vendor');
        }
        $page_data['page_name'] = "report_wish";
        $this->load->view('back/index', $page_data);
    }
    
    /* Product add, edit, view, delete, stock increase, decrease, discount */
    function product($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('product')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == 'do_add') {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            $data['add_timestamp']      = time();
            $data['featured']           = '0';
            $data['status']             = 'ok';
            $data['rating_user']        = '[]';
            $data['tax']                = $this->input->post('tax');
            $data['discount']           = $this->input->post('discount');
            $data['discount_type']      = $this->input->post('discount_type');
            $data['tax_type']           = $this->input->post('tax_type');
            $data['shipping_cost']      = $this->input->post('shipping_cost');
            $data['tag']                = $this->input->post('tag');
            $data['color']              = json_encode($this->input->post('color'));
            $data['num_of_imgs']        = $num_of_imgs;
            $data['current_stock']      = $this->input->post('current_stock');
            $data['front_image']        = $this->input->post('front_image');
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            $data['brand']              = $this->input->post('brand');
            $data['unit']               = $this->input->post('unit');
            $data['added_by']           = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
			if(count($choice_titles ) > 0){
				foreach ($choice_titles as $i => $row) {
					$choice_options         = $this->input->post('op_set'.$choice_no[$i]);
					$options[]              =   array(
													'no' => $choice_no[$i],
													'title' => $choice_titles[$i],
													'name' => 'choice_'.$choice_no[$i],
													'type' => $choice_types[$i],
													'option' => $choice_options
												);
				}
			}
            $data['options']            = json_encode($options);
            if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))){
                $this->db->insert('product', $data);
                $id = $this->db->insert_id();
                $this->crud_model->file_up("images", "product", $id, 'multi');
            } else {
                echo 'already uploaded maximum product';
            }
        } else if ($para1 == "update") {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            $data['featured']           = $this->input->post('featured');
            $data['tax']                = $this->input->post('tax');
            $data['discount']           = $this->input->post('discount');
            $data['discount_type']      = $this->input->post('discount_type');
            $data['tax_type']           = $this->input->post('tax_type');
            $data['shipping_cost']      = $this->input->post('shipping_cost');
            $data['tag']                = $this->input->post('tag');
            $data['color']              = json_encode($this->input->post('color'));
            $data['num_of_imgs']        = $num + $num_of_imgs;
            $data['front_image']        = $this->input->post('front_image');
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            $data['brand']              = $this->input->post('brand');
            $data['unit']               = $this->input->post('unit');
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
			if(count($choice_titles ) > 0){
				foreach ($choice_titles as $i => $row) {
					$choice_options         = $this->input->post('op_set'.$choice_no[$i]);
					$options[]              =   array(
													'no' => $choice_no[$i],
													'title' => $choice_titles[$i],
													'name' => 'choice_'.$choice_no[$i],
													'type' => $choice_types[$i],
													'option' => $choice_options
												);
				}
			}
            $data['options']            = json_encode($options);
            $this->crud_model->file_up("images", "product", $para2, 'multi');
            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
        } else if ($para1 == 'edit') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_edit', $page_data);
        } else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_view', $page_data);
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
        } elseif ($para1 == 'list') {
            $this->db->order_by('product_id', 'desc');
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/vendor/product_list', $page_data);
        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
        } elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, 'get_sub_res');
        } elseif ($para1 == 'brand_by_cat') {
            echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select', '', 'category', $para2, '');
        } elseif ($para1 == 'product_by_sub') {
            echo $this->crud_model->select_html('product', 'product', 'title', 'add', 'demo-chosen-select required', '', 'sub_category', $para2, 'get_pro_res');
        } elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        } elseif ($para1 == 'add') {
            if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))){
                $this->load->view('back/vendor/product_add');
            } else {
                $this->load->view('back/vendor/product_limit');
            }
        } elseif ($para1 == 'add_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_add', $data);
        } elseif ($para1 == 'destroy_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_destroy', $data);
        } elseif ($para1 == 'stock_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_report', $data);
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_sale_report', $data);
        } elseif ($para1 == 'add_discount') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_add_discount', $data);
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $this->crud_model->set_product_publishability($this->session->userdata('vendor_id'),$product);
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        } elseif ($para1 == 'add_discount_set') {
            $product               = $this->input->post('product');
            $data['discount']      = $this->input->post('discount');
            $data['discount_type'] = $this->input->post('discount_type');
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        } else {
            $page_data['page_name']   = "product";
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Product Stock add, edit, view, delete, stock increase, decrease, discount */
    function stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('stock')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == 'do_add') {
            $data['type']         = 'add';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['rate']         = $this->input->post('rate');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['added_by']     = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity          = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $data1['current_stock'] = $prev_quantity + $data['quantity'];
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
        } else if ($para1 == 'do_destroy') {
            $data['type']         = 'destroy';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['added_by']     = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $current       = $prev_quantity - $data['quantity'];
            if ($current <= 0) {
                $current = 0;
            }
            $data1['current_stock'] = $current;
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
        } elseif ($para1 == 'delete') {
            $quantity = $this->crud_model->get_type_name_by_id('stock', $para2, 'quantity');
            $product  = $this->crud_model->get_type_name_by_id('stock', $para2, 'product');
            $type     = $this->crud_model->get_type_name_by_id('stock', $para2, 'type');
            if ($type == 'add') {
                $this->crud_model->decrease_quantity($product, $quantity);
            } else if ($type == 'destroy') {
                $this->crud_model->increase_quantity($product, $quantity);
            }
            $this->db->where('stock_id', $para2);
            $this->db->delete('stock');
        } elseif ($para1 == 'list') {
            $this->db->order_by('stock_id', 'desc');
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/vendor/stock_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/stock_add');
        } elseif ($para1 == 'destroy') {
            $this->load->view('back/vendor/stock_destroy');
        } else {
            $page_data['page_name'] = "stock";
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Managing sales by users */
    function sales($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('sale')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == 'delete') {
            $carted = $this->db->get_where('stock', array(
                'sale_id' => $para2
            ))->result_array();
            foreach ($carted as $row2) {
                $this->stock('delete', $row2['stock_id']);
            }
            $this->db->where('sale_id', $para2);
            $this->db->delete('sale');
        } elseif ($para1 == 'list') {
            $all = $this->db->get_where('sale',array('payment_type' => 'go'))->result_array();
            foreach ($all as $row) {
                if((time()-$row['sale_datetime']) > 600){
                    $this->db->where('sale_id', $row['sale_id']);
                    $this->db->delete('sale');
                }
            }
            $this->db->order_by('sale_id', 'desc');
            $page_data['all_sales'] = $this->db->get('sale')->result_array();
            $this->load->view('back/vendor/sales_list', $page_data);
        } elseif ($para1 == 'view') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/sales_view', $page_data);
        } elseif ($para1 == 'send_invoice') {
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $text              = $this->load->view('back/includes_top', $page_data);
            $text .= $this->load->view('back/vendor/sales_view', $page_data);
            $text .= $this->load->view('back/includes_bottom', $page_data);
        } elseif ($para1 == 'delivery_payment') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale_id']         = $para2;
            $page_data['payment_type']    = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_type;
            $page_data['payment_details'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_details;
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            foreach ($delivery_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $page_data['delivery_status'] = $row['status'];
                    }
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            foreach ($payment_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $page_data['payment_status'] = $row['status'];
                    }
                }
            }
            
            $this->load->view('back/vendor/sales_delivery_payment', $page_data);
        } elseif ($para1 == 'delivery_payment_set') {
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            $new_delivery_status = array();
            foreach ($delivery_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$this->input->post('delivery_status'),'delivery_time'=>$row['delivery_time']);
                    } else {
                        $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status'],'delivery_time'=>$row['delivery_time']);
                    }
                }
                else if(isset($row['admin'])){
                    $new_delivery_status[] = array('admin'=>'','status'=>$row['status'],'delivery_time'=>$row['delivery_time']);
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            $new_payment_status = array();
            foreach ($payment_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$this->input->post('payment_status'));
                    } else {
                        $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status']);
                    }
                }
                else if(isset($row['admin'])){
                    $new_payment_status[] = array('admin'=>'','status'=>$row['status']);
                }
            }
            var_dump($new_payment_status);
            $data['payment_status']  = json_encode($new_payment_status);
            $data['delivery_status'] = json_encode($new_delivery_status);
            $data['payment_details'] = $this->input->post('payment_details');
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/sales_add');
        } elseif ($para1 == 'total') {
            $sales = $this->db->get('sale')->result_array();
			$i = 0;
			foreach($sales as $row){
				if($this->crud_model->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id'))){
					$i++;
				}
			}
			echo $i;
        } else {
            $page_data['page_name']      = "sales";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Checking Login Stat */
    function is_logged()
    {
        if ($this->session->userdata('vendor_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
    
    /* Manage Site Settings */
    function site_settings($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }
        $page_data['page_name'] = "site_settings";
        $page_data['tab_name']  = $para1;
        $this->load->view('back/index', $page_data);
    }
    

    /* Manage Business Settings */
    function package($para1 = "", $para2 = "")
    {
        if ($para1 == 'upgrade') {
            $method         = $this->input->post('method');
            $type           = $this->input->post('membership');
            $vendor         = $this->session->userdata('vendor_id');
            if($type !== '0'){
                $amount         = $this->db->get_where('membership',array('membership_id'=>$type))->row()->price;
                $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
                if ($method == 'paypal') {

                    $paypal_email           = $this->db->get_where('business_settings',array('type'=>'paypal_email'))->row()->value;
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'paypal';
                    $data['membership']     = $type; 
                    $data['timestamp']      = time();

                    $this->db->insert('membership_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);
                    
                    /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_xclick');
                    
                    $this->paypal->add_field('amount', $this->cart->format_number($amount_in_usd));

                    //$this->paypal->add_field('amount', $grand_total);
                    $this->paypal->add_field('custom', $invoice_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/vendor/paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/vendor/paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/vendor/paypal_success');
                    
                    $this->paypal->submit_paypal_post();
                    // submit the fields to paypal

                } else if ($method == 'stripe') {
                    if($this->input->post('stripeToken')) {
                        
                        $stripe_api_key = $this->db->get_where('business_settings' , array('type' => 'stripe_secret'))->row()->value;
                        require_once(APPPATH . 'libraries/stripe-php/init.php');
                        \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                        $vendor_email = $this->db->get_where('vendor' , array('vendor_id' => $vendor))->row()->email;
                        
                        $vendora = \Stripe\Customer::create(array(
                            'email' => $vendor_email, // customer email id
                            'card'  => $_POST['stripeToken']
                        ));

                        $charge = \Stripe\Charge::create(array(
                            'customer'  => $vendora->id,
                            'amount'    => ceil($amount_in_usd*100),
                            'currency'  => 'USD'
                        ));

                        if($charge->paid == true){
                            $vendora = (array) $vendora;
                            $charge = (array) $charge;
                            
                            $data['vendor']         = $vendor;
                            $data['amount']         = $amount;
                            $data['status']         = 'paid';
                            $data['method']         = 'stripe';
                            $data['timestamp']      = time();
                            $data['membership']     = $type;
                            $data['details']        = "Customer Info: \n".json_encode($vendora,true)."\n \n Charge Info: \n".json_encode($charge,true);
                            
                            $this->db->insert('membership_payment', $data);
                            $this->crud_model->upgrade_membership($vendor,$type);
                            redirect(base_url() . 'index.php/vendor/package/', 'refresh');
                        } else {
                            $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                            redirect(base_url() . 'index.php/vendor/package/', 'refresh');
                        }
                        
                    } else{
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'index.php/vendor/package/', 'refresh');
                    }
                } else if ($method == 'cash') {
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'cash';
                    $data['timestamp']      = time();
                    $data['membership']     = $type;
                    $this->db->insert('membership_payment', $data);
                    redirect(base_url() . 'index.php/vendor/package/', 'refresh');
                } else {
                    echo 'putu';
                }
            } else {
                redirect(base_url() . 'index.php/vendor/package/', 'refresh');
            }
        } else {
            $page_data['page_name'] = "package";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {
            
            $data['status']         = 'paid';
            $data['details']        = json_encode($_POST);
            $invoice_id             = $_POST['custom'];
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data);
            $type = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->membership;
            $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->vendor;
            $this->crud_model->upgrade_membership($vendor,$type);
        }
    }
    

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('membership_payment_id', $invoice_id);
        $this->db->delete('membership_payment');
        $this->session->set_userdata('invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/admin/package/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $this->session->set_userdata('invoice_id', '');
        redirect(base_url() . 'index.php/vendor/package/', 'refresh');
    }
    

    /* Manage Business Settings */
    function business_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->vendor_permission('business_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == "cash_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'cash_set' => $val
            ));
        }
        else if ($para1 == "paypal_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'paypal_set' => $val
            ));
        }
        else if ($para1 == "stripe_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'stripe_set' => $val
            ));
        }
        else if ($para1 == "membership_price") {
            echo $this->db->get_where('membership',array('membership_id'=>$para2))->row()->price;
        }
        else if ($para1 == "membership_info") {
            $return = '<div class="table-responsive"><table class="table table-striped">';
            if($para2 !== '0'){
                $results = $this->db->get_where('membership',array('membership_id'=>$para2))->result_array();
                foreach ($results as $row) {
                    $return .= '<tr>';
                    $return .= '<td>'.translate('title').'</td>';
                    $return .= '<td>'.$row['title'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('price').'</td>';
                    $return .= '<td>'.currency().$row['price'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('timespan').'</td>';
                    $return .= '<td>'.$row['timespan'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('maximum_product').'</td>';
                    $return .= '<td>'.$row['product_limit'].'</td>';
                    $return .= '</tr>';
                }
            } else if($para2 == '0'){
                $return .= '<tr>';
                $return .= '<td>'.translate('title').'</td>';
                $return .= '<td>'.translate('default').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('price').'</td>';
                $return .= '<td>'.translate('free').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('timespan').'</td>';
                $return .= '<td>'.translate('lifetime').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('maximum_product').'</td>';
                $return .= '<td>'.$this->db->get_where('general_settings',array('type'=>'default_member_product_limit'))->row()->value.'</td>';
                $return .= '</tr>';
            }
            $return .= '</table></div>';
            echo $return;
        }
        else if ($para1 == 'set') {
            $publishable    = $this->input->post('stripe_publishable');
            $secret         = $this->input->post('stripe_secret');
            $stripe         = json_encode(array('publishable'=>$publishable,'secret'=>$secret));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'paypal_email' => $this->input->post('paypal_email')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'stripe_details' => $stripe
            ));
        } else {
            $page_data['page_name'] = "business_settings";
            $this->load->view('back/index', $page_data);
        }
    }
    

    /* Manage vendor Settings */
    function manage_vendor($para1 = "")
    {
        if ($this->session->userdata('vendor_login') != 'yes') {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == 'update_password') {
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('vendor', array(
                'vendor_id' => $this->session->userdata('vendor_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
                        $this->db->update('vendor', $data);
                        echo 'updated';
                    }
                } else {
                    echo 'pass_prb';
                }
            }
        } else if ($para1 == 'update_profile') {
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'company' => $this->input->post('company'),
                'display_name' => $this->input->post('display_name'),
                'details' => $this->input->post('details'),
                'phone' => $this->input->post('phone')
            ));
        } else {
            $page_data['page_name'] = "manage_vendor";
            $this->load->view('back/index', $page_data);
        }
    }

    /* Manage General Settings */
    function general_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }

    }
    
    /* Manage Social Links */
    function social_links($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == "set") {

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'facebook' => $this->input->post('facebook')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'google_plus' => $this->input->post('google-plus')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'twitter' => $this->input->post('twitter')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'skype' => $this->input->post('skype')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'pinterest' => $this->input->post('pinterest')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'youtube' => $this->input->post('youtube')
            ));

            redirect(base_url() . 'index.php/vendor/site_settings/social_links/', 'refresh');
        }
    }

    /* Manage SEO relateds */
    function seo_settings($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == "set") {
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'description' => $this->input->post('description')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'keywords' => $this->input->post('keywords')
            ));
        }
    }
    /* Manage Favicons */
    function vendor_images($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }
        move_uploaded_file($_FILES["logo"]['tmp_name'], 'uploads/vendor/logo_' . $this->session->userdata('vendor_id') . '.png');
        move_uploaded_file($_FILES["banner"]['tmp_name'], 'uploads/vendor/banner_' . $this->session->userdata('vendor_id') . '.jpg');
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */