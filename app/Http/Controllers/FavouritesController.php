<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FavouritesController extends Controller{
	
	public $nthCategory;
	
	public function index(Request $request){
	   
	  if(session()->get('user_id')){

	  	if($request->input('w_id') != NULL){
			  
			   $arrArgument['table']='product';
			   $where=array('product_id'=>$request->input('product_id'));
			   $arrArgument['where']=$where;
			   $arrArgument['operator']='';
			   $arrArgument['order']='product_id ASC';
			   $arrValue['product']= json_decode(json_encode(self::getRecord($arrArgument)));
			    
			   $category_id=$arrValue['product'][0]->category_id;
			   $arrValue['tree']=$this->nthLevelCategoryAAA($category_id);										
				
			   //$category_id=end($arrValue['tree']);
			   
			   	$arrArgument['table']='favorite';
				$where=array('product_id'=>intval($request->input('product_id')),'unit_id'=>intval($request->input('unit_id_f')),'user_id'=>session()->get('user_id'));
				$arrArgument['where']=$where;
				$arrArgument['operator']='AND';
				$arrArgument['order']='fav_id ASC';
				$arrValue['fav']=json_decode(json_encode(self::getRecord($arrArgument)));
				
					if(empty($arrValue['fav'])){
							
						if($request->input('w_id') != NULL){
							$w_id = $request->input('w_id');
						} else {
							$arrArgument['table']='wishlist';
							$where=array('user_id'=>session()->get('user_id'), 'default_value' => 1);
							$arrArgument['where']=$where;
							$arrArgument['operator']='and';
							$arrArgument['order']='id';
							$get_record = json_decode(json_encode(self::getRecord($arrArgument)));
							
							$w_id = $get_record[0]['id'];
						}
						
						if($w_id != ''){
							$w_id = intval($w_id);
							$category_id = intval($category_id);
							$product_id = intval($request->input('product_id'));
							$user_id =session()->get('user_id');
							$unit_id = intval($request->input('unit_id_f'));
							$fav_date = date('Y-m-d H:i:s');
							
							$response = DB::insert("insert into favorite(w_id, category_id, product_id, user_id, unit_id, fav_date) values(? ,? ,? ,?, ?, ?)", [$w_id, $category_id, $product_id, $user_id, $unit_id, $fav_date]);
							
						} else {
							return redirect()->to('favorites/add_wishlist');
						}

					}
				
				/*$url='index.php?controller=favorites&function=manage_wishlist&msg=sent';				
				header("Location: ".$url);*/
				return redirect()->to('favorites/manage_wishlist');

		   }

		  # Get Quote
		  $join = 'INNER JOIN';
		  $where = ' where f.user_id='.session()->get('user_id');	
		  $arrValue['fav'] = DB::select("select u.user_id, u.user_email, p.product_id, p.product_title, p.product_detail, p.product_item_no, f.* from user u $join favorite f on u.user_id=f.user_id $join product p on f.product_id=p.product_id $where order by f.fav_id DESC");	
			
		  if(isset($_GET['msg'])){
			   $arrValue['msg']='Favorites added successfully';
		  }

		  if(isset($_SESSION['fromFav'])){
			  unset($_SESSION['fromFav']);
		  }

		  # Get Root Level Category
		  $arrArgument['table']='category';
		  $where=array('category_parent'=>0);
		  $arrArgument['where']=$where;
		  $arrArgument['operator']='';
		  $arrArgument['order']='category_title ASC';
	      $arrValue['category']=json_decode(json_encode(self::getRecord($arrArgument)));

		  # Get New Product
		  $arrArgument['table']='product p left join product_image pi on p.product_id=pi.product_id left join unit_product up on p.product_id=up.product_id left join unit u on u.unit_id=up.unit_id ';
	      $arrArgument['column']='p.*,pi.*,up.*,u.* ';
		  $where=array('p.pt_id'=>'1');
		  $arrArgument['where']=$where;
		  $arrArgument['operator']='';
		  $arrArgument['order']='RAND()';	  
		  $arrArgument['limit']=12;
		  $arrArgument['group']= 'p.product_id';	  
		  $arrValue['new_collection']=json_decode(json_encode(self::getRecord($arrArgument)));
		
		  return view('frontwebsite.whishlist',$arrValue);
	
	  } else {
	  		return redirect()->to('login_user');
	  }

   }
	
	public function add_wishlist(Request $request){
		
	   if(session()->get('user_id')){
	   
	    if($request->input('wishlist_name') != NULL){
			
			$arrArgument[ 'table' ] = 'wishlist';
			$where = ['user_id' => (int) (session()->get('user_id'))];
			$arrArgument[ 'where' ] = $where;
			$arrArgument[ 'operator' ] = '';
			$arrArgument[ 'order' ] = 'id ASC';
			$get_record = json_decode(json_encode(self::getRecord($arrArgument)));
			
			if(sizeof($get_record) > 0){
				$default = 0;
			} else {
				$default = 1;
			}

			$user_id = session()->get('user_id');
			$wishlist_name = $request->input('wishlist_name');
			$default_value = $default;
			$date_created = date('Y-m-d H:i:s');
			
			$result = DB::insert("insert into wishlist(user_id, wishlist_name, default_value, date_created) values(? ,? ,? ,?)", [$user_id, $wishlist_name, $default_value, $date_created]);
			
			$msg = "new_list";
			//self::manage_wishlist();
			
			/////////////// MANAGE WISH LIST CODE START ////////////////
					
			  if(session()->get('user_id')){
			   
				if($request->input('submit') != NULL){
			
					// Delete selected Wish List
					if($request->input('delete') != NULL){
					  foreach ($request->input('delete') as $delete_id){
						  DB::table('wishlist')->where('id', '=', $delete_id)->delete();
					  }
					}
								   
					DB::update("update wishlist set default_value=0 where user_id=".session()->get('user_id'));
					DB::update("update wishlist set default_value=1 where id=".$request->input('default'));
							   
				}
				
				if($request->input('itemSearch') != NULL){
					$search = " and p.product_title like '%".$request->input('itemSearch')."%'";		
				}
				else{
					$search = "";
				}
				
				// Get user Wish List
				/*if(isset($_GET['w_id'])){
					$w_id = $_GET['w_id'];
				} else {
					$w_id = '';
				}*/
				
				$arrArgument['table'] = 'wishlist w left join favorite f on w.id=f.w_id';		
				$arrArgument['column'] = 'w.*, count(f.w_id) as tot';
				$where = ['w.user_id' => (int) (session()->get('user_id'))];
				$arrArgument['where'] = $where;
				$arrArgument['operator'] = '';
				$arrArgument['group'] = 'w.id';
				$arrArgument['order'] = 'w.id asc';
				$arrValue['wishlists'] = json_decode(json_encode(self::getRecord($arrArgument)));
				
				/*if(isset($w_id)){			
					$search = '';
					$join = 'INNER JOIN';
					$where = " where f.user_id = ".session()->get('user_id')." and f.w_id = ".$w_id.$search;
					$arrValue['fav'] = DB::select("select u.user_id, u.user_email, p.product_id, p.product_title, p.product_detail, p.product_item_no, f.* from user u $join favorite f on u.user_id=f.user_id $join product p on f.product_id=p.product_id $where order by f.fav_id DESC");
				}*/
				
				# Get New Product
				$arrArgument['table'] = 'product p left join product_image pi on p.product_id=pi.product_id left join unit_product up on p.product_id=up.product_id left join unit u on u.unit_id=up.unit_id ';
				$arrArgument['column'] = 'p.product_id as p_id, p.*,pi.*,up.*,u.* ';
				$where=array('p.pt_id'=>'1');
				$arrArgument['where'] = $where;
				$arrArgument['operator'] = '';
				$arrArgument['order'] = 'RAND()';
				$arrArgument['limit'] = 12;
				$arrArgument['group'] = 'p.product_id';	  
				$arrValue['new_collection'] = json_decode(json_encode(self::getRecord($arrArgument)));
				
				return view('frontwebsite.manage_wishlist',$arrValue);
				
			} else {
				return redirect()->to('login_user');
			}
			/////////////// MANAGE WISH LIST CODE END ////////////////
			
		} else {
				
			// Get user Wish List
			$arrArgument['table'] = 'wishlist';
			$where = array('user_id'=>session()->get('user_id'));
			$arrArgument['where'] = $where;
			$arrArgument['operator'] = '';
			$arrArgument['order'] = 'wishlist_name desc';
			$arrValue['wishlists'] = json_decode(json_encode(self::getRecord($arrArgument)));
					
			# Get New Product
			$arrArgument = array();
			$arrArgument['table']='product p left join product_image pi on p.product_id=pi.product_id left join unit_product up on p.product_id=up.product_id left join unit u on u.unit_id=up.unit_id ';
			$arrArgument['column']='p.*,pi.*,up.*,u.* ';
			$where=array('p.pt_id'=>'1');
			$arrArgument['where']=$where;
			$arrArgument['operator']='';
			$arrArgument['order']='RAND()';	  
			$arrArgument['limit']=12;
			$arrArgument['group']= 'p.product_id';	  
			$arrValue['new_collection']=json_decode(json_encode(self::getRecord($arrArgument)));
			
			return view('frontwebsite.whishlist_all',$arrValue);
			
			}
			
		} else {
			return redirect()->to('login_user');
		}
		
	}
	
	public function manage_wishlist22(Request $request){
		//request()-get('w_id');
	  if(session()->get('user_id')){
	   
		if($request->input('submit') != NULL){
			
			// Delete selected Wish List
			if($request->input('delete') != NULL){
			  foreach ($request->input('delete') as $delete_id){
				  DB::table('wishlist')->where('id', '=', $delete_id)->delete();
			  }
			}
			  			   
		  	DB::update("update wishlist set default_value=0 where user_id=".session()->get('user_id'));
		  	DB::update("update wishlist set default_value=1 where id=".$request->input('default'));
					   
		}
		
		if($request->input('itemSearch') != NULL){
			$search = " and p.product_title like '%".$request->input('itemSearch')."%'";		
		} else {
			$search = "";
		}
		
		$arrArgument['table']= 'wishlist w left join favorite f on w.id=f.w_id';		
		$arrArgument['column'] = 'w.*, count(f.w_id) as tot';
		$where = ['w.user_id' => (int) (session()->get('user_id'))];
		$arrArgument['where'] = $where;
		$arrArgument['operator'] = '';
		$arrArgument['group'] = 'w.id';
		$arrArgument['order'] = 'w.id asc';
		$arrValue['wishlists'] = json_decode(json_encode(self::getRecord($arrArgument)));
		
		if($w_id != ''){
		
			//$arrArgument['join']='INNER JOIN';
			//$arrArgument['where']="f.user_id=".intval($_SESSION['front_id'])." and f.w_id=".$w_id.$search;
			//$arrValue['fav']=loadModel('medical','joinUserProductFavorite',$arrArgument);
		  	
			$search = '';
			$join = 'INNER JOIN';
			$where = " where f.user_id = ".session()->get('user_id')." and f.w_id = ".$w_id.$search;
			$arrValue['fav'] = DB::select("select u.user_id, u.user_email, p.product_id, p.product_title, p.product_detail, p.product_item_no, f.* from user u $join favorite f on u.user_id=f.user_id $join product p on f.product_id=p.product_id $where order by f.fav_id DESC");
			
		}
		
		# Get New Product
		/*$arrArgument['table'] = 'product p left join product_image pi on p.product_id=pi.product_id left join unit_product up on p.product_id=up.product_id left join unit u on u.unit_id=up.unit_id ';
		$arrArgument['column'] = 'p.product_id as p_id, p.*,pi.*,up.*,u.* ';
		$where=array('p.pt_id'=>'1');
		$arrArgument['where'] = $where;
		$arrArgument['operator'] = '';
		$arrArgument['order'] = 'RAND()';
		$arrArgument['limit'] = 12;
		$arrArgument['group'] = 'p.product_id';	  
		$arrValue['new_collection'] = json_decode(json_encode(self::getRecord($arrArgument)));*/
		
		return view('frontwebsite.manage_wishlist',$arrValue);
		
	} else {
		return redirect()->to('login_user');
	}
   
   }
   
   public function manage_wishlist(Request $request){
	
	//dd(request()->all());
	$slugs = explode ("/", request()->fullUrl());
 	$latestslug = $slugs [(count ($slugs) - 1)];	
	
	$w_id = 0;
	
	if(is_numeric($latestslug)) $w_id = $latestslug;
	if($w_id == 0 ) unset($w_id);
	
	  if(session()->get('user_id')){
	   
		if($request->input('submit') != NULL){
			
			// Delete selected Wish List
			if($request->input('delete') != NULL){
			  foreach ($request->input('delete') as $delete_id){
				  DB::table('wishlist')->where('id', '=', $delete_id)->delete();
			  }
			}
			  			   
		  	DB::update("update wishlist set default_value=0 where user_id=".session()->get('user_id'));
		  	if($request->input('default') != NULL){
				DB::update("update wishlist set default_value=1 where id=".$request->input('default'));
			}
					   
		}
		
		if($request->input('itemSearch') != NULL){
			$search = " and p.product_title like '%".$request->input('itemSearch')."%'";		
		} else {
			$search = "";
		}
		
		$arrArgument['table']= 'wishlist w left join favorite f on w.id=f.w_id';		
		$arrArgument['column'] = 'w.*, count(f.w_id) as tot';
		$where = ['w.user_id' => (int) (session()->get('user_id'))];
		$arrArgument['where'] = $where;
		$arrArgument['operator'] = '';
		$arrArgument['group'] = 'w.id';
		$arrArgument['order'] = 'w.id asc';
		$arrValue['wishlists'] = json_decode(json_encode(self::getRecord($arrArgument)));
		
		if(isset($w_id)){
			
			$search = '';
			$join = 'INNER JOIN';
			$where = " where f.user_id = ".session()->get('user_id')." and f.w_id = ".$w_id.$search;
			$arrValue['fav'] = DB::select("select u.user_id, u.user_email, p.product_id, p.product_title, p.product_detail, p.product_item_no, f.* from user u $join favorite f on u.user_id=f.user_id $join product p on f.product_id=p.product_id $where order by f.fav_id DESC");
			
		}
		
		# Get New Product
		$arrArgument['table'] = 'product p left join product_image pi on p.product_id=pi.product_id left join unit_product up on p.product_id=up.product_id left join unit u on u.unit_id=up.unit_id ';
		$arrArgument['column'] = 'p.product_id as p_id, p.*,pi.*,up.*,u.* ';
		$where=array('p.pt_id'=>'1');
		$arrArgument['where'] = $where;
		$arrArgument['operator'] = '';
		$arrArgument['order'] = 'RAND()';
		$arrArgument['limit'] = 12;
		$arrArgument['group'] = 'p.product_id';	  
		$arrValue['new_collection'] = json_decode(json_encode(self::getRecord($arrArgument)));
		
		return view('frontwebsite.manage_wishlist',$arrValue);
		
	} else {
		return redirect()->to('login_user');
	}
   
   }
   
   public function getRecord($arrArgument){
		
		$where = '';
		$limit = '';
		$groupby = '';
		$table = $arrArgument[ 'table' ];
		if(isset($arrArgument[ 'column' ])){
			$column = $arrArgument[ 'column' ];
		}else{
			$column = "*";
		}
		$count_array = count($arrArgument[ 'where' ])-1;
		$count = 0;
		foreach($arrArgument[ 'where' ] as $key => $value){
			$count++;
			
			$where .= trim($key).'='."'".(trim($value))."'";
			if($arrArgument[ 'operator' ] != '' && $count <= $count_array){
				
				$where .= ' '.$arrArgument[ 'operator' ].' ';
			}
		}
		
		if($where != ''){
			
			$where = 'WHERE '.$where;
		}
		if(isset($arrArgument[ 'limit' ])){
			
			$limit = 'limit '.$arrArgument[ 'limit' ];
		}
		if(isset($arrArgument[ 'group' ])){
			
			$groupby = 'group by '.$arrArgument[ 'group' ];
		}
		
		$order = 'order by '.$arrArgument[ 'order' ];
		$sql = "select $column from $table $where $groupby $order $limit";
		
		$rows = json_decode(json_encode(DB::select($sql)), TRUE);
		//$array_return = [];
		//$array_return = DB::select($sql);
		if(count($rows) > 0){
			return $rows;
		}else{
			return [];
		}
	}
	
	/*function nthLevelCategoryAAA($id){
		$mfa = DB::select("select * from category where category_id=$id");
		if($mfa->category_id){
			$this->nthCategory[].=$mfa->category_title;
			$this->nthCategoryID[].=$mfa->category_id;
			return $this->nthLevelCategoryAAA($mfa->category_parent);
		} else {
			$combine=array_combine($this->nthCategory,$this->nthCategoryID);
			return $combine;
		}
	}*/
	
	public static function nthLevelCategoryAAA($id){
			
		$sql = DB::select("select * from category where category_id=$id");		
		$nthCategory2 = '';
		
		if(count($sql)){
			$c = 0;
			foreach($sql as $mfa){
				$c++;
			if(is_numeric($mfa->category_id)){
				return $nthCategory2 = $mfa->category_title. ' >> ' . implode('  >> ' , self::navChilds($mfa->category_parent));
				
				//return self::nthLevelCategory($mfa->category_parent);
			} else {
				return $nthCategory;
			}
		}
			} else {
				return false;
			}
	}
	
	public static function navChilds($id){
	   
	  $sql = DB::select("select * from category where category_id=$id"); 
	  if(count($sql)){
		  $pusher = [];
		  foreach($sql as $r){
			  $pusher[] = $r->category_title;
			  }
			  return $pusher;
		  } else {
			  return [];
		}
	}
	
	public function remove($fav_id){
	  	if(isset($fav_id)){
			DB::table('favorite')->where('fav_id', '=', $fav_id)->delete();
		}
	  	return redirect()->to('favorites/manage_wishlist');	
   }
	
}
