<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use App\importexport;
use Illuminate\Support\Facades\Input;
use Hash;

class ImportexportController extends Controller
{
    //
	public function index() {
      $categories = $this->fetchCategoryTree();
	  return view('importexport',['categories'=>$categories]);
   }
  
  public function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = '') {
		
	  if (!is_array($user_tree_array))
		$user_tree_array = array();
	
	  $categories = DB::select("SELECT * FROM `category` WHERE 1 AND `category_parent` = $parent ORDER BY category_id ASC");
		foreach ($categories as $row) {
		  $user_tree_array[] = array("category_id" => $row->category_id, "category_title" => $spacing . $row->category_title);
		  $user_tree_array = $this->fetchCategoryTree($row->category_id, $spacing . '&nbsp;&nbsp;', $user_tree_array);
		}
	  
	  return $user_tree_array;
	
	}
   
	  public function addcategory() {	  
		  $categories = $this->fetchCategoryTree();
		  //$categories = DB::select('select * from category');
		  return view('addcategory',['categories'=>$categories]);
		  //return view('addcategory');
	  }
  
    public function export(Request $request)
    {
		$category=implode(',',$_POST['category']);
		$this->exportCSV($category);
		return redirect()->to(url('importexport'));
    }
 
 	function exportCSV($category){
		set_time_limit(0);
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		$output=fopen('php://output', 'w');
		
		
		/*$sql="SHOW COLUMNS FROM `product`";
		$query=mysql_query($sql);
		$column=array();
		while($mfa=mysql_fetch_assoc($query)){
			$column[]=$mfa['Field'];
		}*/
		# echo '<pre>'.print_r($column,true).'</pre>';exit;
		$column = array('Id', 'Category', 'Manufacture', 'Item No', 'Title', 'Business Rule', 'Description', 'Short Description', 'Weight', 'Width', 'Height', 'Length', 'Sort Order', 'PDF', 'Video', 'Is featured', 'Dropship', 'Free Shipping', 'Out of stock', 'Date added');
		fputcsv($output, $column);
		
		//$rows=mysql_query("SELECT p.*, c.category_title, m.manu_title FROM product p JOIN category c ON p.category_id = c.category_id LEFT JOIN manufacturer m ON p.manu_id = m.manu_id where p.category_id IN ($category) AND p.pt_id=1 order by p.category_id ASC");
		
		$categories = DB::select("SELECT p.*, c.category_title, m.manu_title FROM product p JOIN category c ON p.category_id = c.category_id LEFT JOIN manufacturer m ON p.manu_id = m.manu_id where p.category_id IN ($category) AND p.pt_id=1 order by p.category_id ASC");
		
		foreach($categories as $row){
			
			$feature = $dropship = $freeship = $out_of_stock = 'No';
			if($row->product_featured==1)
			{
				$feature = 'Yes';
			}
			if($row->product_dropship==1)
			{
				$dropship = 'Yes';
			}
			if($row->product_freeship==1)
			{
				$freeship = 'Yes';
			}
			if($row->product_out_of_stock==1)
			{
				$out_of_stock = 'Yes';
			}
			
			$row_arr = array($row->product_id, $row->category_title, $row->manu_title, $row->product_item_no, $row->product_title, $row->product_business_rule, $row->product_detail, $row->product_sdetail, $row->product_weight, $row->product_width, $row->product_height, $row->product_length, $row->product_sort_order, $row->product_pdf, $row->product_video, $feature, $dropship, $freeship, $out_of_stock, date('m/d/Y', strtotime($row->product_date)));
			fputcsv($output, $row_arr);
		}
		fclose($output);
		exit();
	
	}
 	
	public function import(Request $request){
		
		//get the file
    	$file = Input::file('file');

		//create a file path
		$path = 'uploads/csv/';
		
		//get the file name
		$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
		
		//save the file to your path
		$file->move($path , $file_name); //( the file path , Name of the file)
		
		if($file_name){
			
			$file_path = 'uploads/csv/'.$file_name;
			$ext=pathinfo($file_path, PATHINFO_EXTENSION);
			
			if(strtolower($ext)=='csv'){
				$this->insertRecord($file_name);
			}
			if(file_exists($file_path)){
				unlink($file_path);
			}
			return redirect()->to(url('importexport'));
		} else {
			return redirect()->to(url('importexport'));
		}
    }
	
	function insertRecord($file){
		$array = $this->csv_to_array($file);
		
		if(!empty($array)){
			
			foreach($array as $post){
				
				$result = DB::insert("insert into product(pt_id,as_id,category_id,product_position,category_detail,product_hero,manu_id,product_title,product_slug,product_package,product_weight,product_item_no,product_size,product_width,product_height,product_length,product_detail,product_featured,product_date) values(? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)",[intval($post['pt_id']),intval($post['as_id']),intval($post['category_id']),intval($post['product_position']),intval($post['product_hero']),intval($post['manu_id']),mysql_real_escape_string(trim($post['product_title'])),mysql_real_escape_string(trim($post['product_slug'])),mysql_real_escape_string(trim($post['product_package'])),mysql_real_escape_string(trim($post['product_weight'])),mysql_real_escape_string(trim($post['product_item_no'])),mysql_real_escape_string(trim($post['product_size'])),mysql_real_escape_string(trim($post['product_width'])),mysql_real_escape_string(trim($post['product_height'])),mysql_real_escape_string(trim($post['product_length'])),$post['product_detail'],mysql_real_escape_string(trim($post['product_featured'])),trim($post['product_date'])]);
				
			}
			
		}
		
	}
	
	function csv_to_array($filename='', $delimiter=','){
		$file_path = 'uploads/csv/'.$filename;
		if(!file_exists($file_path) || !is_readable($file_path))
			return FALSE;
		
		$header = NULL;
		$data = array();
		if (($handle = fopen($file_path, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				if(!$header)
					$header = $row;
				else
					$data[] = array_combine($header, $row);
			}
			fclose($handle);
		}
		return $data;
	}
	
 	public function show($id) {
	  //$categories = DB::select('select * from category');	
      $categories = $this->fetchCategoryTree();
	  $categories2 = DB::select('select * from category where category_id = ?',[$id]);
      return view('category_update',['categories'=>$categories,'categories2'=>$categories2]);
   }
 	
	public function edit(Request $request,$id) {
		
		if($request->hasFile('file')){
			//get the file
			$file = Input::file('file');
			
			//create a file path
			$path = 'uploads/category/';
		
			//get the file name
			$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
			
			//save the file to your path
			$file->move($path , $file_name); //( the file path , Name of the file)
			
			//unlink previous image
			$file_name2 = $request->input('category_image');
			$file_path = 'uploads/category/'.$file_name2;
			unlink($file_path);
		} else {	
			$file_name = $request->input('category_image');
		}
		
		  $category = $request->input('category');
		  $title = $request->input('title');
		  $slug = $request->input('slug');
		  $category_sort = $request->input('category_sort');
		  $detail = $request->input('detail');
		  DB::update('update category set category_parent = ?, category_title = ?, category_slug = ?, category_sort = ?, category_detail = ?, category_image = ? where category_id = ?',[$category,$title,$slug,$category_sort,$detail,$file_name,$id]);
		  return redirect()->to('view-category');
	}
	
	function slug($id,$title){
	  
	  $exp=explode(' ',trim($title));
	  $slug='';
	  foreach($exp as $value){
		  
		  if($value!=''){
			  $slug.=strtolower(trim($value)).'-';
		  }
		  
	  }
	 
	  $remove[] = "'";
	  $remove[] = '"';
      $remove[] = "&";
	  $remove[] = "_";
	  $remove[] = "%";
	  $remove[] = "$";
	  $remove[] = "*";
	  $remove[] = "@";
	  $remove[] = "!";
	  $remove[] = ";";
	  $remove[] = ",";
	  $remove[] = "/";
	  $remove[] = "<";
	  $remove[] = "<";
	  $remove[] = ">>";
	  $remove[] = "<<";
	  
	  $slug=str_replace($remove, "", $slug);
	  
	  $slug=rtrim($slug,'-');
	  $slug=str_replace('--','-',$slug);
	  
	  /*$sql="select * from category where category_slug='".trim($slug)."' and category_id!='".intval($_GET['id'])."'";
	  $query=mysql_query($sql);
	  $num_rows=mysql_num_rows($query);*/
	  
	  $categories = DB::select('select * from category where category_slug = ? and category_id = ?',[trim($slug),$id]);
	  $num_rows = 0;
	  foreach($categories as $category){
		 $num_rows = $num_rows + 1;
	  }
	  
	  $slug=trim($slug).'||'.$num_rows;
	  echo $slug;
	  
  }
	
	public function destroy($id)
	{	
		 $categories = DB::select('select * from category where category_id = ?',[$id]);
		 foreach($categories as $category){
		 	$category_image = $category->category_image;
		 }
		 //unlink previous image
		 $file_name2 = $category_image;
		 $file_path = 'uploads/category/'.$file_name2;
		 unlink($file_path);	
			
		 DB::table('category')->where('category_id', '=', $id)->delete();
		 return redirect()->to('view-category');
	}
	
}
