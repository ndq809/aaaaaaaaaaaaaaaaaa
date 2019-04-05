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
		window.open('/master/writing/w002?'+parent._popup_transfer_array['post_id'], '_blank');
	})

    $(document).on('click','#btn-select',function(){
        parent._popup_transfer_array['called_item'].closest('tr').find('input[type=checkbox]').prop('checked',true);
        parent._popup_transfer_array['called_item'].closest('tr').find('input[type=checkbox]').trigger('change');
        parent.jQuery.fancybox.close();
    })

    $(document).on('click','#btn-refresh',function(){
        p004_execute(parent._popup_transfer_array['post_id']);
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

    $(document).on('click','.preview-audio',function(){
        $(this).parents('table').find('audio').each(function(){
            if(!$(this)[0].paused){
                $(this)[0].pause();
                $(this)[0].currentTime = 0;
            }
        });
        $(this).parent().find('audio')[0].play();
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
            $('#result').html(res).promise().done(function(){
                $('.preview').attr('data-toggle','tooltip');
                $('.preview').attr('data-placement','top');
                $('.preview').tooltip({
                    animated: 'fade',
                    placement: 'right',
                    html: true
                });
            });
            if($('#post_type').val()==8){
                var player;
                $('#video-player').mediaelementplayer({
                    success: function(mediaElement, domObject) {
                        player = mediaElement;
                        mediaElement.removeEventListener('loadedmetadata');
                        mediaElement.addEventListener('loadedmetadata', function(e) {
                            var temp = $(mediaElement).find('iframe');
                            if(typeof temp !='undefined' && temp.parent().height()> temp.parent().width()){
                                temp.css('min-width','0px');
                                temp1 =$('.mejs__mediaelement').height() / temp.parent().height() ; 
                                temp.parents('.fb-video').css('width',temp.parents('.fb-video').width()*temp1);
                                temp.parents('.fb-video').css('height',temp.parents('.fb-video').height()*temp1);
                            }
                        }, false);
                    },
                });
                player.load();
            }
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