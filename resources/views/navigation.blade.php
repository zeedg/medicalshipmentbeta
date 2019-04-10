<?php
//$base_url = "http://localhost/laravel";
$base_url = url('/');
?>

<header class="main-header">
	<!-- Logo -->
	<a href="home.php" class="logo logo-left">
		<!-- TEXT -->
		<span class="logo-mini" style="text-align:center !important;"><img src="<?php echo $base_url; ?>/jscss/img/mini.png" class="" alt="Logo"/></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg" style="text-align:center;"><img width="100%" src="<?php echo $base_url; ?>/jscss/app-uploads/app-setting-uploads/mdimg.png" class="" alt="Logo"/></span>
	
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Messages: style can be found in dropdown.less-->
				<li class="dropdown messages-menu hide">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i>
						<span class="label label-success">4</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 4 messages</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<li><!-- start message -->
									<a href="#">
										<div class="pull-left">
											<img src="<?php echo $base_url; ?>/jscss/img/admin-icon.jpg" class="img-circle" alt="User Image">
										</div>
										<h4>
											Support Team
											<small><i class="fa fa-clock-o"></i> 5 mins</small>
										</h4>
										<p>Why not buy a new awesome theme?</p>
									</a>
								</li>
								<!-- end message -->
							</ul>
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
				</li>
				
				<!-- Tasks: style can be found in dropdown.less -->
				<li class="dropdown tasks-menu hide">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-flag-o"></i>
						<span class="label label-danger">9</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 9 tasks</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<li><!-- Task item -->
									<a href="#">
										<h3>
											Design some buttons
											<small class="pull-right">20%</small>
										</h3>
										<div class="progress xs">
											<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
												<span class="sr-only">20% Complete</span>
											</div>
										</div>
									</a>
								</li>
								<!-- end task item -->
							</ul>
						</li>
						<li class="footer">
							<a href="#">View all tasks</a>
						</li>
					</ul>
				</li>
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo $base_url; ?>/jscss/img/admin-icon.jpg" class="user-image" alt="User Image">
						<span class="hidden-xs">
              <span>
			  {{ Auth::user()->user_name }}
              </span>
            </span>
					</a>
					<ul class="dropdown-menu">
						
						<li class="user-header">
							<img src="<?php echo $base_url; ?>/jscss/img/admin-icon.jpg" class="img-circle" alt="User Image">
							
							<p>
								{{ Auth::user()->user_name }}
							</p>
						</li>
						
						<li class="user-footer">
							<div class="pull-left">
								<a href="{{ url('/superadminshow') }}/{{ Auth::user()->id }}" class="btn btn-default btn-flat">Profile</a>
							</div>
                            <div class="pull-left" style="margin-left:30px;">
								<a href="{{ url('/settingsshow/1') }}" class="btn btn-default btn-flat">Settings</a>
							</div>
							<div class="pull-right">
								<a href="{{ url('/main/logout') }}" class="btn btn-default btn-flat"> Logout</a>
							</div>
						</li>
						
						<?php /*?><li>
                        <ul class="sidebar-menu treeview treeview-menu">                        	
                            <li class="">
                                <a href="{{ url('view-piechart') }}"><i class="fa fa-circle-o"></i> Sales Data Pie Chart </a>
                            </li>
                            <li class="">
                                <a href="{{ url('view-barhart') }}"><i class="fa fa-circle-o"></i> Sales Data Bar Chart </a>
                            </li>
                            <li class="">
                                <a href="{{ url('order_report') }}"><i class="fa fa-circle-o"></i> Order Report </a>
                            </li>
                            <li class="">
                                <a href="{{ url('visitor_stats') }}"><i class="fa fa-circle-o"></i> Visitor Stats </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/superadminshow') }}/{{ Auth::user()->id }}"><i class="fa fa-circle-o"></i> Profile </a>
                            </li>
                            <li class="">
                                <a href="{{ url('/main/logout') }}"><i class="fa fa-circle-o"></i> Logout </a>
                            </li>
                         </ul>
                         </li><?php */?>   
						
					</ul>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<li class="hide">
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				</li>
			</ul>
		</div>
	</nav>
