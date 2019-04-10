<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Kit_quoteController extends Controller{
  

   function index(){	  

		loadView('header_kit.php');

		if($_POST){

			# echo '<pre>'.print_r($_POST,true).'</pre>';exit;	   

			$arrArgument=array();
			
			if(isset($_POST['copy_quote'])){
				
				foreach(array_reverse($_SESSION['cart']) as $post){
	
					$arrArgument['product_id']=intval(trim($post['product_id']));
					$arrArgument['product_quantity']=1;
					$this->addQuoteKit($arrArgument);
					
				}
			
			}
			else{

				$arrArgument['product_id']=intval($_POST['product_id']);
				$arrArgument['product_quantity']=intval($_POST['quantity']);
				$this->addQuoteKit($arrArgument);
			
			}
			# echo '<pre>'.print_r($_SESSION['quote'],true).'</pre>';

		}
		
		$uid=0;

		if(isset($_SESSION['front_id'])){

			$uid=$_SESSION['front_id'];

		}

		$arrArgument['table']='user';

		$where=array('user_id'=>$uid);

		$arrArgument['where']=$where;

		$arrArgument['operator']='';

		$arrArgument['order']='user_id ASC';

		$arrValue['user']=loadModel('medical','getRecord',$arrArgument);

		loadView('kit_quote.php',$arrValue);		

		loadView('footer.php');	  

   }
   

   function addQuoteKit($arrArgument){
	   

	    # echo '<pre>'.print_r($arrArgument,true).'</pre>';exit;

		$pid=$arrArgument['product_id'];

		$q=$arrArgument['product_quantity'];

		if($pid<1 or $q<1) return;

	 

		if(isset($_SESSION['kit_quote']) && is_array($_SESSION['kit_quote'])){
			if($this->quoteExist($pid,$q)) return;
			$max=count($_SESSION['kit_quote']);
			$_SESSION['kit_quote'][$max]['product_id']=$pid;
			$_SESSION['kit_quote'][$max]['product_quantity']=$q;
		}

		else{

			$_SESSION['kit_quote']=array();
			$_SESSION['kit_quote'][0]['product_id']=$pid;
			$_SESSION['kit_quote'][0]['product_quantity']=$q;

		}		

	}

	

	function quoteExist($pid,$q){

		$pid=intval($pid);
		$max=count($_SESSION['kit_quote']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['kit_quote'][$i]['product_id']){
				$_SESSION['kit_quote'][$i]['product_quantity']=$_SESSION['kit_quote'][$i]['product_quantity']+$q;
				$flag=1;
				break;
			}
		}
		return $flag;
	}	

	function removeQuote(){		

		if(isset($_GET['pid']) && isset($_GET['uid'])){			

			$pid=intval($_GET['pid']);
			$uid=intval($_GET['uid']);
			$max=count($_SESSION['kit_quote']);

			for($i=0;$i<$max;$i++){
				if($pid==$_SESSION['kit_quote'][$i]['product_id']){
					unset($_SESSION['kit_quote'][$i]);
					break;
				}
			}			

			$_SESSION['kit_quote']=array_values($_SESSION['kit_quote']);	

		}		

		$url="'".SITE_PATH.'index.php?controller=kit_quote&function=index'."'";
		echo "<script>window.location=$url</script>";		

	}

	

	function sendEmail(){

		

		if($_POST){

			

		$gremarks=trim(mysql_real_escape_string($_POST['gremarks']));
		$email=trim(mysql_real_escape_string($_POST['email']));
		$fname=trim(mysql_real_escape_string($_POST['fname']));
		$lname=trim(mysql_real_escape_string($_POST['lname']));
		$company=trim(mysql_real_escape_string($_POST['company']));
		$phone=trim(mysql_real_escape_string($_POST['phone']));
		$address=trim(mysql_real_escape_string($_POST['address']));
		$city=trim(mysql_real_escape_string($_POST['city']));
		$zip=trim(mysql_real_escape_string($_POST['zip']));
		$state=trim(mysql_real_escape_string($_POST['state']));
		$country=trim(mysql_real_escape_string($_POST['country']));
		$gtotal=trim(mysql_real_escape_string($_POST['gtotal']));
		
		
		$kit_bag_id=trim(mysql_real_escape_string($_SESSION['bag_id']));		
		$kit_bag_prce=trim(mysql_real_escape_string($_SESSION['big_price']));
		$kit_bag_qty=trim(mysql_real_escape_string($_SESSION['bag_qty']));
		
		$uid=0;

		if(isset($_SESSION['front_id'])){
				$uid=$_SESSION['front_id'];
		}


		$post=array(
					'user_id'			 =>$uid,
					'quote_remark'		=>$gremarks,
					'quote_email'		 =>$email,
					'quote_fname'		 =>$fname,
					'quote_lname'		 =>$lname,
					'quote_company'       =>$company,
					'quote_telephone'	 =>$phone,
					'quote_address'	   =>$address,
					'quote_city'		  =>$city,
					'quote_zip'		   =>$zip,
					'quote_state'		 =>$state,
					'quote_country'	   =>$country,
					'grand_total'		 =>$gtotal,
					'quote_status'		=>0,
					'quote_date'		  =>date('Y-m-d H:i:s'),
					'kit_bag_id'		  =>$kit_bag_id,
					'kit_bag_price'	   =>$kit_bag_price,
					'kit_bag_qty'		 =>$kit_bag_qty			 

				 );

	  $arrArgument['table']='kit_quote';

	  $arrArgument['post']=$post;

	  $quote_id=loadModel('medical', 'insertRecord', $arrArgument);

	  

	  if($quote_id){

		  if(isset($_SESSION['kit_quote']) && !empty($_SESSION['kit_quote'])){ 			

				foreach($_SESSION['kit_quote'] as $value){				

					$sql="SELECT p.*, pi.* FROM kit_product p left join kit_product_image pi on p.product_id=pi.product_id where p.product_id='".$value['product_id']."' group by p.product_id";

					$query=mysql_query($sql);

					$row=mysql_num_rows($query);

					if($row > 0){

					

						$post=mysql_fetch_assoc($query);

			  			

						$pid=$post['product_id'];
						$remark=trim(stripslashes($_POST['detail_'.$post['product_id']]));
			  			$qnty=intval($value['product_quantity']);
						$price=$post['product_price'];							

						$post=array(	
							'quote_id'			=>$quote_id,
							'product_id'		=>$pid,
							'product_remark'	=>$remark,
							'product_quantity'	=>$qnty,
							'product_price'		=>$price
						 );

						$arrArgument['table']='kit_quote_detail';
						$arrArgument['post']=$post;
						loadModel('medical', 'insertRecord', $arrArgument);

					}
	  			}
		  }
	  }

		$to="quotes@medicalmedical.com";
		$subject="medical - Nursing Kit Quote";
		

		$headers="MIME-Version: 1.0" . "\r\n";
		$headers.="Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers.='From: <quotes@medicalmedical.com>' . "\r\n";

		# $headers.='Cc: kaleem@binarylogix.com' . "\r\n";

		

		/*$str="<table cellspacing='0' cellpadding='0' width='650' border='0' style='width:660.5pt;'>

			

					<tr>

						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>

							<p><b>Dear</b> ".ucwords($company).",</p>

						</td>

					</tr>

		

			  </table>";*/

		

		$str="<table cellspacing='0' cellpadding='0' width='650' border='1' style='width:660.5pt;border:solid #eaeaea 1.0pt'>
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

							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt;border-bottom:solid #eaeaea 1.0pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>$address</span></p></td>
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

				

				

					

				

				

		$str.="<table cellspacing='0' cellpadding='0' width='650' border='0' style='width:660.5pt;'>

			

				<tr align='center'>

					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>

						<a href=''>

							<img src='https://www.medicalshipment.com/skin/frontend/default/medicalshipment2012/images/logo_email.gif'>

						</a>

					</td>

				</tr>

		

		</table>";

				

		 $str.="<table cellspacing='0' cellpadding='0' width='650' border='0' style='width:660.5pt;'>

			

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

			
		  $str.="<table cellspacing='0' cellpadding='0' width='650' border='1' style='width:660.5pt;border:solid #eaeaea 1.0pt'>

					<thead>				

						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Item Number<u></u><u></u></span></b></p></td>

							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Remarks with Product<u></u><u></u></span></b></p></td>

							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Unit Price<u></u><u></u></span></b></p></td>

							

							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Quantity<u></u><u></u></span></b></p></td>

							

							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Subtotal<u></u><u></u></span></b></p></td>
						</tr>				

					</thead>

				<tbody>";


						if(isset($_SESSION['kit_quote']) && !empty($_SESSION['kit_quote'])){ 						

						foreach($_SESSION['kit_quote'] as $value){						

						$sql="SELECT p.*, pi.* FROM kit_product p left join kit_product_image pi on p.product_id=pi.product_id where p.product_id='".$value['product_id']."' group by p.product_id";

						$query=mysql_query($sql);

						$row=mysql_num_rows($query);

						if($row > 0){						

						$post=mysql_fetch_assoc($query);
						

						$pid=$post['product_id'];
						$item=trim($post['product_item_no']);
						$remark=trim(stripslashes($_POST['detail_'.$post['product_id']]));
						$qnty=intval($value['product_quantity']);
						$price='$'.number_format(trim($post['product_price']), 2);
						$subtotl='$'.number_format(trim($post['product_price'])*$qnty, 2);
						  

						$str.="<tr>
								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$item."</span></strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'> <u></u><u></u></span></p></td>

								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$remark."<u></u><u></u></span></p></td>

								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$price."<u></u><u></u></span></p></td>								

								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><div>

								<p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$qnty."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p>

								</div></td>								

								<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$subtotl."<u></u><u></u></span></p></td>							

							</tr>";						  

						}				

						}

						}


				/*$str.="<tr>

							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Shipping & Handling price varies<u></u><u></u></span></p></td>

							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><a href='' target='_blank'>Login</a></span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>

					  </tr>";*/

			  

				$str.="<tr>

							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Grand Total</span></strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>

							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><b><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."$".number_format($gtotal, 2)."</span></b></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>
					  </tr>";			  

	  			$str.="</tbody></table>";

			

			$this->email($str,$email);
			

			if(isset($_SESSION['kit_quote']) && !empty($_SESSION['kit_quote'])){

				unset($_SESSION['kit_quote']);	

			}			

			

			$_SESSION['thanks']='Thank you for submitting your quote to MedicalShipment. We will review the information provided and get back to you as soon as possible. If you have any further questions, or would like to speak with a representative directly, please call 1-847-253-3000. Thank you for giving MedicalShipment the chance to earn your business!';

			$url="'".SITE_PATH.'index.php?controller=thanks&function=index'."'";

			echo "<script>window.location=$url</script>";		

		}

		

	}

	

	function email($message,$user_email){	  

		$to="quotes@medicalshipment.com,".trim($user_email);

		$subject="MedicalShipment - Nursing Kit Quote";

		$headers="MIME-Version: 1.0" . "\r\n";

		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";

		$headers.='From: <quotes@medicalshipment.com>'."\r\n";

		//$headers.='Cc: myboss@example.com'."\r\n";

		$exp=explode(',',$to);

		foreach($exp as $to){

			@mail($to,$subject,$message,$headers);

		}

	  

	}

	

	function remove(){

		

		if(isset($_GET['pid'])){

			

			$pid=intval($_GET['pid']);

			$arrArgument['table']='kit_quote';

			$arrArgument['where']='product_id='.$pid;

			$arrArgument['path']='';

			$imageColumn=array();

			$arrArgument['imageColumn']=$imageColumn;

			loadModel('medical','removeRecord',$arrArgument);

		

		}

		

		$url="'".SITE_PATH.'index.php?controller=kit_quote&function=index'."'";

		echo "<script>window.location=$url</script>";

		

	}



	public function listing(){
		
	  if(session()->get('user_id')){
		
	  $arrValue = array();
	  	  
	  $arrArgument['table']='kit_quote';
	  $where=array('user_id'=>intval(trim($_SESSION['front_id'])));
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='quote_id';
	  $arrValue['kit_quote']=Helper::instance()->getRecord($arrArgument);

	  return view('frontwebsite.kit-quote-listing',$arrValue);
		
		} else {
	  	return redirect()->to('login_user');
	  }	
		
	}


    function detail(){
	  
	  $url = base64_encode('index.php?controller=kit_quote&function=detail');
	  $this->isLogin($url);
		

	  # Build Query

	  $arrArgument['join']='INNER JOIN';
	  $arrArgument['where']=intval(trim($_GET['id']));
	  $arrValue['quote']=loadModel('medical','joinUserProductKitQuote',$arrArgument);

	  
	  # Get Order Detail
/*
	  $arrArgument['table']='orders';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='order_id ASC';

	  $arrValue['order']=loadModel('medical','getRecord',$arrArgument);

	  
	  # Get Order Billing Detail

	  $arrArgument['table']='order_billing_detail';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='obd_id ASC';

	  $arrValue['billing']=loadModel('medical','getRecord',$arrArgument);

	  

	  # Get Order Shipping Detail

	  $arrArgument['table']='order_shipping_detail';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='osd_id ASC';

	  $arrValue['shipping']=loadModel('medical','getRecord',$arrArgument);*/
	  

	  loadView('header.php');
	  loadView('kit-quote-detail.php', $arrValue);
	  loadView('footer.php');	   

   } 
   
   function place_order(){
	  
	  $url = base64_encode('index.php?controller=kit_quote&function=listing');
	  $this->isLogin($url);		

	  # Build Query
	  unset($_SESSION['kit']);

	  $arrArgument['join']='INNER JOIN';
	  $arrArgument['where']=intval(trim($_GET['id']));
	  $arrValue['quote']=loadModel('medical','joinUserProductKitQuote',$arrArgument);
	  
	  foreach($arrValue['quote'] as $post)
	  {
		  # Add to Kit		  
		  $arrArgument['product_id']=intval($post['product_id']);
		  $arrArgument['product_quantity']=intval(trim($post['pa_quantity']));
		  
		  $bag = mysql_fetch_array(mysql_query("SELECT * FROM `kit_bags` where id=".$post['kit_bag_id']));
		  
		  $_SESSION['bag_id']    = $post['kit_bag_id'];
		  $_SESSION['bag_qty']   = $post['kit_prop_bag_qty'];
		  $_SESSION['bag_price'] = $post['kit_prop_bag_price'];
		  $_SESSION['bag_title'] = $bag['bag_title'];
		  $_SESSION['bag_img']   = IMAGE_PATH_KIT_BAG.$bag['bag_image'];

		  loadModel('medical','addKit',$arrArgument);
		  
	  }
	  
	  header("Location: ".SITE_PATH."/index.php?controller=kit_cart&function=payment");	   

   }
}
