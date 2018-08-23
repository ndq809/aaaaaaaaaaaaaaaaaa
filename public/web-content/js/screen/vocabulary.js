var slider;
var vocabularyArray;
$(function(){
	try{
		initVocabulary();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initVocabulary(){
	initListener();
	installSlide();
	slidePositionController();
    if($('.table-click tbody tr').first().hasClass('no-data')){
        $('#catalogue_nm').trigger('change');
    }else{
        $('.table-click tbody tr:first-child').trigger('dblclick');
    }
}

function initListener(){
	$(document).on("click","button",function(e){
        e.stopPropagation();
		if($(this).attr("id")=='btn_next'){
			nextVocabulary();
		}
		if($(this).attr("id")=='btn_prev'){
			previousVocabulary();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberVocabulary($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetVocabulary($(this));
		}
        if($(this).attr("id")=='btn-add-lesson'){
            addLesson(1,$('#catalogue_nm').val(),$('#group_nm').val());
        }
        if($(this).attr("id")=='btn-contribute-exa'){
            current_id = $('.activeItem').attr('id');
            voc_infor=[];
            voc_infor.push(vocabularyArray[current_id-1]['row_id']);
            voc_infor.push(vocabularyArray[current_id-1]['id']);
            voc_infor.push($('#eng-clause').val());
            voc_infor.push($('#vi-clause').val());
            addExample(voc_infor,function(){
                $('#exam-order').val(1);
                $('#exam-order').trigger('change');
            });
        }
	});

	$(document ).on("change",":checkbox",function(){
		if(this.checked){
			$("."+$(this).attr("id")).show();
		}else{
			$("."+$(this).attr("id")).hide();
		}
	});

	$(document ).on("click",".focusable table tbody tr",function(){
		selectVocabulary($(this));
	});

	$(document ).on("click",".right-tab ul li",function(){
		switchTabVocabulary($(this));
	});
	$(window).resize(function(){
		slidePositionController();
	});

	$(document).on('keydown',function(e){
        if(!(e.target.tagName == 'INPUT' || e.target.tagName == 'TEXTAREA')){
            switch(e.which){
                case 37 :
                    previousVocabulary();
                    break;
                case 39 :
                    nextVocabulary();
                    break;
                default:
                    break;
            }
        }
    })
    $(document).on('change','#catalogue_nm',function(){
        if($('#catalogue_nm').val()!='')
    	   updateGroup(this);
    })

    $(document).on('change','#group_nm',function(){
        $('.table-click tbody tr').removeClass('selected-row');
        $('.table-click tbody tr').each(function(){
            if($(this).find('td').eq(1).text().trim()==$("#catalogue_nm option:selected").text() 
            && $(this).find('td').eq(2).text().trim()==$("#group_nm option:selected").text()){
                $(this).addClass('selected-row');
            }
        })
       getData();
    })

    $(document).on('change','#exam-order',function(){
        var page = 1;
        var current_id=$('.activeItem').attr('id');
        var item_infor=[];
        item_infor.push(vocabularyArray[current_id-1]['row_id']);
        item_infor.push(vocabularyArray[current_id-1]['id']);
        item_infor.push($('#exam-order').val());
        item_infor.push(page);
        getExample(parseInt(page, 10),item_infor,function(){
            setContentBox(current_id);
        });
    })

    $(document).on('click','.current_item',function(){
        if($('#vocal-audio').prop('checked')){
            $('.vocabulary-box').find('audio').each(function(){
                if(!$(this)[0].paused){
                    $(this)[0].pause();
                    $(this)[0].currentTime = 0;
                }
            });
            $('.vocabulary-box:visible').find('audio')[0].play();
        }
    })

    $(document).on('click', '.pager li a', function (e) {
        e.stopPropagation();
        var page = $(this).attr('page');
        var current_id=$('.activeItem').attr('id');
        var item_infor=[];
        item_infor.push(vocabularyArray[current_id-1]['row_id']);
        item_infor.push(vocabularyArray[current_id-1]['id']);
        item_infor.push($('#exam-order').val());
        item_infor.push(page);
        getExample(parseInt(page, 10),item_infor,function(){
            setContentBox(current_id);
        });
    })

    $(document).on('click', '.btn-effect', function (e) {
        e.stopPropagation();
        var _this = this;
        var current_id=$('.activeItem').attr('id');
        var item_infor=[];
        item_infor.push(vocabularyArray[current_id-1]['row_id']);
        item_infor.push($(_this).attr('id'));
        item_infor.push(1);
        item_infor.push(1);
        if($(_this).hasClass('claped')){
            item_infor.push(1);
        }else{
            item_infor.push(0);
        }
        toggleEffect(item_infor,function(effected_count){
            $(_this).toggleClass('claped tada');
            $(_this).prev('.number-clap').text(effected_count);
        });
    })
}

function installSlide(){
	$("#mySlider1").AnimatedSlider({
		visibleItems : 3,
		infiniteScroll : true,
	});
	slider = $("#mySlider1").data("AnimatedSlider");
	slider.setItem($('#tab1 table tbody tr').first().attr('id')-1);
	setContentBox($('#tab1 table tbody tr').first().attr('id'));
}

function slidePositionController(){
	var coverWidth=$(".slider-wrap").width()/2;
	$(".choose_slider_items .current_item").css("left",coverWidth-150);
	$(".choose_slider_items .previous_item").css("left",coverWidth-320);
	$(".choose_slider_items .next_item").css("left",coverWidth+20);
}

function nextVocabulary(){
	var currentItemId=setNextItem();
	slider.setItem(currentItemId-1);
	slidePositionController();
	setContentBox(currentItemId);
	$('.current_item').trigger('click');
}

function previousVocabulary(){
	var currentItemId=setPreviousItem();
	slider.setItem(currentItemId-1);
	slidePositionController();
	setContentBox(currentItemId);
	$('.current_item').trigger('click');
}

function selectVocabulary(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	slider.setItem(currentItemId-1);
	slidePositionController();
	setContentBox(currentItemId);
	$('.current_item').trigger('click');
}

function switchTabVocabulary(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
    $('.activeItem').removeClass('activeItem');
	selectVocabulary($(selectedTab+" table tbody tr" ).first());
}

function rememberVocabulary(remember_btn){
	currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor=[];
    voc_infor.push(1);
    voc_infor.push(2);
    voc_infor.push(vocabularyArray[current_id-1]['row_id']);
    voc_infor.push(vocabularyArray[current_id-1]['id']);
    if(rememberItem(currentItem,"Đã quên",voc_infor)&&remember_btn.parents("tr").hasClass('activeItem')){
        nextVocabulary();
    }
}

function forgetVocabulary(forget_btn){
	currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor=[];
    voc_infor.push(vocabularyArray[current_id-1]['row_id']);
    voc_infor.push(vocabularyArray[current_id-1]['id']);
    voc_infor.push(2);
    if(forgetItem(currentItem,"Đã thuộc",voc_infor)&&forget_btn.parents("tr").hasClass('activeItem')){
        previousVocabulary();
    }
}

function getData(){
    var data=[];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/vocabulary/getData',
        dataType: 'json',
        // loading:true,
        data:$.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    vocabularyArray=res.voca_array;
                    installSlide();
					slidePositionController();
                    $('#tab1 .table-right tbody tr:first-child').addClass('activeItem');
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

function updateGroup(change_item,sub_item_text){
	var data=$(change_item).val();
    var selectize_sub=$('#group_nm')[0].selectize;
    $.ajax({
        type: 'POST',
        url: '/common/getgroup',
        dataType: 'json',
        // loading:true,
        Accept : 'application/json',
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    selectize_sub.setValue('',true);
                    selectize_sub.clearOptions();
                    selectize_sub.addOption(res.data);
                    if($(change_item).val()==0){
                        selectize_sub.disable();
                    }else{
                        selectize_sub.enable();
                    }
                    if(typeof sub_item_text =='undefined'){
                        var defaultOption = selectize_sub.options[Object.keys(selectize_sub.options)[0]];
                        selectize_sub.setValue(defaultOption.value);
                    }else{
                        selectize_sub.setValue(selectize_sub.getValueByText(sub_item_text));
                    }
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

function setContentBox(word_id){
	$('.vocabulary-box:not(.hidden)').addClass('hidden');
	$('.vocabulary-box[word-id='+(word_id)+']').removeClass('hidden');
	$('.example-item:not(.hidden)').addClass('hidden');
	$('.example-item[word-id='+(word_id)+']').removeClass('hidden');
	$('.paging-item:not(.hidden)').addClass('hidden');
	$('.paging-item[word-id='+(word_id)+']').removeClass('hidden');
}

