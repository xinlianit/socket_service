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

//模块加载完毕
require(['angular','member','mui','zepto'],function(angular,member){
	//调用登录
	var token = localStorage.getItem('pai_staff_token');
	if( token == null )
		member.login(angular);
});
