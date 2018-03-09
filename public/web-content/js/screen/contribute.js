var slider;
$(function(){
	try{
		initContribute();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initContribute(){
	initListener();
	$( '#example1' ).sliderPro({
		width: '100%',
		height:340,
		orientation: 'vertical',
		loop: false,
		arrows: true,
		buttons: false,
		autoplay: true,
		thumbnailsPosition: 'right',
		thumbnailPointer: true,
		autoScaleLayers: true,
		waitForLayers: true,
		keyboardOnlyOnFocus: true,
		thumbnailWidth: 210,
		breakpoints: {
			800: {
				thumbnailsPosition: 'bottom',
				thumbnailWidth: 120,
				thumbnailHeight: 100
			},
			500: {
				height:150,
				thumbnailsPosition: 'bottom',
				thumbnailWidth: 100,
				thumbnailHeight: 80
			}
		}
	});

	$( '.sub-block' ).sliderPro({
		width: 150,
		height: 150,
		visibleSize: '100%',
		arrows: true,
		buttons: false,
		autoplay: false,
		fullscreen:true,
		autoSlideSize: false,
		keyboardOnlyOnFocus: true,
		// breakpoints: {
		// 	800: {
		// 		width: 120,
		// 		height: 100,
		// 		buttons: false,
		// 	},
		// 	500: {
		// 		width: 100,
		// 		height: 80,
		// 		buttons: false,
		// 	}
		// }
	});
	$('.sp-lightbox').not('.sp-video').fancybox();
}

function initListener(){
	$(window).resize(function(){
	});

	$(document).on("click",".option-body",function(){
		window.location.href=$(this).attr("option-link");
	})
}

