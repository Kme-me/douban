/**
 * 前段登录业务类
 * @author sunchao
 */
var login = {
	check : function(){
		//获取输入的用户名和密码
		var username = $('input[name="username"]').val();
//		alert(username);
		var password = $('input[name="password"]').val();

		if(!username){
			dialog.error('用户名不能为空');
		}
		if(!password){
			dialog.error('密码不能为空');
		}

		//执行异步请求   $.post
		var url = "./admin.php?&c=login&a=check";
		var data = {'username':username,'password':password};
		$.post(url,data,function(reuslt){
			if(reuslt.status == 0){
				return dialog.error(reuslt.message);
			}
			if(reuslt.status == 1){
				return dialog.success(reuslt.message,'./admin.php?c=index');
			}
		},'JSON');

	}
}