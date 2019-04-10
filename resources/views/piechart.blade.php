<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
        <ul class="bg-danger"></ul>
    </div>
  </div>
  

  <?php 

// print_r($oneweek_piechart);
// echo "<br>";
// print_r($onday_piechart);
// echo "<br>";
// print_r($onemonth_piechart);
// echo "<br>";
// print_r($threemonths_piechart);
// echo "<br>";
// print_r($sixmonths_piechart);
// echo "<br>";
// print_r($oneyear_piechart);


  ?>




<link href="pie/examples.css" rel="stylesheet" type="text/css">
<style type="text/css">
.demo-container {
  position: relative;
  height: 400px;
}
#placeholder, #placeholder1 {
  width: 550px;
}
#menu {
  position: absolute;
  top: 20px;
  left: 625px;
  bottom: 20px;
  right: 20px;
  width: 200px;
}
#menu button {
  display: inline-block;
  width: 200px;
  padding: 3px 0 2px 0;
  margin-bottom: 4px;
  background: #eee;
  border: 1px solid #999;
  border-radius: 2px;
  font-size: 16px;
  -o-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  -ms-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  -moz-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  cursor: pointer;
}
#description {
  margin: 15px 10px 20px 10px;
}
#code {
  display: block;
  width: 870px;
  padding: 15px;
  margin: 10px auto;
  border: 1px dashed #999;
  background-color: #f8f8f8;
  font-size: 16px;
  line-height: 20px;
  color: #666;
}
ul {
  font-size: 10pt;
}
ul li {
  margin-bottom: 0.5em;
}
ul.options li {
  list-style: none;
  margin-bottom: 1em;
}
ul li i {
  color: #999;
}
</style>
<script language="javascript" type="text/javascript" src="pie/jquery.js"></script>
<script language="javascript" type="text/javascript" src="pie/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="pie/jquery.flot.pie.js"></script>
<script type="text/javascript">

  $(function() {

    // Example Data

    //var data = [
    //  { label: "Series1",  data: 10},
    //  { label: "Series2",  data: 30},
    //  { label: "Series3",  data: 90},
    //  { label: "Series4",  data: 70},
    //  { label: "Series5",  data: 80},
    //  { label: "Series6",  data: 110}
    //];

    var data = [
      { label: "Today",  data: <?php echo number_format($onday_piechart,2,".","")?>},
      { label: "Weekly",  data: <?php echo number_format($oneweek_piechart,2,".","")?>},
      { label: "Monthly",  data: <?php echo number_format($onemonth_piechart,2,".","")?>},
      { label: "Quarter",  data: <?php echo number_format($threemonths_piechart,2,".","")?>},
      { label: "6 Months",  data: <?php echo number_format($sixmonths_piechart,2,".","")?>},
      { label: "Yearly",  data: <?php echo number_format($oneyear_piechart,2,".","")?>}
    ];

    //var data = [
    //  { label: "Series A",  data: 0.2063},
    //  { label: "Series B",  data: 38888}
    //];

    // Randomly Generated Data

    /*var data = [],
      series = Math.floor(Math.random() * 6) + 3;

    for (var i = 0; i < series; i++) {
      data[i] = {
        label: "Series" + (i + 1),
        data: Math.floor(Math.random() * 100) + 1
      }
    }*/

    var placeholder = $("#placeholder");

      placeholder.unbind();

    $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 1,
            label: {
              show: true,
              radius: 3/4,
              formatter: labelFormatter,
              background: {
                opacity: 0.5
              }
            }
          }
        },
        legend: {
          show: false
        }
      });
      
  });

  // A custom label formatter used by several of the plots

  function labelFormatter(label, series) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
  }


  </script>
<div id="page-wrapper">
  <div class="row"> 
    <!-- Page Header -->
    <div class="col-lg-12">
      <h1 class="page-header">Website Sales Data (Pie Chart)</h1>
    </div>
    <!--End Page Header --> 
  </div>
  <div class="row">
    <div class="col-lg-12" style="height: 15px;">
      <div class="demo-container">
        <div id="placeholder" class="demo-placeholder"></div>
      </div>
      <p id="description"></p>
    </div>
    
  </div>
  
  
</div>

<!-- end wrapper --> 

<!-- Core Scripts - Include with every page --> 
<!-- 
<script src="<?php ///echo SITE_PATH?>assets/plugins/bootstrap/bootstrap.min.js"></script> 
<script src="<?php //echo SITE_PATH?>assets/plugins/metisMenu/jquery.metisMenu.js"></script> 
<script src="<?php //echo SITE_PATH?>assets/plugins/pace/pace.js"></script> 
<script src="<?php //echo SITE_PATH?>assets/scripts/siminta.js"></script> 


<script src="<?php //echo SITE_PATH?>calendar/tcal.js"></script>
<link rel="stylesheet" type="text/css" href="<?php //echo SITE_PATH?>calendar/tcal.css" /> -->

<!-- End Calendar -->



  <!-- /.row -->
</section>
<!-- /.content -->


<!------- footer ------>
@include('footer')