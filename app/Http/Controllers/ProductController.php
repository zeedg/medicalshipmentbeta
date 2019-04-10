<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\products;
use App\product_types;
use App\attributes_set;
use App\unit_product;
use App\product_images;
use DB;
use File;

//use Illuminate\Routing\Route;
//use 
use Illuminate\Support\Facades\Route;
use App\ProductAttribute;

class ProductController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		//
		// $products = products::orderBy('product_id','asc')->paginate('15');
		
		$products = DB::table('product')->leftjoin('category', 'product.category_id', '=', 'category.category_id')->leftjoin('product_type', 'product.pt_id', '=', 'product_type.pt_id')->select('product.product_id', 'product.category_id', 'category.category_title', 'product.pt_id', 'product.product_title', 'product.product_sort_order', 'product.product_item_no', 'product.product_featured', 'product_type.pt_name', 'product.product_sort_order')->orderBy('product_id', 'asc')->paginate('15');
		return view('listProducts', ['products' => $products]);
	}
	
	function add(Request $request){
		
		
		if($_POST){
			$validator = Validator::make($request->all(), [
			 
			 'parent'                => 'required|max:100',
			 'manufacturer'          => 'required|max:100',
			 'title'                 => 'required|max:100',
			 'slug'                  => 'required|max:100',
			 'attribute'             => 'max:100',
			 'attribute_item'        => 'max:100',
			 'unit_price'            => 'integer|required|max:100',
			 'unit_7'                => 'max:100',
			 'special_7'             => 'max:100',
			 'unit_id'               => 'max:100',
			 'dropship'              => 'max:100',
			 'out_of_stock'          => 'max:100',
			 'product_business_rule' => 'max:100',
			 'product_mix_class_id'  => 'max:100',
			 'package'               => 'max:100',
			 'weight'                => 'integer|max:100',
			 'item_no'               => 'max:100',
			 'size'                  => 'max:100',
			 'width'                 => 'max:100',
			 'height'                => 'max:100',
			 'length'                => 'max:100',
			 'sdetail'               => 'max:100',
			 'detail'                => 'max:100',
			 'featured'              => 'max:100',
			 'add_category'          => 'max:100'
			
			]);
			if($validator->fails()) return back()->withErrors($validator)->withInput();
			
			$config = 0;
			$pt_id = 1;
			if($config != 0){
				$pt_id = 1;
			}
			if(isset($_POST[ 'dropship' ])){
				$product_dropship = 1;
			}else{
				$product_dropship = 0;
			}
			if(isset($_POST[ 'freeship' ])){
				$product_freeship = 1;
			}else{
				$product_freeship = 0;
			}
			if(isset($_POST[ 'out_of_stock' ])){
				$product_out_of_stock = 1;
			}else{
				$product_out_of_stock = 0;
			}
			if(isset($_POST[ 'bundle' ])){
				$product_bundle = 1;
			}else{
				$product_bundle = 0;
			}
			
			$product_mix_class_id = $_POST[ 'product_mix_class_id' ];
			$date = date('Y-m-d H:i:s');
			
			$images = [];
			if($files = Input::file('image')){
				foreach($files as $file){
					$path = 'uploads/product/';
					$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
					$file->move($path, $file_name);
					$arrImageValue[] = $file_name;
				}
			}
			
			$file_pdf = Input::file('pdf');
			$path_pdf = 'uploads/product/';
			$file_name_pdf = rand(1, 1000000).'_'.$file_pdf->getClientOriginalName();
			$file_pdf->move($path_pdf, $file_name_pdf);
			$product_pdf = $file_name_pdf;
			
			$file_video = Input::file('video');
			$path_video = 'uploads/product/';
			$file_name_video = rand(1, 1000000).'_'.$file_video->getClientOriginalName();
			$file_video->move($path_video, $file_name_video);
			$product_video = $file_name_video;
			
			DB::insert("insert into product(pt_id,product_config_parent,as_id,category_id,product_position,product_hero,manu_id,product_title,product_slug,product_business_rule,product_package,product_weight,product_item_no,product_size,product_width,product_height,product_length,product_sdetail,product_sort_order,product_detail,product_pdf,product_video,product_featured,product_dropship,product_freeship,product_out_of_stock,product_bundle,product_mix_class_id,product_verified,product_date) values(?, ? ,? ,? ,? ,? ,?, ? ,? ,? ,? ,? ,?, ? ,? ,? ,? ,? ,?, ? ,? ,? ,? ,? ,?, ? ,?, ?, ?, ?)", [$pt_id,
			 $config,
			 0,
			 intval($_POST[ 'parent' ]),
			 intval($_POST[ 'manufacturer' ]),
			 0,
			 0,
			 trim($_POST[ 'title' ]),
			 trim($_POST[ 'slug' ]),
			 trim($_POST[ 'product_business_rule' ]),
			 trim($_POST[ 'package' ]),
			 trim($_POST[ 'weight' ]),
			 trim($_POST[ 'item_no' ]),
			 trim($_POST[ 'size' ]),
			 trim($_POST[ 'width' ]),
			 trim($_POST[ 'height' ]),
			 trim($_POST[ 'length' ]),
			 trim($_POST[ 'sdetail' ]),
			 0,
			 $_POST[ 'detail' ],
			 $product_pdf,
			 $product_video,
			 trim($_POST[ 'featured' ]),
			 trim($product_dropship),
			 trim($product_freeship),
			 trim($product_out_of_stock),
			 trim($product_bundle),
			 trim($product_mix_class_id),
			 0,
			 trim($date)]);
			
			$response = DB::getPdo()->lastInsertId();
			
			# Product Attribute Code november-2017 By kaleem
			$this->insertAttributeSet($response);
			
			# insert product images
			if($response){
				$this->uploadImage($arrImageValue, $response);
				
				# insert unit WHEN Product Type is Simple
				if(isset($_POST[ 'unit_id' ]) && trim($_POST[ 'unit_id' ]) != ''){
					$unit_id = explode(',', trim($_POST[ 'unit_id' ]));
					foreach($unit_id as $value){
						if(trim($value) != ''){
							DB::insert("insert into unit_product(unit_id,product_id,product_price,product_sprice) values(?, ?, ?, ?)", [intval($value), $response, trim($_POST[ 'unit_'.$value ]), trim($_POST[ 'special_'.$value ])]);
						}
					}
				}
				
				//CHECK THIS I THINK ITS FOR CONFIGUREABLE PRODUCTS
				//$query=$this->checkPostAttribute();
				
				return redirect()->to('product');
			}
		}
		
		$arrValue[ 'tree' ] = $this->fetchCategoryTree();
		
		# Manufacturer
		$arrValue[ 'manufacturer' ] = DB::select("SELECT * FROM manufacturer ORDER BY manu_id ASC");
		
		# Get Business Rules
		$arrValue[ 'rules' ] = DB::select("SELECT * FROM business_rules ORDER BY id ASC");
		
		$arrValue[ 'mix_class_qty' ] = DB::select("SELECT * FROM mix_class_qty ORDER BY id ASC");
		
		# Units
		$arrValue[ 'unit' ] = DB::select("SELECT * FROM unit ORDER BY unit_id ASC");
		
		# Product Type
		$arrValue[ 'product_type' ] = DB::select("SELECT * FROM product_type WHERE 1 AND `pt_id` = 1 ORDER BY pt_id ASC");
		
		# Attribute Set
		//$arrValue['attribute_set']=$this->getAttributeSet();
		
		$array = [];
		# Product Attribute
		
		# Get Attribute
		$arrValue[ 'attribute' ] = DB::select("SELECT * FROM attribute ORDER BY attribute_name ASC");
		
		return view('addProduct', ['arrValue' => $arrValue]);
	}
	
	function checkPostAttribute(){
		if(isset($_SESSION[ 'attribute' ]) && !empty($_SESSION[ 'attribute' ])){
			$sql = "SELECT * FROM config_product where cp_id IN (".implode(',', $_SESSION[ 'attribute' ]).")";
			$query = mysql_query($sql);
			$rows = mysql_num_rows($query);
			if($rows > 0){
				return $query;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	function insertAttributeSet($pid){
		//mysql_query("delete from product_item where product_id=".$pid);
		DB::table('product_item')->where('product_id', '=', $pid)->delete();
		if(isset($_POST[ 'attr_set' ]) && !empty($_POST[ 'attr_set' ])){
			foreach($_POST[ 'attr_set' ] as $val){
				$attr = explode('_', $val);
				$attr_id = $attr[ 0 ];
				$attr_item_id = $attr[ 1 ];
				$date = date('Y-m-d H:i:s');
				DB::insert("insert into product_item(product_id,attribute_id,attribute_item_id,pi_date) values(?, ?, ?, ?)", [$pid, $attr_id, $attr_item_id, $date]);
			}
		}
	}
	
	function uploadImage($arrValue, $product_id){
		foreach($arrValue as $value){
			if(!empty($value)){
				DB::insert("insert into product_image(product_id,product_image) values(?, ?)", [$product_id, trim($value)]);
			}
		}
	}
	
	function getAttributeItem($attr_id){
		if(isset($attr_id)){
			$id = $attr_id;
			//$q=mysql_query("select * from attribute_item where attribute_id='".$id."' order by attribute_item_id asc");
			//$num_attr_item='('.mysql_num_rows($q).')';
			$attribute_items = DB::select("select * from attribute_item where attribute_id='".$id."' order by attribute_item_id asc");
			$str = '<option value="">Select...</option>';
			//while($m=mysql_fetch_assoc($q)){
			$i = 0;
			foreach($attribute_items as $attribute_item){
				$i = $i+1;
				$name_ = trim(stripslashes($attribute_item->attribute_item_name));
				$id_ = $attribute_item->attribute_item_id;
				$str .= '<option value='.$id_.'>'.$name_.'</option>';
			}
			$num_attr_item = '('.$i.')';
			echo $str;
		}
	}
	
	public function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = ''){
		
		if(!is_array($user_tree_array)) $user_tree_array = [];
		
		$categories = DB::select("SELECT * FROM `category` WHERE 1 AND `category_parent` = $parent ORDER BY category_id ASC");
		foreach($categories as $row){
			$user_tree_array[] = ["category_id" => $row->category_id, "category_title" => $spacing.$row->category_title];
			$user_tree_array = $this->fetchCategoryTree($row->category_id, $spacing.'&nbsp;&nbsp;', $user_tree_array);
		}
		
		return $user_tree_array;
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		//
		$product_types = product_types::orderBy('pt_id', 'asc')->paginate('15');
		$attributes_set = attributes_set::orderBy('as_id', 'asc')->paginate('15');
		return view('addProduct', ['product_types' => $product_types, 'attributes_set' => $attributes_set]);
	}
	
	function getAttributeSet(){
		
		$attribute_sets = DB::select("select * from attribute_set order by as_name ASC");
		
		$str = "<div class='col-md-6'>";
		$str .= "<select class='form-control' name='attribute_set' onChange='getAttributeList(this.value)'>";
		$str .= "<option value>Choose Attribute Set</option>";
		
		foreach($attribute_sets as $attribute_set){
			$str .= "<option value=".$attribute_set->as_id.">".trim(stripslashes($attribute_set->as_name))."</option>";
		}
		$str .= "</select>";
		$str .= "</div>";
		echo $str;
	}
	
	function getAttributeList($as_id, $ptype){
		
		$as_id = intval($as_id);
		$ptype = intval($ptype); # just use for configuarable products
		$and = "";
		if($ptype == 2){
			$and = " AND cp.cp_product_type=2";
		}
		
		$attribute_lists = DB::select("select * from config_product cp inner join attribute_set_option aso on cp.cp_id=aso.cp_id where aso.as_id=$as_id $and order by cp.cp_code ASC");
		
		$str = "<div class='col-md-6'>";
		$str .= "<select multiple class='form-control' name='attribute[]' required>";
		foreach($attribute_lists as $attribute_list){
			$str .= "<option value=".$attribute_list->cp_id.">".trim(stripslashes($attribute_list->cp_code))."</option>";
		}
		$str .= "</select>";
		$str .= "</div>";
		echo $str;
	}
	
	function productType(){
		
		
		if($_POST){
			
			if(isset($_SESSION[ 'product_type' ])){
				unset($_SESSION[ 'product_type' ]);
			}
			if(isset($_SESSION[ 'attribute_set' ])){
				unset($_SESSION[ 'attribute_set' ]);
			}
			if(isset($_SESSION[ 'attribute' ])){
				unset($_SESSION[ 'attribute' ]);
			}
			
			if(isset($_POST[ 'product_type' ])){
				$_SESSION[ 'product_type' ] = intval($_POST[ 'product_type' ]);
			}
			if(isset($_POST[ 'attribute_set' ])){
				$_SESSION[ 'attribute_set' ] = intval($_POST[ 'attribute_set' ]);
			}
			if(isset($_POST[ 'attribute' ])){
				$_SESSION[ 'attribute' ] = $_POST[ 'attribute' ];
			}
			
			return redirect()->to('addattributes');
		}else{
			
			loadView('header.php');
			loadView('sidebar.php');
			
			# Get Product Type List
			$arrArgument[ 'table' ] = 'product_type';
			$where = [];
			$arrArgument[ 'where' ] = $where;
			$arrArgument[ 'operator' ] = '';
			$arrArgument[ 'order' ] = 'pt_id ASC';
			$arrValue[ 'productType' ] = loadModel('amsco', 'getRecord', $arrArgument);
			
			loadView('product-type.php', $arrValue);
			loadView('footer.php');
		}
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		//
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}
	
	public function edit($id){
		
		if(isset($id) && ($_GET[ 'action' ] == 'edit_price')){
			
			$products = DB::table('product')->leftjoin('unit_product', 'product.product_id', '=', 'unit_product.product_id')->select('product.product_id', 'unit_product.product_price', 'product.product_title', 'product.product_item_no', 'unit_product.product_sprice')->where('product.product_id', $id)->get();
			return view('editProductPrice', ['products' => $products]);
		}else{
			//			$products = DB::table('product')->leftjoin('unit_product', 'product.product_id', '=', 'unit_product.product_id')->select('product.*', 'unit_product.product_price', 'unit_product.product_sprice')->where('product.product_id', $id)->get();
			//			
			//			$categories = DB::table('category')->distinct('category_title')->select()->orderBy('category_title', 'asc')->get();
			//			
			//			$manufacturers = DB::table('manufacturer')->distinct('manu_title')->select()->orderBy('manu_title', 'asc')->get();
			//			
			//			$attributes = DB::table('attribute')->distinct('attribute_name')->select()->orderBy('attribute_name', 'asc')->get();
			//			
			//			$business_rules = DB::table('business_rules')->distinct('rule_name')->select()->orderBy('rule_code', 'asc')->get();
			//			
			//			$attribute_items = DB::table('attribute_item')->select('attribute_item.*')->distinct('attribute_item_name')->orderBy('attribute_item_name', 'asc')->get();
			//			
			//			$pro_images = DB::table('product_image')->where('product_id', $id)->orderBy('pi_id', 'asc')->get();
			//			
			//			$product_items = DB::table('product_item')->leftjoin('attribute', 'product_item.attribute_id', '=', 'attribute.attribute_id')->leftjoin('attribute_item', 'product_item.attribute_item_id', '=', 'attribute_item.attribute_item_id')->select('product_item.*', 'attribute_item.attribute_item_name', 'attribute_item.attribute_item_id', 'attribute.attribute_name', 'attribute.attribute_id')->where('product_item.product_id', $id)->orderBy('product_item.pi_id', 'asc')->get();
			//			
			//			$attributes = DB::select("SELECT * FROM attribute ORDER BY attribute_name ASC");
			//			
			//			/*@reset(explode('?' , @end(explode('/edit/' , url()->full())))) */
			//			return view('editProductDetail', ['products' => $products, 'categories' => $categories, 'manufacturers' => $manufacturers, 'attributes' => $attributes, 'business_rules' => $business_rules, 'attribute_items' => $attribute_items, 'attributes' => $attributes, 'pro_images' => $pro_images, 'product_items' => $product_items]);
			$products = DB::table('product')->leftjoin('unit_product', 'product.product_id', '=', 'unit_product.product_id')->select('product.*', 'unit_product.product_price', 'unit_product.product_sprice')->where('product.product_id', $id)->get();
			
			$categories = DB::table('category')->distinct('category_title')->select()->orderBy('category_title', 'asc')->get();
			
			$manufacturers = DB::table('manufacturer')->distinct('manu_title')->select()->orderBy('manu_title', 'asc')->get();
			
			$attributes = DB::table('attribute')->distinct('attribute_name')->select()->orderBy('attribute_name', 'asc')->get();
			
			$business_rules = DB::table('business_rules')->distinct('rule_name')->select()->orderBy('rule_code', 'asc')->get();
			
			$attribute_items = DB::table('attribute_item')->select('attribute_item.*')->distinct('attribute_item_name')->orderBy('attribute_item_name', 'asc')->get();
			
			$pro_images = DB::table('product_image')->where('product_id', $id)->orderBy('pi_id', 'asc')->get();
			
			$product_items = DB::table('product_item')->leftjoin('attribute', 'product_item.attribute_id', '=', 'attribute.attribute_id')->leftjoin('attribute_item', 'product_item.attribute_item_id', '=', 'attribute_item.attribute_item_id')->select('product_item.*', 'attribute_item.attribute_item_name', 'attribute_item.attribute_item_id', 'attribute.attribute_name', 'attribute.attribute_id')->where('product_item.product_id', $id)->orderBy('product_item.pi_id', 'asc')->get();
			
			$attributes = DB::select("SELECT * FROM attribute ORDER BY attribute_name ASC");
			
			/*@reset(explode('?' , @end(explode('/edit/' , url()->full())))) */
			return view('editProductDetail', ['products' => $products, 'categories' => $categories, 'manufacturers' => $manufacturers, 'attributes' => $attributes, 'business_rules' => $business_rules, 'attribute_items' => $attribute_items, 'attributes' => $attributes, 'pro_images' => $pro_images, 'product_items' => $product_items]);
		}
	}
	
	public function deleteFileUnlink(Request $request){
		if($request->input('type') == 'i'){
			
			/*we have image*/
			$imagesData = DB::table('product_image')->where('pi_id', $request->input('imgId'))->first();
			/* unlink file and delete record */
			@unlink(public_path('/uploads/product/'.$imagesData->product_image));
			DB::table('product_image')->where('pi_id', $request->input('imgId'))->delete();
			return ['status' => 'success', 'msg' => 'image has been  deleted successfully'];
		}elseif($request->input('type') == 'p'){
			
			/*we have pdf*/
			$product = products::where('product_id', $request->input('id'))->first();
			@unlink(public_path('/uploads/product/'.$product->product_pdf));
			$product->product_pdf = '';
			$product->save();
			return ['status' => 'success', 'msg' => 'pdf has been  deleted successfully'];
		}elseif($request->input('type') == 'v'){
			
			/*we have video*/
			$product = products::where('product_id', $request->input('id'))->first();
			@unlink(public_path('/uploads/product/'.$product->product_video));
			$product->product_video = '';
			$product->save();
			return ['status' => 'success', 'msg' => 'video has been  deleted successfully'];
		}else{
			
			return ['status' => 'error', 'msg' => 'sorry your request does not match our crieteria'];
		}
	}
	
	public function update(Request $request){
		$validator = Validator::make($request->all(), [
		 
		 'parent'                => 'required|max:100',
		 'manufacturer'          => 'max:100',
		 'attribute'             => 'max:100',
		 'attribute_item'        => 'max:100',
		 'unit_price'            => 'integer|max:100',
		 'unit_7'                => 'max:100',
		 'special_7'             => 'max:100',
		 'unit_id'               => 'max:100',
		 'dropship'              => 'max:100',
		 'out_of_stock'          => 'max:100',
		 'product_business_rule' => 'max:100',
		 'product_mix_class_id'  => 'max:100',
		 'package'               => 'max:100',
		 'weight'                => 'integer|max:100',
		 'item_no'               => 'max:100',
		 'size'                  => 'max:100',
		 'width'                 => 'max:100',
		 'height'                => 'max:100',
		 'length'                => 'max:100',
		 'sdetail'               => 'max:100',
		 'detail'                => 'max:100',
		 'featured'              => 'max:100',
		 'add_category'          => 'max:100'
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		if($request->input('update') == 'price_only'){
			
			
			$id = $request->input('product_id');
			
			$unit_product = unit_product::find($id);
			
			$unit_product->product_price = $request->input('product_price');
			$unit_product->product_sprice = $request->input('product_sprice');
			$unit_product->save();
			return redirect('/product')->with('price_update', 'Product Price Updated');
		}else if($request->input('update') == 'product_detail'){
			
			$arrImageValue = [];
			if($files = Input::file('product_img')){
				foreach($files as $file){
					$path = 'uploads/product/';
					$file_name = $file->getClientOriginalName();
					$file->move($path, $file_name);
					$arrImageValue[] = $file_name;
				}
			}
			
			$file_pdf = Input::file('product_file');
			if(isset($file_pdf) && ($file_pdf != '')){
				
				$prePdf = products::select('product_pdf')->where('product_id', $request->input('product_id'))->first();
				if(!empty(trim($prePdf->product_pdf))) @unlink(public_path().'/uploads/product/'.$prePdf->product_pdf);
				
				$path_pdf = 'uploads/product/';
				$file_name_pdf = $file_pdf->getClientOriginalName();
				$file_pdf->move($path_pdf, $file_name_pdf);
				$product_pdf = $file_name_pdf;
			}
			
			$file_video = Input::file('prodcut_video');
			if(isset($file_video) && ($file_video != '')){
				
				$preVideo = products::select('product_video')->where('product_id', $request->input('product_id'))->first();
				if(!empty(trim($preVideo->product_video))) @unlink(public_path().'/uploads/product/'.$preVideo->product_video);
				
				$path_video = 'uploads/product/';
				$file_name_video = $file_video->getClientOriginalName();
				$file_video->move($path_video, $file_name_video);
				$product_video = $file_name_video;
			}
			
			$id = $request->input('product_id');
			
			$products = products::find($id);
			$products->category_id = $request->input('category_id');
			$products->product_business_rule = $request->input('product_business_rule');
			$products->product_dropship = $request->input('product_dropship');
			$products->product_freeship = $request->input('product_freeship');
			$products->product_featured = $request->input('product_featured');
			$products->product_title = $request->input('product_title');
			$products->product_sort_order = $request->input('product_sort_order');
			$products->product_slug = $request->input('product_slug');
			$products->product_package = $request->input('product_package');
			$products->product_item_no = $request->input('product_item_no');
			$products->product_size = $request->input('product_size');
			$products->product_width = $request->input('product_width');
			$products->product_weight = $request->input('product_weight');
			$products->product_height = $request->input('product_height');
			$products->product_length = $request->input('product_length');
			$products->product_out_of_stock = $request->input('product_out_of_stock');
			$products->product_bundle = $request->input('product_bundle');
			$products->product_sdetail = $request->input('product_sdetail');
			$products->product_detail = $request->input('product_detail');
			if(isset($file_pdf) && !empty(trim($file_pdf))) $products->product_pdf = $product_pdf;
			if(isset($file_video) && !empty(trim($file_video))) $products->product_video = $product_video;
			
			$products->save();
			
			// $products_images = $request->input('product_img');
			
			$this->uploadImage($arrImageValue, $id);
			
			//			return redirect('/product')->with('product_update', 'Product Updated');
			return back()->with('product_update', 'Product Updated');
		}
	}
	
	public static function saveValues(Request $request){
		
		/*getting all name attributes from table attributes*/
		
		$details = DB::select("select attrItem.attribute_item_id as attribute_item_id , attr.attribute_id as attribute_id from attribute as attr , attribute_item as attrItem where attr.attribute_name = '".($request->input('mainCat'))."' and attr.attribute_id = attrItem.attribute_id and attrItem.attribute_item_name = '".($request->input('subcat'))."'");
		
		if(isset($details[ 0 ]->attribute_id) && isset($details[ 0 ]->attribute_item_id)){
			ProductAttribute::Create([
			 
			 'product_id'        => $request->productId,
			 'attribute_id'      => $details[ 0 ]->attribute_id,
			 'attribute_item_id' => $details[ 0 ]->attribute_item_id,
			
			]);
			return ['status' => 'success', 'msg' => 'data have been successfully updated'];
		}else{
			return ['status' => 'error', 'msg' => (((!isset($details->attribute_id)) ? ' sorry category is missing ' : '').((!isset($details->attribute_item_id)) ? ' sorry subcategor is missing  ' : ''))];
		}
	}
	
	public static function deleteAttr(Request $request){
		
		/*getting all name attributes from table attributes*/
		$details = DB::select("select attrItem.attribute_item_id as attribute_item_id , attr.attribute_id as attribute_id from attribute as attr , attribute_item as attrItem where attr.attribute_name = '".($request->input('mainCat'))."' and attr.attribute_id = attrItem.attribute_id and attrItem.attribute_item_name = '".($request->input('subcat'))."'");
		
		if(isset($details[ 0 ]->attribute_id) && isset($details[ 0 ]->attribute_item_id)){
			
			ProductAttribute::
			where('product_id', $request->productId)->where('attribute_id', $details[ 0 ]->attribute_id)->where('attribute_item_id', $details[ 0 ]->attribute_item_id)->delete();
			
			return ['status' => 'success', 'msg' => 'data have been successfully deleted'];
		}else{
			
			return ['status' => 'error', 'msg' => 'sorry category and sub category data is missing'];
		}
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		/*$products = products::find($id);
		$products->delete();
		return Redirect::to('product')->with('delete_product', 'Product Deleted');*/
		
		$images = DB::select('select * from product_image where product_id = ?', [$id]);
		foreach($images as $image){
			$product_image = $image->product_image;
			//unlink previous image
			$file_name = $product_image;
			$file_path = 'uploads/product/'.$file_name;
			unlink($file_path);
		}
		
		DB::table('product_image')->where('product_id', '=', $id)->delete();
		DB::table('unit_product')->where('product_id', '=', $id)->delete();
		DB::table('product_item')->where('product_id', '=', $id)->delete();
		
		$images2 = DB::select('select * from product where product_id = ?', [$id]);
		foreach($images2 as $image2){
			$product_image2 = $image2->product_pdf;
			$file_name2 = $product_image2;
			$file_path2 = 'uploads/product/'.$file_name2;
			unlink($file_path2);
			
			$product_image3 = $image2->product_video;
			$file_name3 = $product_image3;
			$file_path3 = 'uploads/product/'.$file_name3;
			unlink($file_path3);
		}
		
		DB::table('product')->where('product_id', '=', $id)->delete();
		
		return redirect()->to('product');
	}
	
	public function filter(Request $request){
		
		if($request->ajax()){
			if($request->get('selected_option') && ($request->get('keyword') == '')){
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$request->session()->forget('keyword');
				
				//$products = products::orderBy('product_id','asc')->paginate('15');
				$products = DB::table('product')->leftjoin('category', 'product.category_id', '=', 'category.category_id')->leftjoin('product_type', 'product.pt_id', '=', 'product_type.pt_id')->select('product.product_id', 'product.category_id', 'category.category_title', 'product.pt_id', 'product.product_title', 'product.product_sort_order', 'product.product_item_no', 'product.product_featured', 'product_type.pt_name', 'product.product_sort_order')->orderBy('product_id', 'asc')->paginate("$selected_option");
				return view('listProducts', ['products' => $products]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				
				$pg = (isset($op_select)) ? $op_select : '15';
				$products = DB::table('product')->leftjoin('category', 'product.category_id', '=', 'category.category_id')->leftjoin('product_type', 'product.pt_id', '=', 'product_type.pt_id')->where('category.category_title', 'like', '%'.$keyword.'%')->orWhere('product.product_title', 'like', '%'.$keyword.'%')->select('product.product_id', 'product.category_id', 'category.category_title', 'product.pt_id', 'product.product_title', 'product.product_sort_order', 'product.product_item_no', 'product.product_featured', 'product_type.pt_name', 'product.product_sort_order')->orderBy('product_id', 'asc')->paginate("$pg");
				return view('listProducts', ['products' => $products]);
			}
		}else{
			
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				
				$billshipaddress = billshipaddress::orderBy('bsa_id', 'asc')->paginate($pg);
				//echo "first sec".$pg."---".$keyword; exit();
				return view('billshipaddress')->with('billshipaddress', $billshipaddress);
			}else if(isset($keyword) && !isset($pg)){
				
				$products = DB::table('product')->leftjoin('category', 'product.category_id', '=', 'category.category_id')->leftjoin('product_type', 'product.pt_id', '=', 'product_type.pt_id')->where('category.category_title', 'like', '%'.$keyword.'%')->orWhere('product.product_title', 'like', '%'.$keyword.'%')->select('product.product_id', 'product.category_id', 'category.category_title', 'product.pt_id', 'product.product_title', 'product.product_sort_order', 'product.product_item_no', 'product.product_featured', 'product_type.pt_name', 'product.product_sort_order')->orderBy('product_id', 'asc')->paginate("15");
				return view('listProducts', ['products' => $products]);
			}else if(isset($pg) && isset($keyword)){
				
				$products = DB::table('product')->leftjoin('category', 'product.category_id', '=', 'category.category_id')->leftjoin('product_type', 'product.pt_id', '=', 'product_type.pt_id')->where('category.category_title', 'like', '%'.$keyword.'%')->orWhere('product.product_title', 'like', '%'.$keyword.'%')->select('product.product_id', 'product.category_id', 'category.category_title', 'product.pt_id', 'product.product_title', 'product.product_sort_order', 'product.product_item_no', 'product.product_featured', 'product_type.pt_name', 'product.product_sort_order')->orderBy('product_id', 'asc')->paginate("$pg");
				return view('listProducts', ['products' => $products]);
			}else{
				
				 
				$products = DB::table('product')->leftjoin('category', 'product.category_id', '=', 'category.category_id')->leftjoin('product_type', 'product.pt_id', '=', 'product_type.pt_id')->where('category.category_title', 'like', '%'.$keyword.'%')->orWhere('product.product_title', 'like', '%'.$keyword.'%')->select('product.product_id', 'product.category_id', 'category.category_title', 'product.pt_id', 'product.product_title', 'product.product_sort_order', 'product.product_item_no', 'product.product_featured', 'product_type.pt_name', 'product.product_sort_order')->orderBy('product_id', 'asc')->paginate((is_numeric(session()->get('selected_option'))) ? session()->get('selected_option') : 10);
				return view('listProducts', ['products' => $products]);
				
			}
		}
		// exit();
	}
	
	function delete_pdf($id){
		$exp_id = explode('_', $id);
		$product_id = $exp_id[ 0 ];
		$your_file = $exp_id[ 1 ];
		$products = products::find($product_id);
		$products->product_pdf = "";
		$products->save();
		$destinationPath = url('/uploads/product/'.$your_file);
		File::delete($destinationPath);
		return Redirect::to('product/edit/'.$id.'?action=edit_product')->with('delete_product', 'Product PDF Deleted');
	}
	
	function delete_video($id){
		
		$exp_id = explode('_', $id);
		$product_id = $exp_id[ 0 ];
		$your_file = $exp_id[ 1 ];
		
		$products = products::find($product_id);
		$products->product_video = "";
		$products->save();
		
		$destinationPath = url('/uploads/product/'.$your_file);
		File::delete($destinationPath);
		
		return Redirect::to('product/edit/'.$id.'?action=edit_product')->with('delete_product', 'Product Video Deleted');
	}
	
	function delete_images($id){
		//echo "do you want to delete video". $id;
		$exp_id = explode('_', $id);
		$product_id = $exp_id[ 0 ];
		$image_id = $exp_id[ 1 ];
		$your_file = $exp_id[ 2 ];
		$product_images = product_images::find($image_id);
		$product_images->delete();
		
		$destinationPath = url('/uploads/product/'.$your_file);
		File::delete($destinationPath);
		
		return Redirect::to('product/edit/'.$product_id.'?action=edit_product')->with('delete_product', 'Product Image Deleted');
	}
	
}
