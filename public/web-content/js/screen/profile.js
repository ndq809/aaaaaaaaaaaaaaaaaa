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
	var canvas_meter = $('#canvas_meter1');

	canvas_meter.css({
	    width: 150,
	    height: 150
	}).Meter({
	    target: 80,                
	    min: 0,                    
	    max: 100,                  
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
	        text: 'E-Point',           
	        fontSize: 18,               
	        fontFamily: 'Roboto', 
	        color: '#333333'            
	    },
	    subTitle: {
	        text: 'Điểm Kinh Nghiệm',   
	        fontSize: 18,          
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
	    target: 80,                
	    min: 0,                    
	    max: 100,                  
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
	        text: 'E-Point',           
	        fontSize: 18,               
	        fontFamily: 'Roboto', 
	        color: '#333333'            
	    },
	    subTitle: {
	        text: 'Điểm Đóng Góp',   
	        fontSize: 20,          
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
		switchTabVocalbulary($(this));
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


function nextProfile(){
	var currentItemId=setNextItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function previousProfile(){
	var currentItemId=setPreviousItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function selectProfile(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function switchTabVocalbulary(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
	selectProfile($(selectedTab+" table tbody tr" ).first());
}

function getProfileData(){
	var data = getDataCommon(1,"Profile/getData");
}

function rememberProfile(remember_btn){
	currentItem = remember_btn.parents("tr");
	selectProfile(rememberItem(currentItem,"Đã quên"));
}

function forgetProfile(forget_btn){
	currentItem = forget_btn.parents("tr");
	selectProfile(forgetItem(currentItem,"Đã thuộc"));
}