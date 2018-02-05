$(function(){
	try{
		init_v001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_v001(){
	$('#btn-add a').attr('href','/master/v004');
}