//控制器测试
angular.module('member', []).controller('login', function( $scope , $http ) {
	//$scope.shopcode = '';
	$scope.submit_login = function(){
		$http({
			method:'post',
			url:'Controller/Member.php?action=login',
			data:{
					shopcode:$scope.shopcode,
					account:$scope.account,
					passwd:$scope.passwd
			}
		}).success(function(response){
			if(response.statusCode != 1){
				alert(response.statusMsg);
				return;
			}
			console.log(response);
		}).error(function(e){
			console.error(e);
		});
	}
});