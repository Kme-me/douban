/**
 * 添加按钮操作
 * @author sunchao
 */


/**
 * 菜单管理的“添加”按钮操作
 */
$("#button-add").click(function(){
	var url = SCOPE.add_url;
	window.location.href=url;
});

/**
 * 提交“添加”页面中的from表单操作
 */
$("#singcms-button-submit").click(function(){
    var data = $('#singcms-form').serializeArray();
    postData={};
    $(data).each(function(){
        postData[this.name]=this.value;
    });
    //console.log(postData);
    
    
    //将获取的数据post给服务器
    var url=SCOPE.save_url;
    var jump_url=SCOPE.jump_url;
    $.post(url,postData,function(result){
        if(result.status==1){
            //成功
            return dialog.success(result.message,jump_url);
        }else if(result.status==0){
            //失败
            return dialog.error(result.message);
        }
    },"json");
    
});


/*
编辑模型
 */
$(".singcms-table #singcms-edit").on('click',function(){
    var id = $(this).attr('attr-id');
    var url = SCOPE.edit_url+'&id='+id;
    window.location.href=url;
});



/**
 * 排序操作
 */
$('#button-listorder').click(function() {
    // 获取 listorder内容
    var data = $("#singcms-listorder").serializeArray();
    postData = {};
    $(data).each(function(i){
        postData[this.name] = this.value;
    });
    console.log(data);
    var url = SCOPE.listorder_url;
    $.post(url,postData,function(result){
        if(result.status == 1) {
            //成功
            return dialog.success(result.message,result['data']['jump_url']);
        }else if(result.status == 0) {
            // 失败
            return dialog.error(result.message,result['data']['jump_url']);
        }
    },"JSON");
});


/**
 * 修改文章状态的操作JS
 */
$('.singcms-table #singcms-on-off').on('click',function(){
    var id = $(this).attr('attr-id');
    var status = $(this).attr("attr-status");
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = id;
    data['status'] = status;

    layer.open({
        type : 0,
        title : '是否提交？',
        btn: ['yes', 'no'],
        icon : 3,
        closeBtn : 2,
        content: "是否确定更改状态",
        scrollbar: true,
        yes: function(){
            // 执行相关跳转
            todelete(url, data);
        },
    });

});

/**
 * 推送的JS的相关代码
 */
$("#singcms-push").click(function(){
    var id = $("#select-push").val();
    //alert(id);
    if(id==0){
        return dialog.error("请选择推荐位");
    }
    push = {};
    postData = {};
    $("input[name='pushcheck']:checked").each(function(i){
        push[i] = $(this).val();
    });

    postData['push'] = push;
    postData['position_id'] = id;
    //console.log(postData);return;//打印传递过来的数据
    var url =SCOPE.push_url;
    $.post(url,postData,function(result){
        if(result.status == 1){
            //TODO
            return dialog.success(result.message,result['data']['jump_url']);
        }
        if(result.status == 0){
            //TODO
            return dialog.error(result.message);
        }
    },"json");
});
//
/**
 *查询操作
 */
function list_nj(){
    var nj_name = $('[name=school_nj] option:selected').val();
    var km_name = $('[name=school_km] option:selected').val();
    var search = $('#search').val();
        $.ajax({
            url:"admin.php?c=video&a=chaxun",
            data:{'nj': nj_name,'km':km_name,'search':search},
            dataType:'json',
            type:'get',
            success:function(msg){                               
                 $('table tr:gt(0)').remove();
                 var html = '';
                  for(var i=0; i<msg.length; i++){
                    html += "<tr id='video_"+msg[i].id+"'>";
                    html += "<td><input type='checkbox' name='pushcheck' value='"+msg[i].id+"'/></td>";
                    html += "<td><input size=4 type='text'  name='listorder[{"+msg[i].id+"' value='"+msg[i].listorder+"'/></td>";
                    html += "<td>"+msg[i].id+"</td>";
                    html += "<td>"+msg[i].school_nj+"</td>";
                    html += "<td>"+msg[i].school_km+"</td>";
                    html += "<td>"+msg[i].school_ls+"</td>";
                    html += "<td>"+msg[i].school_kt+"</td>";
                    html += "<td>"+msg[i].create_time+"</td>";
                    html += "<td>";
                    html += "<a href='./admin.php?c=video&a=showlist&id="+msg[i].id+"'>";
                    html += "<span class='sing_cursor glyphicon glyphicon-edit' aria-hidden='true' id='singcms-edit' attr-id='"+msg[i].id+"' ></span>";
                    html += "</a>&#8197";
                    html += "<a href='javascript:;' id='singcms-delete'  attr-id='"+msg[i].id+"'  attr-message='删除'>";
                    html += "<span class='glyphicon glyphicon-remove-circle' aria-hidden='true' ></span>";
                    html += "</a>&#8197";
                    html += "<a  href=./admin.php?c=video&a=liulan&id='"+msg[i].id+"' class='sing_cursor glyphicon glyphicon-eye-open' aria-hidden='true'  ></a>";
                    html += "</td></tr>";
                    if(msg[i].search == '1'){
                      
                         $('#search').val('');//清空search框
                         $("#nj option:first").prop("selected", 'selected');//重置
                         $("#km option:first").prop("selected", 'selected');
                }
                
              }
              $('table').append(html);
            },
           error: function(){
             alert(123);
           }
     });
}



/**
 * 删除操作JS
 */
$(document).on('click','.singcms-table #singcms-delete',function(){
    var id = $(this).attr('attr-id');
    var a = $(this).attr("attr-a");
    var message = $(this).attr("attr-message");
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = id;
    data['status'] = -1;

    layer.open({
        type : 0,
        title : '是否提交？',
        btn: ['yes', 'no'],
        icon : 3,
        closeBtn : 2,
        content: "是否确定"+message,
        scrollbar: true,
        yes: function(){
            // 执行相关跳转
            todelete(url, data);
        },
    });

});
function todelete(url, data) {
    console.log(data);
    $.post(
        url,
        data,
        function(s){
            if(s.status == 1) {
                //return dialog.success(s.message,'/tyhcms/admin.php?c=menu');
                // 跳转到相关页面,'空'的话，默认不跳转
                return dialog.success(s.message,'');                

            }else {
                return dialog.error(s.message);
            }
        }
        ,"JSON");
}


