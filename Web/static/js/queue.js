require(['mui'],function(){
	//连接WebSocket
	var ws = new WebSocket('ws://192.168.3.100:3456');
	
	//监听连接
	ws.onopen = function(){
		var data = '{"action":"login","token":"'+token+'","shopid":"'+staff_info.shopid+'"}';
		ws.send(data);
	};
	
	//监听消息
	ws.onmessage = function(message){
		console.log(message);
		var data = JSON.parse(message.data);
		
		//心跳回应
		if(data.type && data.type == 'ping'){
			ws.send('{"action":"pong"}');
		}
		
		if( data.statusCode != 1 ){
			if(data.statusCode == '-1'){
				mui.confirm(data.statusMsg,"提示",["确定","取消"],function(i){
					if(i.index == 0){
						localStorage.removeItem('pai_staff_token');
						localStorage.removeItem('pai_staff_info');
						window.location.reload();
					}
				});
			}
			
			return ;
		}
		
		//验证成功
		//mui.toast(data.statusMsg);
		if(data.type && data.type == 'queue'){
			var html = '';
		    for(var i in data.dkList){
		    	var class_id = (i == 0) ? '' : 'listbr';
		    	
		    	var nowNum = data.dkList[i].nowCallNum;
		    	if( nowNum == '' || nowNum == 0 ){
		    		nowNum = '—';
		    	}
		    	
		    	var loadCount = data.dkList[i].listCount;
		    	if( loadCount == '' || loadCount == 0 )
		    		loadCount = '—';
		    	else
		    		loadCount+= '桌';
		    	html +='<li class="list '+class_id+'">' +
							'<div class="left">' +
								'<h3>'+data.dkList[i].dkName+'</h3>' +
								'<span class="tips">'+data.dkList[i].minNum+'-'+data.dkList[i].maxNum+'人</span>' +
							'</div>' +
							'<div class="center">' +
								'<h3>'+nowNum+'</h3>' +
							'</div>' +
							'<div class="right">' +
								'<span>当前排队:'+loadCount+'</span>' +
							'</div>' +
						'</li>';
		    }
		    
		    if( html == '' )
		    	html = '<li class="list" style="border:none;"><div style="height:100px;line-height:100px;text-align:center;">暂无排队数据！</div></li>';
		    
		    document.getElementById("list_c").innerHTML = html;
		}
	};
	
	//监听错误
	ws.onerror = function(error){
		console.log(error);
		mui.alert('连接发生错误');
	};
	
	//监听断开连接
	ws.onclose = function(message){
		mui.alert('连接已断开');
	}
});
