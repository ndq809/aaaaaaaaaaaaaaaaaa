$(function(){
	try{
		init_m004();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_m004(){
	initevent_m004();
}

function initevent_m004(){
	$(document).on('click','#btn-add',function(){
		execute();
	})
}

function execute(){
	var data=getInputData();
	$.ajax({
        type: 'POST',
        url: '/master/data/m004',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    showMessage(2);
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}