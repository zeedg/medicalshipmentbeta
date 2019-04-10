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



<!--  page-wrapper -->
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
<script language="javascript" type="text/javascript" src="pie/jquery.flot.stack.js"></script>
<script type="text/javascript">

  $(function() {

    var d1 = [];
    d1.push([1, <?php echo number_format($onday_piechart,2,".","")?>]);
    d1.push([2, <?php echo number_format($oneweek_piechart,2,".","")?>]);
    d1.push([3, <?php echo number_format($onemonth_piechart,2,".","")?>]);
    d1.push([4, <?php echo number_format($threemonths_piechart,2,".","")?>]);
    d1.push([5, <?php echo number_format($sixmonths_piechart,2,".","")?>]);
    d1.push([6, <?php echo number_format($oneyear_piechart,2,".","")?>]);

    var stack = 0,
      bars = true,
      lines = false,
      steps = false;

    function plotWithOptions() {
      $.plot("#placeholder1", [ d1 ], {
        series: {
          stack: stack,
          lines: {
            show: lines,
            fill: true,
            steps: steps
          },
          bars: {
            show: bars,
            barWidth: 0.2
          }
        }
      });
    }

    plotWithOptions();

  });

  </script>
<div id="page-wrapper">
  <div class="row"> 
    <!-- Page Header -->
    <div class="col-lg-12">
      <h1 class="page-header">Website Sales Data (Bar Chart)</h1>
    </div>
    <!--End Page Header --> 
  </div>
  <div class="row">
    <div class="col-lg-12" style="height: 15px;">
      <div class="demo-container">
        <div id="placeholder1" class="demo-placeholder"></div>
      </div>
      <p id="description1"></p>
    </div>
  </div>
</div>




  <!-- /.row -->
</section>
<!-- /.content -->


<!------- footer ------>
@include('footer')