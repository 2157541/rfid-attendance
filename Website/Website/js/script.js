$(document).ready(function(){
    $('.school').on('change', function(){
        var school_id = $(this).val();
        if(school_id){
            $.ajax({
                type:'POST',
                url:'ajaxDropdown.php',
                data:'school_id='+school_id,
                success:function(data){
                    $('.course').html(data);
                }
            });
        }else{
            $('.course').html('<option value="">Select school first</option>');
        }
    });
});


function delete_confirm_schedule(){
	if($('.checkbox:checked').length > 0){
		var result = confirm("Are you sure to delete selected schedule(s)? \r\nNOTICE! \r\nPlease Select a schedule with a 0 participants. Otherwise the selected schedule(s) will not be deleted.");
		if(result){
			return true;
		}else{
			return false;
		}
	}else{
		alert('Select at least 1 schedule to delete');
		return false;
	}
}
function delete_confirm(){
	if($('.checkbox:checked').length > 0){
		var result = confirm("Are you sure to delete/move selected participant(s)?");
		if(result){
			return true;
		}else{
			return false;
		}
	}else{
		alert('Select at least 1 participant to delete/move.');
		return false;
	}
}
