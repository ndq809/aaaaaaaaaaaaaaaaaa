var slider;
$(function(){
	try{
		initHomepage();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initHomepage(){
	initListener();
	if($('#show_login').val()==1){
		$('.btn-popup[popup-id=popup-box0]').trigger('click');
	}
	meniItemController();
}

function initListener(){
	$(window).resize(function(){
		meniItemController();
	});

	$(document).on("click",".option-body",function(){
		window.location.href=$(this).attr("option-link");
	})

	$(document).on("click",".right-header",function(){
		meniItemController();
	})

	$(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        getList(parseInt(page, 10));
    })
}

function meniItemController(){
	item_size=$(".option-header:first").width()/12;
	$(".option-item").css("font-size",item_size);
}

function getList(page){
	_pageSize=4;
	var data={};
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/homepage/list',
        dataType: 'html',
        loading:true,
        data: data,
        container:'#result',
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
