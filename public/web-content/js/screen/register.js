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
        uploadUrl: '/common/upload-image',
        cropUrl: '/common/crop-image',
        rotateControls: false,
        loadPicture:$('#avatar').val(),
        cropData:{
            'width' : imageContainer.width(),
            'height': imageContainer.height()
        },
        onBeforeImgCrop:function(){
        	$('#imageContainer').LoadingOverlay("show");
            $('#avarta,#image').val($('#imageContainer .croppedImg').attr('src'));
        },
        onBeforeRemoveCroppedImg: function(){
        	$('#imageContainer').LoadingOverlay("show");
            $('#avarta,#image').val('');
        },
        onAfterImgCrop:function(){
            $('#avarta,#image').val($('#imageContainer .croppedImg').attr('src'));
            $('#imageContainer').LoadingOverlay("hide");
        },
        onAfterRemoveCroppedImg: function(){
            $('#avarta,#image').val('');
            $('#imageContainer').LoadingOverlay("hide");
        },
        onError: function(){
            showMessage(14);
        },
        onAfterImgUpload: function(){
        	$('#imageContainer').LoadingOverlay("hide");
        	$('#imageContainer').css('opacity','1');
        },
        onBeforeImgUpload:function(){
        	$('#imageContainer').LoadingOverlay("show");
        }
    };
    cropperBox = new Croppic('imageContainer', croppedOptions);
}
