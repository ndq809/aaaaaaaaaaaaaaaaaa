$(function(){
	try{
		init_g002();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_g002(){
	$('#btn-add a').attr('href','/master/v004');
}