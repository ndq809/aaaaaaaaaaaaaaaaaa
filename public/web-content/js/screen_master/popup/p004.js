$(function(){
	try{
		init_p004();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_p004(){
	initevent_p004();
    p004_execute(parent._popup_transfer_array['post_id']);
}

function initevent_p004(){
	$(document).on('click','#btn-edit',function(){
		parent.window.location.href= 'http://eplus.win/master/writing/w002?e='+parent._popup_transfer_array['post_id'];
	})

    $(document).on('click','#btn-delete',function(){
        showMessage(3,function(){
            p004_delete();
       });
    })

    $(document).on('click','#btn-refresh',function(){
        clearDataSearch();
    })
    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        p004_execute(parseInt(page, 10));
    })

    $(document).on('dblclick','.table-refer tr',function(){
        var refer_text='';
        _this=$(this);
        parents = parent.$('[data-refer=p004]');
        if(_this.find('.refer-item').length==0){
            return;
        }
        $(this).find('.refer-item').each(function(i){
            var item = parent.$('.table tbody tr').eq(parent._popup_transfer_array['row_id']).find("."+$(this).attr('refer_id'));
            if(item.prop("tagName")=='SELECT' && $(this).text()==''){
                item.val(0);
            }else{
                item.val($(this).text());
            }
            if(item.is(":hidden")){
                item.attr('value',$(this).text());
            }
        })
        parent.jQuery.fancybox.close();
    })
}

function p004_execute(post_id){
	var data=[];
    data.push(post_id);
	$.ajax({
        type: 'POST',
        url: '/master/popup/p004',
        dataType: 'html',
        loading:true,
        data: $.extend({}, data),
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

function p004_delete(){
     var data=[];
    data.push(parent._popup_transfer_array['post_id']);
    $.ajax({
        type: 'POST',
        url: '/master/writing/w002/delete',
        dataType: 'json',
        loading:true,
        data: $.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    showMessage(2,function(){
                        parent.jQuery.fancybox.close();
                        parent.$('#btn-list').trigger('click');
                    });
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error);
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