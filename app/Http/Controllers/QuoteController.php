<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class QuoteController extends Controller{
	
	public $states=array('*'=>'*','AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming'
);
	
	public function index(Request $request){
	   
	  if(session()->get('user_id')){
		if($request->input('product_id') != NULL){
			$arrArgument=array();
			
			if($request->input('copy_quote') != NULL){
				foreach(array_reverse($_SESSION['cart']) as $post){
					if(@($_POST['quote1Product'.$post['product_id']])){
						$arrArgument['product_id']=intval(trim($post['product_id']));
						$arrArgument['unit_id']=intval(trim($post['unit_id']));
						$arrArgument['product_quantity']=intval(trim($post['product_quantity']));
						$this->addQuote($arrArgument);
					}	
				}
			} else {
				$arrArgument['product_id']=intval($request->input('product_id'));
				$arrArgument['unit_id']=intval($request->input('unit_id_q'));
				$arrArgument['product_quantity']=intval($request->input('quantity'));
				$this->addQuote($arrArgument);
			}
		}
		
		$uid=0;
		if(session()->get('user_id')){
			$uid = session()->get('user_id');
		}
		$arrArgument['table']='customer';
		$where=array('user_id'=>$uid);
		$arrArgument['where']=$where;
		$arrArgument['operator']='';
		$arrArgument['order']='user_id ASC';
		//$arrValue['user']=json_decode(json_encode(self::getRecord($arrArgument)));
		$arrValue['user']=json_decode( json_encode(self::getRecord($arrArgument)) , true);
		
		# Bill
		$arrArgument['table']='bill_ship_address';
		$where=array('user_id'=>session()->get('user_id'), 'bsa_type'=>'shipping');
		$is_multi_address=0;
		if($request->input('multi_address') != NULL){
			$where=array('user_id'=>session()->get('user_id'), 'bsa_type'=>'shipping', 'bsa_id'=>intval($_POST['address']));
			$is_multi_address=1;
		}
		$arrArgument['where']=$where;
		$arrArgument['operator']='AND';
		$arrArgument['order']='bsa_default DESC';
		//$arrValue['bsa_s']=json_decode(json_encode(self::getRecord($arrArgument)));
		$arrValue['bsa_s']=json_decode( json_encode(self::getRecord($arrArgument)) , true);
		
		if($is_multi_address == 1){
			return redirect()->to('quote/index/'.intval($request->input('address')));
			exit;
		}
		
		$arrValue['states'] = $this->states; 
		
		return view('frontwebsite.quote',$arrValue);
		
	  } else {
	  	return redirect()->to('login_user');	
	  }
   }
	
	function addQuote($arrArgument){
	   	
		$pid=$arrArgument['product_id'];
		$uid=$arrArgument['unit_id'];
		$q=$arrArgument['product_quantity'];
		if($pid<1 or $q<1) return;
	 
		$user_id = session()->get('user_id');
	    $ip_addr = $_SERVER['REMOTE_ADDR'];
		$date = date('Y-m-d H:i:s');
		//mysql_query("insert into visitor_cart_stats (user_id, ip_address, product_id, type, action, date) values ($user_id, '$ip_addr', '$pid', 'Quote', 'Add', '$date')");
		$result = DB::insert("insert into visitor_cart_stats(user_id, ip_address, product_id, type, action, date) values(? ,? ,? ,? ,? ,?)", [$user_id, $ip_addr, $pid, 'Quote', 'Add', $date]);
		
		/*if(isset($_SESSION['quote']) && is_array($_SESSION['quote'])){
			if($this->quoteExist($pid,$uid,$q)) return;
			$max=count($_SESSION['quote']);
			$_SESSION['quote'][$max]['product_id']=$pid;
			$_SESSION['quote'][$max]['unit_id']=$uid;
			$_SESSION['quote'][$max]['product_quantity']=$q;
		}
		else{
			$_SESSION['quote']=array();
			$_SESSION['quote'][0]['product_id']=$pid;
			$_SESSION['quote'][0]['unit_id']=$uid;
			$_SESSION['quote'][0]['product_quantity']=$q;
		}*/
		//session()->pull('quote');
		session()->push('quote', [
			'product_id' => $pid,
			'unit_id' => $uid,
			'product_quantity' => $q
		]);
		
		//$quote = Session::get('quote');
		
	}
	
	function updateQuote($pid = '', $qnty = '', $uid = ''){
		
		if(isset($pid)){
			$pid=intval($pid);
			$uid=intval($uid);
			$q=intval($qnty);		
			//$max=count(Session::get('quote'));
			/*for($i=0;$i<$max;$i++){			
				if($pid==$_SESSION['quote'][$i]['product_id'] && $uid==$_SESSION['quote'][$i]['unit_id']){				
					$_SESSION['quote'][$i]['product_quantity']=$q;
					break;		
				}		
			}*/
			
			$quotes = Session::get('quote');
			foreach($quotes as $i => $quote) {		
				if($pid==$quote['product_id'] && $uid==$quote['unit_id']){
					unset($quotes[$i]);
					$newQuotes = array_values($quotes);
					Session::put('quote', $newQuotes);
					break;
				}
			}
			
			$mfa = @reset(json_decode( json_encode(DB::select("select * from unit_product where product_id=$pid and unit_id=$uid")) , true));
			$price=trim($mfa['product_price']);
			if(trim($mfa['product_sprice'])!=''){
				$price=trim($mfa['product_sprice']);
			}
		
			$price='$'.number_format($price*$q,2);		
			$total=$this->getQuoteTotal();
			echo $price.'__'.$total;
		}
	}
	
	function getQuoteTotal(){
	
		$sub_total=0;
		$quotes = Session::get('quote');
		foreach(array_reverse($quotes) as $post){
			
			$product_id=intval(trim($post['product_id']));
			$product_quantity=intval(trim($post['product_quantity']));
			
			$mfa = @reset(json_decode( json_encode(DB::select("select * from unit_product where product_id='".$product_id."'")) , true));
			
			if(trim($mfa['product_sprice'])==''){
				$total=trim($mfa['product_price'])*intval($product_quantity);	
			}
			else{
				$total=trim($mfa['product_sprice'])*intval($product_quantity);	
			}
			
			$sub_total+=$total;
			
		}
		return $sub_total;
	
	}
	
	function removeQuote($pid = '', $uid = ''){
		
		if(isset($pid) && isset($uid)){
			
			$pid=intval($pid);
			$uid=intval($uid);
			
			$quotes = Session::get('quote');
			foreach($quotes as $i => $quote) {		
				if($pid==$quote['product_id'] && $uid==$quote['unit_id']){
					unset($quotes[$i]);
					
					$user_id = session()->get('user_id');
					$ip_addr = $_SERVER['REMOTE_ADDR'];
					$date = date('Y-m-d H:i:s');
					DB::insert("insert into visitor_cart_stats (user_id, ip_address, product_id, type, action, date) values(? ,? ,? ,? ,? ,?)", [$user_id, $ip_addr, $pid, 'Quote', 'Remove', $date]);
					break;
				}
			}
			
			$newQuotes = array_values($quotes);
			Session::put('quote', $newQuotes);
			
		}
		
		return redirect()->to('quote/index');
		
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
	
	public function sendEmail(Request $request){
		
		$_POST = $request;
		
		if($_POST){			
		$address = $_POST['address'];
		
		/*if(session()->get('user_id') != NULL){
			$addr_rec = json_decode( json_encode(DB::select("SELECT * FROM `bill_ship_address` where bsa_id = ".$address)) , true);
			$address = $addr_rec['bsa_address'];
		}*/
		
		$gremarks=$_POST['gremarks'];
		$email=$_POST['email'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$company=$_POST['company'];
		$phone=$_POST['phone'];
		$city=$_POST['city'];
		$zip=$_POST['zip'];
		$state=$_POST['state'];
		$country=$_POST['country'];
		$gtotal=$_POST['gtotal'];
		$uid=0;
		if(session()->get('user_id') != NULL){
				$uid=session()->get('user_id');
		}
		$post=array(	
					'user_id'			 =>$uid,
					'quote_remark'		=>$gremarks,
					'quote_email'		 =>$email,
					'quote_fname'		 =>$fname,
					'quote_lname'		 =>$lname,
					'quote_company'	   =>$company,
					'quote_telephone'	 =>$phone,
					'quote_address'	   =>$address,
					'quote_city'		  =>$city,
					'quote_zip'		   =>$zip,
					'quote_state'		 =>$state,
					'quote_country'	   =>$country,
					'grand_total'		 =>$gtotal,
					'quote_status'		=>0,
					'quote_date'		  =>date('Y-m-d H:i:s')	
				 );
	  $arrArgument['table']='quote';
	  $arrArgument['post']=$post;
	  //$quote_id=loadModel('medical', 'insertRecord', $arrArgument);	  
	  $quote_id = Helper::instance()->insertRecord($arrArgument);
	  if($quote_id){
		  
		  $quotes = Session::get('quote');
		  if(isset($quotes) && !empty($quotes)){
			foreach($quotes as $value) {
		  		
					$query = @reset(json_decode( json_encode(DB::select("select p.product_id,p.product_title,p.product_item_no,u.*,up.* from product p inner join unit_product up on p.product_id=up.product_id inner join unit u on
					u.unit_id=up.unit_id where p.product_id='".$value['product_id']."' and up.unit_id='".$value['unit_id']."'")) , true));
					$row=count($query);
					
					if($row > 0){
					
						//$post=mysql_fetch_assoc($query);
			  			$post=$query;
						
						$pid=$post['product_id'];
						$uid=$post['unit_id'];
						$remark=trim(stripslashes($_POST['detail_'.$post['product_id'].'_'.$post['unit_id']]));
			  			$qnty=intval($value['product_quantity']);
						$price=$post['product_price'];
						
						
						$post=array(
							 
							
							'quote_id'			=>$quote_id,
							'product_id'		=>$pid,
							'unit_id'			=>$uid,
							'product_remark'	=>$remark,
							'product_quantity'	=>$qnty,
							'product_price'		=>$price
							
						 
						 );
						$arrArgument['table']='quote_detail';
						$arrArgument['post']=$post;
						//loadModel('medical', 'insertRecord', $arrArgument);
						Helper::instance()->insertRecord($arrArgument);
						
					}
		  
		  
	  			}
		  }
		  
	  }
		
		//$to="quotes@medicalmedical.com";
		$to="asim@binarylogix.com";
		$subject="medical - Quick Quote";
		
		$headers="MIME-Version: 1.0" . "\r\n";
		$headers.="Content-type:text/html;charset=UTF-8" . "\r\n";
		//$headers.='From: <quotes@medicalmedical.com>' . "\r\n";
		$headers.='From: <asim@binarylogix.com>' . "\r\n";
		
		$str="<table cellspacing='0' cellpadding='0' width='550' border='1' style='width:550pt;border:solid #eaeaea 1.0pt'>
					
						<tr>
							<td style='background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border:0 none;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>General Remarks</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt;border-top:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".stripslashes($gremarks)."</span></p></td>
						</tr>
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Email</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$email</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>First Name</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$fname</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Last Name</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$lname</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Company</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$company</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Telephone</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$phone</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Address</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".trim(stripslashes($address))."</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>City</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$city</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #fff 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Zip</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$zip</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>State</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$state</span></p></td>
						</tr>
						
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Country</span></b></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$country</span></p></td>
						</tr>
						
				</table>";
				
				
					
				
				
		$str.="<table cellspacing='0' cellpadding='0' width='550' border='0' style='width:550pt;'>
			
				<tr align='center'>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
						<a href=''>
							<img src='/ms_o31.png'>
						</a>
					</td>
				</tr>
		
		</table>";
				
		 $str.="<table cellspacing='0' cellpadding='0' width='550' border='0' style='width:550pt;'>
			
					<tr align='center'>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
							<p>
								Medical Shipment LLC<br />
								8060 Saint Louis Avenue, <br />
	                          Skokie, IL 60076<br />
								<a style='color:#2692da;text-decoration:none' href='https://www.medicalshipment.com'>www.MedicalShipment.com</a>
							</p>
						</td>
					</tr>
		
			  </table>";
			  
		  
			  
			
		  
		  
		  
		  
		  
		  $str.="<table cellspacing='0' cellpadding='0' width='550' border='1' style='width:550pt;border:solid #eaeaea 1.0pt'>
					<thead>
					
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Item Number<u></u><u></u></span></b></p></td>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Product Name<u></u><u></u></span></b></p></td>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Product Description<u></u><u></u></span></b></p></td>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Unit Price<u></u><u></u></span></b></p></td>
							
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Quantity<u></u><u></u></span></b></p></td>
							
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Subtotal<u></u><u></u></span></b></p></td>
							
						</tr>
					
					</thead>
				<tbody>";
						
						$quotes = Session::get('quote');
		  				if(isset($quotes) && !empty($quotes)){
						foreach($quotes as $value) {
						
						$query = @reset(json_decode( json_encode(DB::select("select p.product_id,p.product_title,p.product_sdetail,p.product_item_no,u.*,up.* from product p inner join unit_product up on p.product_id=up.product_id inner join unit u on
						u.unit_id=up.unit_id where p.product_id='".$value['product_id']."' and up.unit_id='".$value['unit_id']."'")) , true));
						$row=count($query);
						
						if($row > 0){						
						$post=$query;
						
						$pid=$post['product_id'];
						$remark=trim(stripslashes($_POST['detail_'.$post['product_id'].'_'.$post['unit_id']]));
						if($remark!=''){
							$remark='<br /><b><i>Remarks:</i> </b>'.$remark;	
						}
						$product_title=trim(stripslashes($post['product_title']));
						$product_sdetail=trim(stripslashes($post['product_sdetail']));
						$item=trim($post['product_item_no']);
						$uid=$post['unit_id'];
						$qnty=intval($value['product_quantity']);
						if($post['product_sprice'] != '')
									{
										$product_price = trim($post['product_sprice']);
									}
									else
									{
										$product_price = trim($post['product_price']);
									}
						$price='$'.number_format(trim($product_price), 2);
						$subtotl='$'.number_format(trim($product_price)*$qnty, 2);
						  
						$str.="<tr>
								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$item."</span></strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'> <u></u><u></u></span></p></td>
								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$product_title."</span></strong>$remark<span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'> <u></u><u></u></span></p></td>
								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$product_sdetail."</span></strong>$remark<span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'> <u></u><u></u></span></p></td>
								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$price."<u></u><u></u></span></p></td>								
								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><div>
								<p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$qnty."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p>
								</div></td>								
								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$subtotl."<u></u><u></u></span></p></td>							
							</tr>";						  
						}				
						}
						}
				
				$str.="<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='5'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Grand Total</span></strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:center;line-height:16.2pt' class='MsoNormal'><span><b><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."$".number_format($gtotal,2)."</span></b></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>
					  </tr>";			  
	  			$str.="</tbody></table>";
				//echo $str; exit;
				$this->email($str,$email);
				
				if(isset($quotes) && !empty($quotes)){
					session()->pull('quote');
				}
				
				$thanks='Thank you for submitting your quote to Medical Shipment. We will review the information provided and get back to you as soon as possible. If you have any further questions, or would like to speak with a representative directly, please call 1-847-253-3000';
				
				session()->put('thanks', $thanks);
				
				return redirect()->to('quote/thanks');
						
		}
		
	}
	
	function email($message,$user_email){
			  
		//$to="quotes@medicalshipment.com,".trim($user_email);
		$to="asim@binarylogix.com,".trim($user_email);
		$subject="MedicalShipment - Quick Quote";
		$headers="MIME-Version: 1.0" . "\r\n";
		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
		//$headers.='From: <quotes@medicalshipment.com>'."\r\n";
		$headers.='From: <asim@binarylogix.com>'."\r\n";
		//$headers.='Cc: myboss@example.com'."\r\n";
		$exp=explode(',',$to);
		foreach($exp as $to){
			@mail($to,$subject,$message,$headers);
		}
	  
	}
	
	public function thanks(){
		return view('frontwebsite.thanks');
	}
	
	
}
