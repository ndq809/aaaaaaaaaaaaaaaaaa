$(function(){
	try{
		init_p001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_p001(){
	initevent_p001();
    p001_execute();
}

function initevent_p001(){
	$(document).on('click','#btn-list',function(){
		p001_execute(1);
	})

    $(document).on('click','#btn-refresh',function(){
        clearDataSearch();
    })
    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        p001_execute(parseInt(page, 10));
    })

    $(document).on('dblclick','.table-refer tr',function(){
        var refer_text='';
        _this=$(this);
        if(_this.find('.refer-item').length==0){
            return;
        }
        $(this).find('.refer-item').each(function(i){
            if(i!==_this.find('.refer-item').length-1){
                refer_text+=$(this).text()+"_";
            }
            else{
                refer_text+=$(this).text();
            }
        })
        parents = parent.$('[data-refer=p001]');
        parents.val(refer_text);
        parents.trigger('change');
        parent.jQuery.fancybox.close();
    })
}

function p001_execute(page){
	var data=getInputData();
    _pageSize=50;
    data['page_size'] = _pageSize;
    data['page'] = page;
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