</header>

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo $base_url; ?>/jscss/img/admin-icon.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				
				<!-- NAME -->
			{{ Auth::user()->user_name }}
			
			<!-- END NAME -->
				
				<!-- ONLINE -->
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				<!-- END ONLINE -->
			
			</div>
		</div>
		
		<!-- search form -->
		<form action="#" method="get" class="sidebar-form hide">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
			</div>
		</form>
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			
			<!--- HOME/DASHBOARD -->
			<li class="active">
				<a href="{{ url('/main/successlogin') }}">
					<i class="fa fa-home"></i> <span>Dashboard</span>
				</a>
			</li>
			
			<li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-group"></i> <span>Manage Orders </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<!--- LINK 1 -->
					<li class="">
						<a href="#"><i class="fa fa-circle-o"></i> List Orders </a>
					</li>
					
					<!--- LINK 3 -->
					<li class="">
						<a href="#"><i class="fa fa-circle-o"></i> List Saved Orders </a>
					</li>
				
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-group"></i> <span>Manage Quotes </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<!--- LINK 1 -->
					<li class="">
						<a href="#"><i class="fa fa-circle-o"></i> List Quotes </a>
					</li>
					
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Product</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
                    <li class="">
						<a href="{{ url('/product') }}"><i class="fa fa-circle-o"></i> List Products </a>
					</li>
                    <li class="">
						<a href="{{ url('addproduct') }}"><i class="fa fa-circle-o"></i> Add new Product </a>
					</li>
				
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Import/Export Products </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('importexport') }}"><i class="fa fa-circle-o"></i> Import/Export Products </a>
					</li>
				
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Categories </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-category') }}"><i class="fa fa-circle-o"></i> List Categories </a>
					</li>
                    <li class="">
						<a href="{{ url('/addcategory') }}"><i class="fa fa-circle-o"></i> Add new Category </a>
					</li>
					
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Manufacturers </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-manufacturer') }}"><i class="fa fa-circle-o"></i> List Manufacturers </a>
					</li>
					<li class="">
						<a href="{{ url('/addmanufacturer') }}"><i class="fa fa-circle-o"></i> Add new Manufacturer </a>
					</li>
                
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Product Units </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-unit') }}"><i class="fa fa-circle-o"></i> List Product Units </a>
					</li>
					<li class="">
						<a href="{{ url('/addunit') }}"><i class="fa fa-circle-o"></i> Add new Product Unit </a>
					</li>
                    
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-group"></i> <span>Manage Customers </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-customers') }}"><i class="fa fa-circle-o"></i> List Customers </a>
					</li>
					<li class="">
						<a href="{{ url('/addcustomer') }}"><i class="fa fa-circle-o"></i> Add new Customer </a>
					</li>
                    
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Customer Addresses </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="<?= action('UbsController@index')  ?>"><i class="fa fa-circle-o"></i> List Customer Addresses </a>
					</li>
					<li class="">
						<a href="<?= action('UbsController@create')  ?>"><i class="fa fa-circle-o"></i> Add new Customer Address </a>
					</li>
                	
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Facilities </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-facility') }}"><i class="fa fa-circle-o"></i> List Facilities </a>
					</li>
					<li class="">
						<a href="{{ url('/addfacility') }}"><i class="fa fa-circle-o"></i> Add new Facility </a>
					</li>
                
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Contents </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
                    <li class="">
						<a href="{{ url('view-content') }}"><i class="fa fa-circle-o"></i> List Pages </a>
					</li>
					<li class="">
						<a href="{{ url('/addcontent') }}"><i class="fa fa-circle-o"></i> Add new Page </a>
					</li>
					
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Homepage Slider </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-slider') }}"><i class="fa fa-circle-o"></i> List Homepage Sliders </a>
					</li>
					<li class="">
						<a href="{{ url('/addslider') }}"><i class="fa fa-circle-o"></i> Add new Homepage Slider </a>
					</li>
                
				</ul>
			</li>
            
            <li class="treeview">
				<a href="">
					<i class="text text-info fa fa-cog"></i> <span>Manage Testimonials </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-testimonial') }}"><i class="fa fa-circle-o"></i> List Testimonials </a>
					</li>
					<li class="">
						<a href="{{ url('/addtestimonial') }}"><i class="fa fa-circle-o"></i> Add new Testimonial </a>
					</li>
                    
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Product Reviews </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('/review') }}"><i class="fa fa-circle-o"></i> List Product Reviews </a>
					</li>
				
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Best Sellers </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('/bestsellerupdate/1') }}"><i class="fa fa-circle-o"></i> Set Best Seller Products </a>
					</li>
				
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage Search Keywords </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-keyword') }}"><i class="fa fa-circle-o"></i> List Search Keywords </a>
					</li>
                    <li class="">
						<a href="{{ url('/addkeyword') }}"><i class="fa fa-circle-o"></i> Add new Search keyword </a>
					</li>
					
				</ul>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-cog"></i> <span>Manage News </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('news') }}"><i class="fa fa-circle-o"></i> List News </a>
					</li>
                    <li class="">
						<a href="{{ url('/news/create') }}"><i class="fa fa-circle-o"></i> Add new News </a>
					</li>
					
				</ul>
			</li>
            
            <li class="">
				<a href="{{ action('OscoSettingsController@index') }}">
					<i class="text text-info fa fa-cog"></i> <span>OSCO settings</span>
				</a>
			</li>
            
            <li class="">
				<a href="{{ action('SiteSettingsController@index') }}">
					<i class="text text-info fa fa-cog"></i> <span> Site settings</span>
				</a>
			</li>
            
            <li class="treeview">
				<a href="#">
					<i class="text text-info fa fa-group"></i> <span>Manage Admin Users </span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					
					<li class="">
						<a href="{{ url('view-adminusers') }}"><i class="fa fa-circle-o"></i> List Admin Users </a>
					</li>
                    <li class="">
						<a href="{{ url('/addadminuser') }}"><i class="fa fa-circle-o"></i> Add new Admin User </a>
					</li>
					
				</ul>
			</li>
			
			<li class="">
				<a href="{{ url('/main/logout') }}">
					<i class="fa fa-power-off text text-danger"></i> <span> Logout</span>
				</a>
			</li>
		
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="app-cover">