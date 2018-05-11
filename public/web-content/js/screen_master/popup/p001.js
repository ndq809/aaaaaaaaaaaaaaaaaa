$(function(){
	try{
		init_p001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_p001(){
	initevent_p001();
}

function initevent_p001(){
	$(document).on('click','#btn-list',function(){
		p001_execute();
	})

    $(document).on('click','#btn-refresh',function(){
        clearDataSearch();
    })
}

function p001_execute(){
	var data=getInputData();
	$.ajax({
        type: 'POST',
        url: '/master/popup/p001',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res);
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}