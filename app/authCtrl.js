app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};
    $scope.doLogin = function (customer) {
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
    $scope.signup = {email:'',password:'',username:'',user_id:'',staff_id:''};
    $scope.signUp = function (customer) {
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('setting');
            }
        });
    };
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    };
    function cancelAdd(){
        $location.path('setting');
    };
});

app.controller('settingCtrl',['$scope', '$http', '$location', '$route', '$routeParams' , function ($scope, $http, $location, $route, $routeParams) {
    getData();
    function getData(){
        $http.post('setting.php').success(function(data){
            $scope.database = data;    
        });
    };

    $scope.deleteData = function(uid){
        var uid = uid;
        $http.post('delete.php',{'uid':uid}).then(function(response){
            $route.reload();
        });
    };

    $scope.addData = function(customer){
        $http.post('insert.php', customer).then(function(response){
            $location.path('setting');
        });
    };

    $scope.updateData = function(uid){
        $http.post('update.php', uid).then(function(response){
            $location.path('setting');
        });
    };

    $scope.showData = function(){
        var uid = $routeParams.uid;
        $http.post('selectone.php',{'uid':uid}).then(function(response){
            var database  = response.data;
            $scope.x = database[0];
        });
    };
}]);