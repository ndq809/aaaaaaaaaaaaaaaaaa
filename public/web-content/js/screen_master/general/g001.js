var data_delete=[];
$(function(){
	try{
		init_g001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_g001(){
	initevent_g001();
    initImageUpload();
    getSalary();
}

function initevent_g001(){
	$(document).on('click','#btn-save',function(){
        showMessage(1,function(){
            g001_updateProfile();
       });
	})

    $(document).on('click','#btn-statistic',function(){
        g001_statistic();
    })

    $(document).on('click','#btn-change-pass',function(){
        showMessage(1,function(){
            g001_changepass();
       });
    })

    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })
}

function g001_updateProfile(){
	var data_addnew=getInputData(1);
	$.ajax({
        type: 'POST',
        url: '/master/general/g001/updateprofile',
        dataType: 'json',
        loading:true,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    showMessage(22,function(){
                        $('#menu1 img').attr('src',res.avarta);
                    });
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error);
                    break;
                 case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
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

function g001_changepass(){
    var data = getInputData(2,'.change-pass');
    $.ajax({
        type: 'POST',
        url: '/master/general/g001/changepass',
        dataType: 'json',
        loading:true,
        data: data,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    showMessage(2,function(){
                        $('.change-pass input.submit-item').val('');
                    });
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error,2,'.change-pass');
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
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

function g001_statistic(){
    var data = {};
    data['date_from'] = $('#date-from').val();
    data['date_to'] = $('#date-to').val();
    $.ajax({
        type: 'POST',
        url: '/master/general/g001/statistic',
        dataType: 'html',
        loading:true,
        data: data,//convert to object
        success: function (res) {
            $('#result').html(res); 
            getSalary();                   
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getSalary(){
    var sum = 0;
    $('.bill').each(function(){
        sum += Number($(this).text().replace(/,/g, ''));
    })
    $('#salary').text(sum);
    $('#salary').trigger('blur');
}