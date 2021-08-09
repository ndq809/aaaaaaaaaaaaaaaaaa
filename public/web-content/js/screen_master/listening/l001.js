$(function(){
	try{
		init_g001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_g001(){
	$('#btn-add a').attr('href','/master/g004');
}