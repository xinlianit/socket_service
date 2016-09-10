require.config({
	//模块路径
	baseUrl:'static/js/app',
	//常量路径
	paths:{
		'mui':'../lib/mui.min',
		'angular':'../lib/angular.min',
		'zepto':'../lib/zepto.min',
	},
	//支持非AMD规范的第三方插件
	shim:{
		 'angular': {
		 	//调用变量名
            exports: 'angular',
            //依赖包
            //deps:"",
        },
	},
});

//path_info
var url = window.location.href;
var path_info = url.split('/');
var action = path_info.pop();

//登录验证
var token = localStorage.getItem('pai_staff_token');
if( action == 'login.php' ){
	if( token != null ) {
		window.location.href = 'queue.html';
	}
}else{
	if( token === null ) {
		window.location.href = 'login.php';
	}
}

var staff_info = localStorage.getItem('pai_staff_info');
if( staff_info != null ){
	staff_info = JSON.parse( staff_info );
}

switch( action ){
	//登录
	case 'login.php':
		require(['../login']);
	break;
	//排队
	case 'queue.html':
		require(['../queue']);
	break;
}

