$(function(){
	try{
		init_p002();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_p002(){
	initevent_p002();
    getQuestion();
    if(parent._popup_transfer_array['parent_width']<500){
        $('.fieldsLinker').addClass('mobile');
        $('.fieldsLinker canvas').height($('.fieldsLinker .FL-left').height()-5);
    }
}

function initevent_p002(){
	$(document).on('click','#btn-list',function(){
		p002_execute(1);
	})

    $(document).on('click','#btn-refresh',function(){
        clearDataSearch();
    })

    $(document).on('click','#btn-close',function(){
        parent.$('.fancybox-close').trigger('click');
    })
    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        p002_execute(parseInt(page, 10));
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

    $(document).on('click','.btn-add',function(){
        var tr_clone = $(this).closest('tr');
        tr_clone.find('.btn-add').find('span').removeClass().addClass('fa fa-close');
        tr_clone.find('.btn-add').removeClass().addClass('btn btn-danger btn-delete-row');
        $('.table-refer tbody').append(tr_clone);
    })

    $(document).on('click','.btn-delete-row',function(){
        $(this).closest('tr').remove();
    })

    // $(document).on('click','#btn-save',function(){
    //     p002_refer();
    // })
}

function p002_execute(page){
	var data=getInputData();
    data['row_id'] = parent._popup_transfer_array['row_id']==undefined?-1:parent._popup_transfer_array['row_id'];
    data['selected_list'] = typeof getVocabularyList()[0]!='undefined'?getVocabularyList():'';
    _pageSize=50;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/popup/p002',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res).promise().done(function(){
                $('#result .preview').tooltip({
                    animated: 'fade',
                    trigger: 'hover',
                    placement: 'left',
                    delay: { show: 100, hide: 100 },
                    html: true
                });
            });
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function p002_load(){
    var data = {};
    data['voc_array'] =  parent._popup_transfer_array['voc_array'];
    $.ajax({
        type: 'POST',
        url: '/popup/p002/load',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result1').html(res).promise().done(function(){
                $('#result1 .preview').tooltip({
                    trigger: 'hover',
                    animated: 'fade',
                    placement: 'left',
                    delay: { show: 100, hide: 100 },
                    html: true
                });
            });
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function p002_refer(){
    var data = getVocabularyList();
    data['row_id_parent'] = parent._popup_transfer_array['row_id'];
    $.ajax({
        type: 'POST',
        url: '/popup/p002/refer',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            parent.$('#voc-content .vocabulary-box[target-id='+(res.row_id==''?-1:res.row_id)+']').removeClass('vocabulary-box').addClass('old-content hidden');
            parent.$('#voc-content').append(res.view);
            parent.$('#voc-content .vocabulary-box[target-id='+(res.row_id==''?-1:res.row_id)+']:not(.old-content)').addClass('new-content');
            parent.jQuery.fancybox.close();
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getVocabularyList(){
    var data =[];
    $('.table-refer tbody tr:visible').each(function(){
        data.push({'row_id':$(this).find('td[refer_id=row_id]').text(),'id':$(this).find('td[refer_id=id]').text()});
    })
    if(data.length==0){
        return {};
    }
    return $.extend({}, data);
}

function getQuestion() {
    var input = {
        "localization":{
        },
        "options":{
            "associationMode":"oneToOne", // oneToOne,manyToMany
            "lineStyle":"square-ends",
            // "buttonErase":"Erase Links",
        },
            "Lists":[
                {
                    "name":"Từ Tiếng Anh",
                    "list" : parent._popup_transfer_array['voc'].map(function (value,index){return value['from'];}),
                },
                {
                    "name":"Nghĩa",
                    "list" : parent._popup_transfer_array['mean'].map(function (value,index){return value['to'];}),
                }
                ],
    };
    
    fieldLinks=$("#bonds").fieldsLinker("init",input);
    // $('[data-toggle="tooltip"]:visible').tooltip();
    $("#btn-save").on("click",function(){
        var results = fieldLinks.fieldsLinker("getLinks");
        var count = 0;
        // $("#Output").html("output => " + JSON.stringify(results.links));
        // $("#Output1").html("output1 => " + JSON.stringify(parent._popup_transfer_array['voc']));
        for (var i = 0; i < results.links.length; i++) {
            for (var j = 0; j < parent._popup_transfer_array['voc'].length; j++) {
                if(JSON.stringify(parent._popup_transfer_array['voc'][j]) == JSON.stringify(results.links[i])){
                    count++;
                    break;
                } 
            }
        }
        if(count == parent._popup_transfer_array['voc'].length){
            showMessage(28,function(){

            });
        }else{
            showMessage(29,function(){},function(){},[count,parent._popup_transfer_array['voc'].length]);
            // alert('Bạn mới chỉ đạt được '+count+'/'+parent._popup_transfer_array['voc'].length+' câu đúng!');
        }
    });
}

function setInputQuestion(){
    for (var i = 0; i < parent._popup_transfer_array['voc'].length; i++) {
        parent._popup_transfer_array['voc'][i]
    }
}