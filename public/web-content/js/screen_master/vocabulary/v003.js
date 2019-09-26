var word_div_array =
[   
    'danh từ & phó từ'
,   'phó từ & tính từ'
,   'tính từ & phó từ'
,   'giới từ & phó từ'
,   'phó từ,  tính từ'
,   'phó từ & giới từ'
,   'ngoại động từ'
,   'nội động từ'
,   'thán từ'
,   'liên từ'
,   'tính từ'
,   'động từ'
,   'trạng từ'
,   'giới từ'
,   'mạo từ'
,   'phó từ'
,   'danh từ'
,   ''
];

var cal_div_array = ['','kinh tế','kỹ thuật'];

var field_array = 
[   'toán & tin'
,   ''
,   'cơ khí & công trình'
,   'điện lạnh'
,   'điện tử & viễn thông'
,   'xây dựng'
,   'điện'
,   'ô tô'
,   'âm nhạc'
,   'giao thông & vận tải'
,   'y học'
,   'hàng hải'
,   'kiến trúc'
,   'đo lường & điều khiển'
,   'hóa học & vật liệu'
,   'pháp lý'
,   'trò chơi'
,   'toán học'
,   'vật lí'
,   'chứng khoán'
,   'động vật'
,   'tư pháp'
,   'thơ ca'
,   'quân sự'
,   'vật lý'
,   'sinh học'
,   'giải phẫu'
,   'thực vật'
,   'sinh vật học'
,   'thiên văn học'
,   'văn học'
,   'thương nghiệp'
,   'tôn giáo'
,   'địa lý,địa chất'
,   'ngôn ngữ học'
,   'sử học'
,   'kỹ thuật'
,   'dệt may'
,   'chính trị'
,   'môi trường'
,   'tin học'
,   'thực phẩm'
,   'hóa học'
,   'thể thao'
,   'hóa'
,   'hình học'
,   'sân khấu'
,   'khoáng'
,   'triết học'
,   'nghệ thuật'
,   'sinh vật'
,   'luật'
,   'toán'
,   'máy tính'
,   'điện học'
,   'khí tượng'
,   'ngôn ngữ'
,   'tâm lý học'
,   'hàng không'
,   'ngành mỏ'
,   'y'
,   'địa chất'
,   'tài chính'
,   'nông nghiệp'
,   'ngoại giao'
,   'hoá học'
];

var _mode = 0;

