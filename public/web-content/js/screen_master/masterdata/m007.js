$(function(){
	try{
		init_m007();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_m007(){
	if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $("select.new-allow").selectize({
            allowEmptyOption: true,
            create: true
        });
    }else{
        $("select.new-allow").addClass("form-control input-sm");
    }
	initevent_m007();
}

function initevent_m007(){
	
}