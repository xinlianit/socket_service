//模块加载完毕
require(['angular','member','mui','zepto'],function(angular,member){
	//调用登录
	var token = localStorage.getItem('pai_staff_token');
	if( token == null )
		member.login(angular);
});
