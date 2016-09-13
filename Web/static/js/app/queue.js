define(function(){
	var _object = {
		/**
		 * 获取排队数据
		 */
		getQueueList:function(){
			//滑动切换
			//mui效果
			mui.init({
				//右滑关闭
				swipeBack:false
			});
			mui('.mui-scroll-wrapper').scroll({
				//是否显示滚动条
				indicators:true
			});
		
			//滑动切换事件
			document.getElementById('slider').addEventListener('slide',function(e){
				//桌型ID
				var dkid = 0;
				var index_item = null;
				
				$.each($(".mui-slider-item"),function(i,item){
					var class_item = $(item).attr('class');
					var is_active = class_item.indexOf('mui-active');
					if( is_active != -1 ) {
						dkid = $(item).attr('dkid');
						index_item = item;
					}
				});
				
				if( dkid != 0 ){
					//console.log(queue_module);
					mui.ajax({
						url:'Controller/Queue.php?action=list',
						type:'post',
						headers:{'Content-Type':'application/json'},
						data:{"token":token,"dkId":dkid},
						dataType:'json',
						success:function(result){
							//console.log(result);return;
							if(result.statusCode != 1){
								mui.toast(result.statusMsg);
								return ;
							}
							
							//排队列表
							var queuelist = result.queueList;
							if( queuelist && queuelist.length > 0 ){
								var queuelist_tag = '<ul class="mui-table-view">';
								
								$.each(queuelist , function(i,item){
									//console.log(item);
									queuelist_tag += '<li class="mui-table-view-cell">'+
													 	'<span>'+item.queueCode+'</span>'+
													 	'<span style="float:right;"><button type="button" class="mui-btn mui-btn-danger">叫号</button></span>'+
													 '</li>';
								});
								
								queuelist_tag += '</ul>';
							}else{
								var queuelist_tag = '<ul class="mui-table-view"><li class="mui-table-view-cell row-not-data">暂无数据！</li></ul>';
							}
							
							
							if( index_item != null ){
								$(index_item).html(queuelist_tag);
							}
						},
						error:function(){
							mui.toast("服务器错误，请稍后再试！");
						}
					});
				}
				
				
			});
		}
		
	};
	
	return _object;
});
