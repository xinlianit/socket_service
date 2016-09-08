<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>账户登录</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<?php include_once 'Include/head.php';?>
	</head>

	<body>
		<div class="mui-content">
			<div class="mui-content-padded">
				<form class="mui-input-group login" name="member" ng-app="member" ng-controller="login" novalidate>
			    	<div class="login-msg">
			    		<span ng-show="member.shopcode.$dirty && member.shopcode.$invalid">
				    		<span ng-show="member.shopcode.$error.required">商户ID必须</span>
				    	</span>
				    	<span ng-show="member.account.$dirty && member.account.$invalid">
				    		<span ng-show="member.account.$error.required">用户名必须</span>
				    	</span>
				    	<span ng-show="member.passwd.$dirty && member.passwd.$invalid">
				    		<span ng-show="member.passwd.$error.required">密码必须</span>
				    	</span>
			    	</div>
				    <div class="mui-input-row">
				        <label>商户ID：</label>
				    	<input type="text" class="mui-input-clear" placeholder="请输入商户ID" name="shopcode" ng-model="shopcode" required>
			    	</div>
				    <div class="mui-input-row">
				        <label>用户名：</label>
				    <input type="text" name="account" ng-model="account" class="mui-input-clear" placeholder="请输入用户名" required>
				    </div>
				    <div class="mui-input-row">
				        <label>密码：</label>
				        <input type="password" name="passwd" ng-model="passwd" class="mui-input-password" placeholder="请输入密码" required>
				    </div>
				    <div class="mui-button-row">
				        <button type="button" ng-click="submit_login()" class="mui-btn mui-btn-primary" ng-disabled="member.shopcode.$error.required || member.account.$error.required || member.passwd.$error.required || member.shopcode.$dirty && member.shopcode.$invalid || member.account.$dirty && member.account.$invalid || member.passwd.$dirty && member.passwd.$invalid">确认</button>
				    </div>
				    
				</form>
			</div>
		</div>
		<?php include_once 'Include/comm.php';?>
		<script type="text/javascript" src="static/js/angular_test.js">
			
		</script>
	</body>

</html>