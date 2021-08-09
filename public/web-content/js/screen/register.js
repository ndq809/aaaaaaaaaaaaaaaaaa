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
    $('#imageContainer').attr('style', 'background-image: url("' + $('#avatar').val() +'")');
    $('#imageContainer').css('opacity','1');
    $("select.custom-selectize").each(function() {
        var select = $(this).selectize({
            delimiter: ',',
            persist: false,
            create: false,
            plugins: ['restore_on_backspace','remove_button'],
        });
    });
}

function initListener(){
    $(document).on('click','#btn-register',function(){
        create();
    })
}

function initImageUpload(){
    var imageContainer = $('#imageContainer');
    var croppedOptions = {
        uploadUrl: '/common/upload-image',
        cropUrl: '/common/crop-image',
        rotateControls: false,
        // loadPicture:$('#avatar').val()!='/web-content/images/avarta/default_avarta.jpg'?$('#avatar').val():false,
        cropData:{
            'width' : imageContainer.width(),
            'height': imageContainer.height()
        },
        onBeforeImgCrop:function(){
        	$('#imageContainer').LoadingOverlay("show");
        },
        onBeforeRemoveCroppedImg: function(){
        	$('#imageContainer').LoadingOverlay("show");
        },
        onAfterImgCrop:function(){
            $('#avatar,#image').val($('#imageContainer .croppedImg').attr('src'));
            $('#imageContainer').LoadingOverlay("hide");
        },
        onAfterRemoveCroppedImg: function(){
            $('#avatar,#image').val('/web-content/images/avarta/default_avarta.jpg');
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
        },
        onReset:function(){
            $('#avatar,#image').val('/web-content/images/avarta/default_avarta.jpg');
        }
    };
    cropperBox = new Croppic('imageContainer', croppedOptions);
}

function create(){
    var data=getInputData();
    $.ajax({
        type: 'POST',
        url: '/register/create',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    showMessage(20,function(){
                        location.reload();
                    });
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
