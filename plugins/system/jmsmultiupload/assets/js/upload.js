(function () {	
	var input = jQuery("#jmsimages"), 
	formdata = false;
	function showUploadedItem (source) {
  		var list = jQuery("#image-list");
  		var li = "<li><img src='"+source+"' /></li>";  		  		
		list.append(li);
	}   

	if (window.FormData) {		
  		formdata = new FormData();
  		jQuery("#btn").hide();
	}		
	jQuery("#jmsimages").change(function() {
		jQuery("#response").html("Uploading . . .");
 		var i = 0, len = this.files.length, img, reader, file;
	
		for ( ; i < len; i++ ) {
			file = this.files[i];
	
			if (!!file.type.match(/image.*/)) {
				if ( window.FileReader ) {
					reader = new FileReader();
					reader.onloadend = function (e) { 
						showUploadedItem(e.target.result, file.fileName);
					};
					reader.readAsDataURL(file);
				}
				if (formdata) {
					formdata.append("images[]", file);
				}
			}	
		}
	
		if (formdata) {
			$.ajax({
				url: "upload.php",
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (res) {
					jQuery("#response").html(res); 
				}
			});
		}
	}, false);
}());
