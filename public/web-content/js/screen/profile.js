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
	var canvas_meter = $('#canvas_meter1');

	canvas_meter.css({
	    width: 150,
	    height: 150
	}).Meter({
	    target: 80,                
	    min: 0,                    
	    max: 500,                  
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
	        fontSize: 30,
	        fontFamily: 'Roboto',
	        type: 0,   // 0 or 1
	        color: '#333333',
	        precision: 2
	    }
	}).draw();

	canvas_meter = $('#canvas_meter2');
	canvas_meter.css({
	    width: 150,
	    height: 150
	}).Meter({
	    target: 130,                
	    min: 0,                    
	    max: 300,                  
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
	        fontSize: 30,
	        fontFamily: 'Roboto',
	        type: 0,   // 0 or 1
	        color: '#333333',
	        precision: 2
	    }
	}).draw();

	var canvas_radar = $('#canvas_radar');

	canvas_radar.css({
	    width: 250,
	    height: 250
	}).Radar({
	    data: [8, 8, 6, 4, 7],
	    background: 'transparent',  //背景颜色
	    min: 0,
	    max: 10,
	    dimensions: {
	        data: ['Từ vựng', 'Ngữ pháp', 'Nghe', 'Đọc', 'Viết'],
	        fontSize: 13,                                   //文字大小
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
	$(document).on("click","button",function(){
		if($(this).attr("id")=='btn_next'){
			nextProfile();
		}
		if($(this).attr("id")=='btn_prev'){
			previousProfile();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberProfile($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetProfile($(this));
		}
	});

	$(document ).on("click",".focusable table tbody tr",function(){
		selectProfile($(this));
	});

	$(document ).on("click",".right-tab ul li",function(){
		switchTabVocabulary($(this));
	});
	$(window).resize(function(){
		slidePositionController();
	});
	$(document).on('keydown',function(e){
        switch(e.which){
            case 37 :
                previousProfile();
                break;
            case 39 :
                nextProfile();
                break;
            default:
                break;
        }
    })
}

function initImageUpload(){
    var imageContainer = $('#imageContainer');
    var croppedOptions = {
        uploadUrl: '/common/upload-image',
        cropUrl: '/common/crop-image',
        rotateControls: false,
        cropData:{
            'width' : imageContainer.width(),
            'height': imageContainer.height()
        },
        onAfterImgCrop:function(){
            $('#avarta,#image').val($('#imageContainer .croppedImg').attr('src'));
        },
        onAfterRemoveCroppedImg: function(){
            $('#avarta,#image').val('');
        },
        onError: function(){
            showMessage(14);
        },
    };
    cropperBox = new Croppic('imageContainer', croppedOptions);
}
