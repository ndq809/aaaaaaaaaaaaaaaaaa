window.ColorUtils={colorToRgbaArray:function(b){var d=0,c=0,f=0,a=0;if(/^#([0-9a-zA-z]{3}|[0-9a-zA-z]{6})$/.test(b)){var e=parseInt(RegExp.$1,16);a=1;d=e>>16&255;c=e>>8&255;f=e&255}if(/^rgba?\((\d+),(\d+),(\d+),?(\d+)?\)$/.test(b)){d=parseInt(RegExp.$1);c=parseInt(RegExp.$2);f=parseInt(RegExp.$3);a=parseFloat(RegExp.$4);a=isNaN(a)?1:a}return[d,c,f,a]},getColorStop:function(h,l,j,m){var e=m.length-1;var f=j/((l-h)/e);var k=parseInt(f);var o=f-k;if(o==0){var c=this.colorToRgbaArray(m[k]);return"rgba("+c[0]+","+c[1]+","+c[2]+","+c[3]+")"}var a=this.colorToRgbaArray(m[k]);var g=this.colorToRgbaArray(m[k+1]);var i=parseInt(a[0]+(g[0]-a[0])*o);var n=parseInt(a[1]+(g[1]-a[1])*o);var b=parseInt(a[2]+(g[2]-a[2])*o);var d=parseInt(a[3]+(g[3]-a[3])*o);return"rgba("+i+","+n+","+b+","+d+")"},opacityColor:function(a,b){var c=this.colorToRgbaArray(a);c[3]*=b;return"rgba("+c[0]+","+c[1]+","+c[2]+","+c[3]+")"},randomColor:function(){return"rgb("+parseInt(255*Math.random())+","+parseInt(255*Math.random())+","+parseInt(255*Math.random())+")"}};