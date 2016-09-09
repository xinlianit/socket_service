define(function(){
	var _object = {
		//登录
		login:function(angular){
			//控制器测试
			angular.module('member', []).controller('login', function( $scope , $http ) {
				document.getElementById("log").addEventListener('tap',function(){
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
							mui.toast(response.statusMsg);
							
							return;
						}
						
						//登录成功缓存登录信息
						localStorage.setItem('pai_staff_token',response.token);
						localStorage.setItem('pai_staff_info',JSON.stringify(response.result));
						
						//跳转首页
						window.location.href = 'queue.html';
						
					}).error(function(e){
						console.error(e);
					});
				});
			});
		}
	};
	
	return _object;
});
