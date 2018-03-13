jQuery(document).ready(function(){ 	
	jQuery('.hover').popover({  
		title: popoverContent,  
		html: true,  
		placement: 'center',  
		trigger: 'hover'
	});    
	function popoverContent() {  
		var content = '';  
		var element = $(this);  
		var id = element.attr("id");  
		$.ajax({  
			url: "load_data.php",  
			method: "POST",  
			async: false,  	
			data:{	
				id : id
			},  
			dataType: "JSON",
			success:function(data){  
				content = $("#popover_html").html();				
				//content = content.replace(/p_image/g, data.image);
				content = content.replace(/p_id/g, data.id);	
				content = content.replace(/p_name/g, data.email);	
				content = content.replace(/p_address/g, data.address);
				content = content.replace(/p_gender/g, data.status);
				content = content.replace(/p_design/g, data.date);	
				content = content.replace(/p_age/g, data.leftcount);
				content = content.replace(/p_rightcount/g, data.rightcount);
				content = content.replace(/p_bal/g, data.total_bal);
				content = content.replace(/p_sid/g, data.under_userid);			
			}  
		});  
		return content;  
	}  
});  

