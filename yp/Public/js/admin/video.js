/**
 * 视频上传功能
 */
$(function() {
    $('#video_upload').uploadify({
        'swf'      : SCOPE.ajax_upload_swf,
        'uploader' : SCOPE.ajax_upload_video_url,
        'buttonText': '上传视频',
        'fileTypeDesc': 'MP4 Files',
        'fileObjName' : 'file',
        //允许上传的文件后缀
        'fileTypeExts': '*.mp4',
        'onUploadSuccess' : function(file,data,response) {
            // response true ,false
            if(response) {
                var obj = JSON.parse(data); //由JSON字符串转换为JSON对象

                console.log(data);
                $('#' + file.id).find('.data').html(' 上传完毕');

                $("#upload_code_video").attr("src",obj.data);
                $("#file_upload_video_url").attr('value',obj.data);
                $("#upload_code_video").show();

            }else{
                alert('上传失败');
            }
        },
    });
});





