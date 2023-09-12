//jQuery.noConflict();
jQuery(document).ready(function () {
    function urlParam(name) {
        var results = window.location.href;
        var param_arr = results.split('&');
        var value_arr = new Array();
        for (var i = 0; i < param_arr.length; i++) {
            var tmp1 = param_arr[i].split('=');
            value_arr[tmp1[0]] = tmp1[1];
        }
        if (value_arr['virtuemart_product_id'])
            return value_arr['virtuemart_product_id'];
        else
            return value_arr['virtuemart_product_id[]'];
    }
    var form = "<div>" +
            "<form style='width: 60%; padding: 10px; margin: 10px; border: 1px solid #CCCCCC;' id='jmsForm' enctype='multipart/form-data' action='index.php' name='jmsForm' method='post'>" +
            "<h3 style='margin:5px 10px;'>JMS Multiupload Plugin</h3>" +
            "<span class='btn btn-success fileinput-button' style='color:#fff;background: #5BB75B; box-shadow: none; text-shadow: none; border: 0px none; margin: 5px 10px;'>" +
            "<i class='icon-plus icon-white'></i>" +
            "<span>Select files...</span>" +
            "<input id='fileupload' type='file' name='files[]' multiple >" +
            "</span>" +
            "<br>" +
            "<div id='jms_uploading_warning' style='display: none;text-align: center;font-size: 16px; margin-bottom: 20px;margin-bottom: 20px;'>Your images are uploading, please wait for this message to disappear...</div>" +
            "<div id='progress' class='progress progress-success progress-striped'>" +
            "<div class='bar'></div>" +           
            "</div>" +           
            "<div id='files' class='files'></div>" +
            //"<table role='presentation' class='table table-striped'><tbody class='files'></tbody></table>" +
            "<input type='hidden' name='option' value='com_jmsmultiupload' />" +
            "<input type='hidden' name='view' value='upload' />" +
            "<input type='hidden' name='tmpl' value='component' />" +
            "<input type='hidden' name='virtuemart_product_id' value='" + urlParam('virtuemart_product_id') + "' />" +
            "</form>" +
            "</div>";
    jQuery('#admin-content').append(form);
});

jQuery(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = 'index.php?option=com_jmsmultiupload&view=upload&type=ajax&tmpl=component';
    var fileCount = 0;
    var number_of_files = 0;
    var total = 0;
    var num_total = 0;
    jQuery('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).bind('fileuploadadd', function (e, data) {
        number_of_files++;
        data.context = jQuery('<div/>').appendTo('#files').css('position', 'relative');
        jQuery.each(data.files, function (index, file) {
            var node = 	jQuery('<p/>')
            			.append(jQuery('<span/>').text(file.name).css({'float': 'right', 'position': 'absolute', 'top': '0px', 'right': '0px'}));;
            node.appendTo(data.context);
            //console.log(file.name);
        });
        
    }).bind('fileuploadprocessalways', function (e, data) {
        var index = data.index,        
			        file = data.files[index],
			        node = jQuery(data.context.children()[index]);
        if (file.preview) {
            node.prepend('<br>')
                .prepend(file.preview)
                ;
        }
        //scroll down
        jQuery('html,body').animate({scrollTop: jQuery( "#jmsForm" ).offset().top});
        jQuery('#jms_uploading_warning').css({
            'display' : 'block'
        });
    }).bind('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total);
        num_total = 100 / number_of_files;
        total += num_total;
        jQuery('#progress .bar').css({
            'width': total + '%'
        });
        //alert(num_total);
//        jQuery('#progress1 .bar').css({
//            'width': total + '%',
//            'background': '#5bb75b'
//        });
    }).bind('fileuploaddone', function (e, data) {
        fileCount++;
        if (fileCount === number_of_files) {
        	location.reload();
        }
    }).bind('fileuploadfail', function (e, data) {
        fileCount++;
        if (fileCount === number_of_files) {
        	location.reload();
        }
    });


});