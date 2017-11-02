$(function(){
	try{
		initRegister();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initRegister(){
	initListener();
	initImageUpload();
}

function initListener(){

}

function initImageUpload(){
	var imageContainer = $('#imageContainer');
	var croppedOptions = {
	    uploadUrl: '/upload-image',
	    cropUrl: '/crop-image',
	    cropData:{
	        'width' : imageContainer.width(),
	        'height': imageContainer.height()
	    }
	};
	var cropperBox = new Croppic('imageContainer', croppedOptions);
}
