@extends('frontwebsite._mainLayout')
@section('content')

<style type="text/css">
.context {
	margin-left: 0;
	width: 220px;
}
p a {
	color: #2692da;
}
p .ul {
	text-decoration: underline;
	font-size: 18px;
}
p label {
	color: mediumseagreen;
}
.h1 {
	text-align: left;
}
.rightbtns {
	width: auto
}
.contant-con p {
	padding: 0;
	line-height: 30px;
}
h2 {
    font-weight: 700;
    font-size: 21px;
    line-height: 1.3;
}
.a-alert-success {
    border: 1px solid #7fc87f;
}
.a-box .a-box-inner {
    border-radius: 4px;
    position: relative;
    padding: 1px 18px;
}
.a-color-success {
    color: #008a00!important;
	margin: 0;
}
.a-icon, .a-link-emphasis:after {
    background-image: url(https://images-na.ssl-images-amazon.com/images/G/01/AUIClients/AmazonUIBaseCSS-sprite_1x-8fe8c701c7a6f38368f97a8a3f04d5f25875be4d._V2_.png);
    background-repeat: no-repeat;
    -webkit-background-size: 400px 650px;
    background-size: 400px 650px;
    display: inline-block;
    vertical-align: top;
}

.a-alert-success .a-icon-alert {
    background-position: -318px -35px;
}
.a-alert .a-icon-alert {
    height: 27px;
    left: 18px;
    position: absolute;
    top: 20px;
    width: 30px;
}
.a-alert-success .a-alert-container {
    padding-left: 60px;
	padding-bottom: 55px;
    box-shadow: 0 0 0 4px #dff7df inset;
}
.a-row {
    width: 100%;
}
.a-row .a-span7, .a-ws .a-row .a-ws-span7 {
    /*width: 57.448%;*/
	width:100%;
	padding-top:18px;
}
.subHeadingOnly {
    display: none;
    margin-top: 0px !important;
}
.a-ws div.a-column, div.a-column {
    margin-right: 2%;
    min-height: 1px;
    overflow: visible;
}
.a-text-bold {
    font-weight: 700!important;
}
</style>

<div class="container">
<div class="row main-contant">
  <div class="container contant-con">
    <div class="col-lg-12">
      <h1 class="h1">Thank You</h1>
    </div>
    <div class="col-lg-12">
      <div class="a-box a-alert a-alert-success">
        <div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i>
          <div class="a-alert-content">
            <div class="a-row">
              <div class="a-column a-span7"> <?php echo @stripslashes(session()->get('thanks'))?> </div>
            </div>
          </div>
          <div class="col-lg-12">
            <p style="float:right"> <a href="{{ url('/') }}">
              <input class="button2 btn-proceed-checkout btn-checkout2 btncart add_cart" value="Continue Shopping" type="submit" style="width: 220px; margin-bottom: 0px !important; color: #FFF;">
              </a> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection()