function submitForm(link = null){
	if(link != null){
		$('form#myForm').attr('action', link);
	}
	$('form#myForm').submit();
}

function addNew(link){
	window.location.href = link;
}

function ajaxStatus(url){
	$.get(url, function(data){
		var element		= 'i#status-' + data['id'];
		var classRemove = 'fa-check-square-o';
		var classAdd 	= 'fa-square-o';
		if(data['status']==1){
			classRemove = 'fa-square-o';
			classAdd 	= 'fa-check-square-o';
		}
		$(element).attr('onclick', "javascript:ajaxStatus('"+data['link']+"')");
		$(element).removeClass(classRemove).addClass(classAdd);
		//Share_url in Controller: Article
		if(typeof data['share_url'] != undefined){
			$('td#share_url-' + data['id']).html(data['share_url']);
		}
		$('#alert').html(data['alert']).show(1000).delay(1500).hide(1000);
		
	}, 'json');
}

function ajaxGroupACP(url){
	$.get(url, function(data){
		var element		= 'i#groupACP-' + data['id'];
		var classRemove = 'fa-check-square-o';
		var classAdd 	= 'fa-square-o';
		if(data['group_acp']==1){
			classRemove = 'fa-square-o';
			classAdd 	= 'fa-check-square-o';
		}
		$(element).attr('onclick', "javascript:ajaxGroupACP('"+data['link']+"')");
		$(element).removeClass(classRemove).addClass(classAdd);
		$('#alert').html(data['alert']).show(1000).delay(1500).hide(1000);
	}, 'json');
}


function showTotalItemCheck(total){
	if(total > 0){
		$("a[data-show-item='yes'] span").remove();
		$("a[data-show-item='yes']").prepend('<span class="badge bg-green">'+ total +'</span>');
	}else{
		$("a[data-show-item='yes'] span").remove();
	}
}

$(document).ready(function(){

	/*=========== iCheck ===============*/
	// iCheck for checkbox and radio inputs
	$('input[type="checkbox"]').iCheck({
		checkboxClass : 'icheckbox_minimal',
	});

	// When unchecking the checkbox
	$("#check-all").on('ifUnchecked', function(event) {
		// Uncheck all checkboxes
		$("input[type='checkbox']").iCheck("uncheck");
		showTotalItemCheck(0);
	});

	// When checking the checkbox
	$("#check-all").on('ifChecked', function(event) {
		// Check all checkboxes
		$("input[type='checkbox']").iCheck("check");
		var totalCheck = $("table tbody input[type=checkbox]").length;
		showTotalItemCheck(totalCheck);
	});		
	
	var totalItemChecked = 0;
	$("table tbody input[type=checkbox]").on('ifChecked', function(event){
		totalItemChecked +=1;
		showTotalItemCheck(totalItemChecked);
	});
	
	$("table tbody input[type=checkbox]").on('ifUnchecked', function(event){
		totalItemChecked -=1;
		showTotalItemCheck(totalItemChecked);
	});

	/*========================HIDE ALERT===========================*/
	$('div.alert').delay(2000).hide(1000);
});

