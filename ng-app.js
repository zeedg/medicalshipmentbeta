(function () {
		/*initiating angular app */
		var app = angular.module('medicalngapp' , []);
		
		/*
		* angular modules and controller things 
		* */
		app.controller('sliderController' , function ($http) {
				var mainCtrl = (this);
				$http({
						method : 'get' ,
						url : baseurl + "/angular/slider"
				}).success(function (res) {
						mainCtrl.res;
				})
		});
})();