$(function(){
	try{
		init_v003();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_v003(){
	initevent_v003();
    v003_execute();
}

function initevent_v003(){
	$(document).on('change','#block_no',function(){
		// showMessage(1,function(){
            v003_execute();
       // });
	})

    $(document).on('focus','.table input,.table textarea',function(){
        $('.active-row').removeClass('active-row');
        $(this).closest('tr').addClass('active-row');
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

    $(document).on('click','.btn-prev',function(){
        var temp = (Number($('#block_no').val()==''?0:$('#block_no').val()) - 1)<0?0:(Number($('#block_no').val()==''?0:$('#block_no').val()) - 1);
        $('#block_no').val(temp);
        $('#block_no').trigger('change');
    })

    $(document).on('click','.btn-next',function(){
        var temp = Number($('#block_no').val()==''?0:$('#block_no').val()) + 1;
        $('#block_no').val(temp);
        $('#block_no').trigger('change');
    })

    $(document).on('click','#btn-save',function(){
        // showMessage(1,function(){
            _mode = 0;
            v003_save();
       // });
    })

    $(document).on('click','#btn-execute',function(){
        showMessage(1,function(){
            _mode = 1;
            v003_save();
       });
    })

    $(document).on('focus','#import-data tbody input',function(){
        $(this).select();
    })

    $(document).on('addrow','.btn-add',function(){
        $(this).parents('table').find('tbody textarea.auto-resize').autoResize();
    })

    // $(document).on('click','#btn-upgrade',function(){
    //     if($('#vocabulary_id').val()!='' && $('#vocabulary_dtl_id').val()!=''){
    //         showMessage(15,function(){
    //             v003_upgrage();
    //        });
    //     }
    // })

    // $(document).on('click','.btn-copy',function(){
    //     var copy_row=$(this).parents('tr').clone();
    //     copy_row.addClass('copy-tr');
    //     copy_row.find('input,select').prop('disabled',false);
    //     copy_row.find('input[type=checkbox]').prop('checked',true);
    //     copy_row.find('input[type=checkbox]').prop('disabled',true);
    //     $(this).parents('tbody').append(copy_row);
    //     reIndex($('.submit-table'));
    // })

    // $(document).on('change','.sub-checkbox',function(){
    //     updateDeleteArray(this);
    // })

    // $(document).on('change','#catalogue_div',function(){
    //     $('.old-content').addClass('hidden');
    //     switch(media_div){
    //     case 0:
    //         break;
    //     case 1:
    //         $(".old-input-audio").closest('.old-content[transform-div='+$(this).val()+']').removeClass('hidden');
    //         break;
    //     case 2:
    //         $(".old-input-image-custom").closest('.old-content[transform-div='+$(this).val()+']').removeClass('hidden');
    //         break;

    //     }
    //     _this=$(this);
    //     var sub_item=$('.transform-content').filter(function(){
    //         return $(this).attr('transform-div').indexOf(_this.val())>=0;
    //     })
    //     sub_item.show();
    //     transform();

    //     updateCatalogue(this);
    // })

    // $(document).on('change','#catalogue_nm',function(){
    //     updateGroup(this);
    // })

    // $(document).on('change','#vocabulary_id,#vocabulary_dtl_id',function(){
    //     if($('#vocabulary_id').val()!='' && $('#vocabulary_dtl_id').val()!=''){
    //         v003_refer();
    //     }
    //     })

    // $(document).on('change','#post_title',function(){
    //     if($(this).val()!=''){
    //         $('.title-header span').text($(this).val());
    //     }else{
    //         $('.title-header span').text('Tiêu đề bài viết');
    //     }
    // })

}

function v003_save(){
    var data=getWordTableData($('#import-data'));
    if(data.length==0){
        $('.btn-next').trigger('click');
        return;
    }
    data['page'] = $('#block_no').val()==''?0:$('#block_no').val();
	$.ajax({
        type: 'POST',
        url: '/master/vocabulary/v003/save',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    if(_mode==0){
                        // param = {};
                        // param['timeout'] = 200;
                        // param['buttons'] = [];
                        // param['onClose'] = function(){
                        //     $('.btn-next').trigger('click');
                        // };
                        // showMessage(2,function(){},function(){},param);
                        $('.btn-next').trigger('click');
                    }else{
                        $('.btn-next').trigger('click');
                    }
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
                case 209:
                    clearFailedValidate();
                    showMessage(12);
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

function v003_execute(){
    var data={};
    data['page']=$('#block_no').val()==''?0:$('#block_no').val();
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/v003/excute',
        dataType: 'json',
        loading:true,
        data: $.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    // showMessage(2,function(){
                    //     $('#vocabulary_id').trigger('change');
                    // });
                    var result = [];
                    $.each(res.data,function(i){
                        result.push(analysis(res.data[i]));
                    })
                    // result.push(analysis(res.data[4]));
                    showData(result);
                    var data=getWordTableData($('#import-data'));
                    if(data.length==0){
                        $('.btn-next').trigger('click');
                        return;
                    }
                    if(_mode==1){
                        v003_save();
                    }
                    break;
                case 201:
                    _mode = 0;
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

function analysis(sentence){
    result = {};
    var temp = sentence.split('|||');
    result['word'] = [];
    result['spell'] = [];
    result['word_div'] = {};
    result['specialized'] = {};
    result['field'] = {};
    result['mean'] = [];
    result['word'].push(temp[0].trim());
    for (var i = 1; i < temp.length; i++) {
        switch(temp[i].charAt(0)){
            case '/': 
                result['spell'].push(temp[i].trim());
                break;
            case '*':
                result['word_div'][temp[i].substring(1).trim()]={};
                for (var j = i+1; j < temp.length; j++) {
                    if(temp[j]!=undefined && temp[j].charAt(0)=='-'){
                        result['word_div'][temp[i].substring(1).trim()][j]=temp[j].substring(1).trim();
                    }else{
                        i=(j!=temp.length-1?j-1:j);
                        break;
                    }
                }
                i=(j!=temp.length-1?j-1:j);
                break;
            case '-':
                result['mean'].push(temp[i].substring(1).trim());
                break;
            case '~':
                result['field'][temp[i].substring(1).trim()]={};
                for (var j = i+1; j < temp.length; j++) {
                    if(temp[j]!=undefined && temp[j].charAt(0)=='-'){
                        result['field'][temp[i].substring(1).trim()][j]=temp[j].substring(1).trim();
                    }else{
                        i=(j!=temp.length-1?j-1:j);
                        break;
                    }
                }
                i=(j!=temp.length-1?j-1:j);
                break;
            case '>':
                var field = temp[i].substring(1).trim();
                result['specialized'][field]={};
                for (var j = i+1; j < temp.length; j++) {
                    switch(temp[j].charAt(0)){
                        case '-':
                            result['specialized'][field][j]=temp[j].substring(1).trim();
                            i=(j!=temp.length-1?j-1:j);
                            break;
                        case '~':
                            var field_sub = temp[j].substring(1).trim();
                            result['specialized'][field][field_sub]={};
                            for (var k = j+1; k < temp.length; k++) {
                                if(temp[k]!=undefined && temp[k].charAt(0)=='-'){
                                    result['specialized'][field][field_sub][k]=temp[k].substring(1).trim();
                                }else{
                                    j=(k!=temp.length-1?k-1:k);
                                    break;
                                }
                                j=(k!=temp.length-1?k-1:k);
                            }
                            i=(j!=temp.length-1?j-1:j);
                            break;
                        case '>':
                            i=(j!=temp.length-1?j-1:j);
                            j = temp.length;
                            break;
                        default:
                            break;
                    }
                }
                break;
            default :
                break;
        }
    }
    return $.extend({}, result);
}

function showData(data){
    $('#import-data tbody tr:visible').remove();
    // $.each(data,function(i){
    //     // $.each(data[i]['mean'], function(j){
    //     if(data[i]['mean'].length!=0){
    //         createRow(data[i]['word'][0],'','',data[i]['word_div'][0],data[i]['spell'][0],createWordMean(data[i]['mean']),'');
    //     }
    //     // })
    //     $.each(data[i]['word_div'], function(j){
    //         // $.each(data[i]['word_div'][j], function(k){
    //         if(!jQuery.isEmptyObject(data[i]['word_div'][j])){
    //             createRow(data[i]['word'][0],'','',j,data[i]['spell'][0],createWordMean(data[i]['word_div'][j]),'');
    //         }
    //         // })
    //     })
    //     $.each(data[i]['field'], function(j){
    //         // $.each(data[i]['field'][j], function(k){
    //         if(!jQuery.isEmptyObject(data[i]['field'][j])){
    //             createRow(data[i]['word'][0],'',k,data[i]['word_div'][0],data[i]['spell'][0],createWordMean(data[i]['field'][j]),'');
    //         }
    //         // })
    //     })
    //     $.each(data[i]['specialized'], function(j){
    //         if(createWordMean(data[i]['specialized'][j])!=''){
    //             createRow(data[i]['word'][0],j,'',data[i]['word_div'][0],data[i]['spell'][0],createWordMean(data[i]['specialized'][j]),'');
    //         }
    //         $.each(data[i]['specialized'][j],function(k,word){
    //             if(isNaN(k)){
    //                 // $.each(data[i]['specialized'][j][k], function(m,word){
    //                 if(!jQuery.isEmptyObject(data[i]['specialized'][j][k])){
    //                     createRow(data[i]['word'][0],j,k,data[i]['word_div'][0],data[i]['spell'][0],createWordMean(data[i]['specialized'][j][k]),'');
    //                 }
    //                 // })
    //              }
    //         })
            
           
    //     })


    // })

    $.each(data,function(i){
        $.each(data[i]['mean'], function(j,word){
        // if(data[i]['mean'].length!=0){
            createRow(data[i]['word'][0],'','',data[i]['word_div'][0],data[i]['spell'][0],word,'');
        // }
        })
        $.each(data[i]['word_div'], function(j){
            $.each(data[i]['word_div'][j], function(k,word){
            // if(!jQuery.isEmptyObject(data[i]['word_div'][j])){
                createRow(data[i]['word'][0],'','',j,data[i]['spell'][0],word,'');
            // }
            })
        })
        $.each(data[i]['field'], function(j){
            $.each(data[i]['field'][j], function(k,word){
            // if(!jQuery.isEmptyObject(data[i]['field'][j])){
                createRow(data[i]['word'][0],'',k,data[i]['word_div'][0],data[i]['spell'][0],word,'');
            // }
            })
        })
        $.each(data[i]['specialized'], function(j){
            if(createWordMean(data[i]['specialized'][j])!=''){
            }
            $.each(data[i]['specialized'][j],function(k,word){
                if(isNaN(k)){
                    $.each(data[i]['specialized'][j][k], function(m,word1){
                    // if(!jQuery.isEmptyObject(data[i]['specialized'][j][k])){
                        createRow(data[i]['word'][0],j,k,data[i]['word_div'][0],data[i]['spell'][0],word1,'');
                    // }
                    })
                 }else{
                    createRow(data[i]['word'][0],j,'',data[i]['word_div'][0],data[i]['spell'][0],word,'');
                 }
            })
            
           
        })

        
    })
    reIndex($('#import-data'));
    $('#import-data').find('.textarea-temp').remove();
    $('#import-data').find('tbody textarea.auto-resize').autoResize().trigger('change');
}
function createRow(word,specialized,field,word_div,spell,mean,explan){
    var temp1 = mean;
    if(mean.charAt(0)=='('){
        temp = mean.substring(1,mean.indexOf(')'));
        switch(temp.toLowerCase()){
            case 'tech' :
                specialized = (specialized==''?'kỹ thuật': specialized);
                temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                break;
            case 'econ' :
                specialized = (specialized==''?'kinh tế': specialized);
                temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                break;
            case  'động vật học' :
                field = (field==''?'động vật': field);
                temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                break;
            case  'thực vật học' :
                field = (field==''?'thực vật': field);
                temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                break;
            case  'nhạc' :
                field = (field==''?'âm nhạc': field);
                temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                break;
            case  'thể dục,thể thao' :
                field = (field==''?'thể thao': field);
                temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                break;
            case  'sử' :
                field = (field==''?'sử học': field);
                temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                break;
            case  'giải phẩu học' :
                field = (field==''?'giải phẫu': field);
                temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                break;
            default :
                var check = 0;
                if($.inArray(temp,field_array)!=-1){
                    field = temp.toLowerCase();
                    temp1 = mean.substring(mean.indexOf(')')+1,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
                }
                break;
        }
    }else{
        temp1 = mean.substring(0,mean.indexOf('=')==-1?mean.length:mean.indexOf('=')).trim();
    }
    for (var i = 0; i < word_div_array.length; i++) {
        if(word_div!=undefined && word_div_array[i]!=''&& word_div.indexOf(word_div_array[i])!=-1){
            word_div = word_div_array[i];
            break;
        }
    }
    for (var i = 0; i < field_array.length; i++) {
        if(word_div!=undefined && field_array[i]!=''&& word_div.indexOf(field_array[i])!=-1){
            field = field_array[i];
            word_div = '';
            break;
        }
    }
    mean = temp1;
    var rowClone= $('#rowclone').clone();
    var audio = '/web-content/dictonary/audio/'+word.replace(/"/g, '').charAt(0).replace(/"/g, '').toLowerCase()+'/'+word.trim().replace(/"/g, '')+'.wav';
    rowClone.find('[refer-id=word]').val(word);
    rowClone.find('[refer-id=specialized]').val(specialized);
    rowClone.find('[refer-id=field]').val(field);
    rowClone.find('[refer-id=word_div]').val(word_div);
    rowClone.find('[refer-id=spell]').val(spell);
    rowClone.find('[refer-id=mean]').val(mean);
    // rowClone.find('[refer-id=audio]').append('<audio class="sound1" src="'+audio+'"/></audio>');
    // rowClone.find('[refer-id=audio]').append('<a type="button" class="preview-audio">Nghe thử</a>');
    rowClone.find('[refer-id=audio]').append('<input type="text" class="sound1" value="'+audio+'"/>');
    rowClone.removeClass('hidden');
    var isinput = true;
    rowClone.find('[refer-id]').each(function(){
        switch($(this).attr('refer-id')){
            case 'word' :
                if($(this).val().indexOf('=')!=-1||$(this).val().indexOf('-')!=-1){
                    isinput = false;
                }
                break;
            case 'specialized' :
                if($.inArray($(this).val(),cal_div_array)==-1){
                    isinput = false;
                }
                break;
            case 'field' :
                if($.inArray($(this).val(),field_array)==-1){
                    isinput = false;
                }
                break;
            case 'word_div' :
                if($.inArray($(this).val(),word_div_array)==-1){
                    isinput = false;
                }
                break;
            case 'spell' :
                if($(this).val()!=''&&($(this).val().match(/[/]/gi)!=null&&$(this).val().match(/[/]/gi).length!=2)){
                    isinput = false;
                    if($(this).val()!=''){
                        word_index = $(this).val().indexOf("("+rowClone.find('[refer-id=word]').val()+")")==-1?0:$(this).val().indexOf(rowClone.find('[refer-id=word]').val());
                        first_postion = $(this).val().indexOf('/',word_index);
                        last_postion = $(this).val().indexOf('/',first_postion+1);
                        rowClone.find('[refer-id=spell]').val($(this).val().substring(first_postion,last_postion+1));
                    }
                }
                break;

        }
    })
    if(mean.indexOf('/')==-1){
        $('#import-data tbody').append(rowClone);
    }
}

function createWordMean(data){
    var result ='';
    if(typeof data =='array'){
        result = data.join(' | ');
    }else{
        $.each(data, function(i,value){
            if(!isNaN(i)){
                result += value+' | '; 
            }
        })
        result = result.substring(0,result.length-2);
    }
    return result;
}

function getWordTableData(table){
    var data=[];
    var temp = '';
    var word_id = 0;
    var word_dtl_id = 0;
    table.find('tbody tr:visible').each(function(i){
        var row_data={};
        row_data['row_id']=i;
        if($(this).find('textarea[refer-id=word]').val().trim()!=temp){
            word_id++;
            word_dtl_id = 0;
        }else{
            word_dtl_id++;
        }
        row_data['word_id']=word_id;
        row_data['word_dtl_id']=word_dtl_id;
        $(this).find('input[refer-id],td[refer-id],textarea[refer-id]').each(function(){
            if($(this).hasClass('money')){
                var text = jQuery.grep($(this).val().split(','), function(value) {
                  return value;
                });
                row_data[$(this).attr('refer-id')]=text.join('');
            }else
            if($(this).hasClass('tel')){
                var text = jQuery.grep($(this).val().split('-'), function(value) {
                  return value;
                });
                row_data[$(this).attr('refer-id')]=text.join('');
            }else
            if($(this).hasClass('audio')){
                row_data[$(this).attr('refer-id')]=$(this).find('input').val();
            }else{
                row_data[$(this).attr('refer-id')]=$(this).val();
            }
        })
        temp = $(this).find('textarea[refer-id=word]').val();
        data.push(row_data);
    })
    if(data.length==0){
        return [];
    }else{
        return $.extend({}, data);
    }
}