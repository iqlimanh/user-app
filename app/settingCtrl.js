app.controller('settingCtrl',['$scope', '$http' , function ($scope, $http) {
    getData();
    function getData(){
    	$http.post('setting.php').success(function(data){
    		$scope.database = data;
    	});
    }
}]);