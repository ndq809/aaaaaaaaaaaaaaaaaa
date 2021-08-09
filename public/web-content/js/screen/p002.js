var level = 0;
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
        if(level==0){
            parent._popup_transfer_array['voc'] = shuffle(JSON.parse(JSON.stringify(parent._popup_transfer_array['voc'])));
            parent._popup_transfer_array['mean'] = shuffle(JSON.parse(JSON.stringify(parent._popup_transfer_array['mean'])));
            $('#test1').html('');
            getQuestion();
        }else{
            $('#test2 table tbody tr:visible').remove();
            setInputQuestion();
        }
    })

    $(document).on('click','#btn-close',function(){
        parent.$('.fancybox-close').trigger('click');
    })
    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        p002_execute(parseInt(page, 10));
    })

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
        "existingLinks" : []
    };
    
    fieldLinks=$("#test1").fieldsLinker("init",input);
    // $('[data-toggle="tooltip"]:visible').tooltip();
    $("#btn-check").off("click");
    $("#btn-check").on("click",function(){
        switch(level){
            case 0 :
                var results = fieldLinks.fieldsLinker("getLinks");
                var count = 0;
                for (var i = 0; i < results.links.length; i++) {
                    for (var j = 0; j < parent._popup_transfer_array['voc'].length; j++) {
                        if(JSON.stringify(parent._popup_transfer_array['voc'][j]) == JSON.stringify(results.links[i])){
                            count++;
                            break;
                        } 
                    }
                }
                if(count == parent._popup_transfer_array['voc'].length){
                    var param = {};
                    param['buttons'] = [
                        {
                            label: 'Ải kế tiếp ➡',
                            classes: 'btn btn-sm btn-success float-right',
                            action: function(){
                                $('.test1').addClass('hidden');
                                $('.test2').removeClass('hidden');
                                setInputQuestion();
                                level++;
                            },
                        },
                        {
                            label: 'Kiểm tra lại',
                            classes: 'btn btn-sm btn-default float-left',
                            action: function(){
                                $('#btn-refresh').trigger('click');
                            },
                        }
                    ];
                    showMessage(28,function(){
                    },function(){},param);
                }else{
                    var param = {};
                    param['value'] = [count,parent._popup_transfer_array['voc'].length];
                    param['buttons'] = [
                        {
                            label: 'Đã hiểu',
                            classes: 'btn btn-sm btn-warning',
                        }
                    ];
                    showMessage(29,function(){},function(){},param);
                    // alert('Bạn mới chỉ đạt được '+count+'/'+parent._popup_transfer_array['voc'].length+' câu đúng!');
                }
                break;
            case 1 :
                var check = parent._popup_transfer_array['voc'].length;
                $('.voc-list:visible').each(function(i){
                    var value = $(this).val().replace(/[^a-z0-9\s]/gi, ' ').replace(/[_\s]/g, ' ').replace(/\s\s+/g, ' ').toLowerCase().trim();
                    var root_value = parent._popup_transfer_array['voc'][i]['from'].replace(/[^a-z0-9\s]/gi, ' ').replace(/[_\s]/g, ' ').replace(/\s\s+/g, ' ').toLowerCase().trim();
                    if(value!=root_value){
                        check --;
                    }
                })
                if(check == parent._popup_transfer_array['voc'].length){
                    var param = {};
                    var mission = parent.$('#do-mission').val();
                    if(mission*1==0){
                        param['label'] = ['Làm lại từ đầu','Làm lại màn này'];
                        // param['value'] = ['2114'];
                        showMessage(31,function(){
                            level = 0;
                            $('#test2 table tbody tr:visible').remove();
                            $('.test1').removeClass('hidden');
                            $('.test2').addClass('hidden');
                            parent._popup_transfer_array['voc'] = shuffle(JSON.parse(JSON.stringify(parent._popup_transfer_array['voc'])));
                            parent._popup_transfer_array['mean'] = shuffle(JSON.parse(JSON.stringify(parent._popup_transfer_array['mean'])));
                            $('#test1').html('');
                            getQuestion();
                        },function(){
                            $('#btn-refresh').trigger('click');
                        },param);
                    }else{
                        var param = {};
                        parent.completeMission(function(res){
                            param['value'] = [res.data.exp,res.data.ctp];
                            showMessage(30,function(){
                                if(res.rank['account_div']!=res.rank['account_prev_div']){
                                    var param1 = {};
                                    param1['value'] = [res.rank['account_prev_div_nm'],res.rank['account_div_nm']];
                                    showMessage(39,function(){
                                        $('#btn-close').trigger('click');
                                        parent.location.reload();
                                    },function(){},param1);
                                }else{
                                    $('#btn-close').trigger('click');
                                    parent.location.reload();
                                }
                            },function(){
                            },param);
                        })
                    }
                }else{
                    var param = {};
                    param['value'] = [check,parent._popup_transfer_array['voc'].length];
                    param['buttons'] = [
                        {
                            label: 'Đã hiểu',
                            classes: 'btn btn-sm btn-warning',
                        }
                    ];
                    showMessage(29,function(){},function(){},param);
                    // alert('Bạn mới chỉ đạt được '+count+'/'+parent._popup_transfer_array['voc'].length+' câu đúng!');
                }
                break;
            default :
            break;
        }
        
    });
}

function setInputQuestion(){
    var trClone;
    parent._popup_transfer_array['voc'] = shuffle(JSON.parse(JSON.stringify(parent._popup_transfer_array['voc'])));
    for (var i = 0; i < parent._popup_transfer_array['voc'].length; i++) {
        trClone = $('#test2 table tbody tr').first().clone();
        trClone.find('td').eq(0).text(i+1);
        trClone.find('td').eq(1).text(parent._popup_transfer_array['voc'][i]['to']);
        trClone.removeClass('hidden');
        $('#test2 table tbody').append(trClone);
    }
}