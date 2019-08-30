var slider;
$(function(){
	try{
		initProfile();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initProfile(){
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
	var canvas_meter = $('#canvas_meter1');

	canvas_meter.css({
	    width: 180,
	    height: 150
	}).Meter({
	    target: Number($('#canvas_meter1').attr('value')),                
	    min: 0,                    
	    max:  Number($('#canvas_meter1').attr('max')),                  
	    background: 'transparent', 
	    frames: 60,                 
	    startAngle: 0.8,           
	    endAngle: 2.2,             
	    isAnimation: true,          
	    animationTime: 3,          
	    isDebug: false,             
	    events: {                                 
	        start: function (options) {           
	        },
	        drawing: function (cValue, tValue, options) {  
	        },
	        end: function (options) {     
	        }
	    },
	    colors: ['#ff6131', '#ffad1f', '#4ebf42', '#317fff'],
	    title: {                   
	        // text: 'E-Point',           
	        fontSize: 18,               
	        fontFamily: 'Roboto', 
	        color: '#333333'            
	    },
	    subTitle: {
	        text: 'Điểm Kinh Nghiệm',   
	        fontSize: 15,          
	        fontFamily: 'textfont', 
	        color: 'red'
	    },
	    arc: {
	        type: 0,  // 0 or 1
	        defaultColor: 'rgba(51, 51, 51,0.2)',
	        targetColor: '#FFFFFF',
	        width: 1,
	        pointRadius: 6
	    },
	    tick: {
	        type: 0,   // 0 or 1
	        length: 10,
	        width: 1,
	        defaultColor0: '#3c3c3c',
	        defaultColor1: '#3c3c3c',
	        targetColor: '#3c3c3c'
	    },
	    tickText: {
	        fontSize: 10,               
	        color: '#3c3c3c',  
	        fontFamily: 'Roboto' 
	    },
	    scoreText: {
	        fontSize: 26,
	        fontFamily: 'Roboto',
	        type: 0,   // 0 or 1
	        color: '#333333',
	        precision: 2
	    }
	}).draw();

	canvas_meter = $('#canvas_meter2');
	canvas_meter.css({
	    width: 180,
	    height: 150
	}).Meter({
	    target: Number($('#canvas_meter2').attr('value')),                
	    min: 0,                    
	    max:  Number($('#canvas_meter2').attr('max')),                  
	    background: 'transparent', 
	    frames: 60,                 
	    startAngle: 0.8,           
	    endAngle: 2.2,             
	    isAnimation: true,          
	    animationTime: 3,          
	    isDebug: false,             
	    events: {                                 
	        start: function (options) {           
	        },
	        drawing: function (cValue, tValue, options) {  
	        },
	        end: function (options) {     
	        }
	    },
	    colors: ['#ff6131', '#ffad1f', '#4ebf42', '#317fff'],
	    title: {                   
	        // text: 'E-Point',           
	        fontSize: 18,               
	        fontFamily: 'Roboto', 
	        color: '#333333'            
	    },
	    subTitle: {
	        text: 'Điểm Đóng Góp',   
	        fontSize: 15,          
	        fontFamily: 'textfont', 
	        color: 'red'            
	    },
	    arc: {
	        type: 0,  // 0 or 1
	        defaultColor: 'rgba(51, 51, 51,0.2)',
	        targetColor: '#FFFFFF',
	        width: 1,
	        pointRadius: 6
	    },
	    tick: {
	        type: 0,   // 0 or 1
	        length: 10,
	        width: 1,
	        defaultColor0: '#3c3c3c',
	        defaultColor1: '#3c3c3c',
	        targetColor: '#3c3c3c'
	    },
	    tickText: {
	        fontSize: 10,               
	        color: '#3c3c3c',  
	        fontFamily: 'Roboto' 
	    },
	    scoreText: {
	        fontSize: 26,
	        fontFamily: 'Roboto',
	        type: 0,   // 0 or 1
	        color: '#333333',
	        precision: 2
	    }
	}).draw();

	var canvas_radar = $('#canvas_radar');
	var pointArray = $('.mission-point').map(function(){
		return $(this).text();
	})

	var labelArray = $('.mission-label').map(function(){
		return $(this).text();
	})

	canvas_radar.css({
	    width: 400,
	    height: 250
	}).Radar({
	    data: pointArray,
	    background: 'transparent',  //背景颜色
	    min: 0,
	    max: 10,
	    dimensions: {
	        data: labelArray,
	        fontSize: 14,                                   //文字大小
	        fontFamily: 'textfont',                  //字体
	        color: '#666666',                              //文字颜色
	        margin: 5
	    },
	    colors: {
	        base: {
	            line: '#ced0d1',
	            background: '#e2f6ff'
	        },
	        data: {
	            line: '#1799d3',
	            background: '#1799d3',
	            opacity:0.5
	        }
	    },

	    frames: 60,        //帧数
	    isAnimation: true,  //是否启用动画
	    animationTime: 5,   //动画时间
	    isDebug: false,     //是否调试模式
	    events: {                                           //绘图事件
	        start: function (options) {                     //开始绘图
	        },
	        drawing: function (cValue, tValue, options) {   //没帧开始
	        },
	        end: function (options) {                       //绘图结束
	        }
	    }
	}).draw();
}

function initListener(){
	$(document).on('click','#btn-update-infor',function(){
        showMessage(1,function(){
        	updateInfor();
       });
    })

    $(document).on('click','#btn-update-pass',function(){
        showMessage(1,function(){
        	updatePass();
       });
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

function updateInfor(){
    var data=getInputData('.infor');
    $.ajax({
        type: 'POST',
        url: '/profile/updateinfor',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    showMessage(22,function(){
                        $('#menu1 img').attr('src',res.avarta);
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

function updatePass(){
    var data=getInputData('.pass');
    $.ajax({
        type: 'POST',
        url: '/profile/updatepass',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    showMessage(23,function(){
                    	clearFailedValidate();
                        $('.pass input').val('');
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