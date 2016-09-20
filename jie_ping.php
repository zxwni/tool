# jie_ping
截屏
	$("body").one("click", function(event) {  
				event.preventDefault();  
				html2canvas(document.body, {  
				allowTaint: true,  
				taintTest: false,  
				onrendered: function(canvas) {  
					canvas.id = "mycanvas"; 
				//	document.body.appendChild(canvas);  
					
					//生成base64图片数据  
					var dataUrl = canvas.toDataURL();  
					var newImg = document.createElement("img");  
					newImg.src =  dataUrl;    
					document.body.appendChild(newImg);
					$("#hide").hide();					
				}  
			});  
		}); 
