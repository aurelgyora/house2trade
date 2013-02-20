(function(){
	function $id(id){return document.getElementById(id);}
	function Output(msg){var m = $id("list-images");
		m.innerHTML = msg + m.innerHTML;
	}
	function FileDragHover(e){
		e.stopPropagation();
		e.preventDefault();
		e.target.className = (e.type == "dragover" ? "hover" : "");
	}
	function FileSelectHandler(e){
		FileDragHover(e);
		var files = e.target.files || e.dataTransfer.files;
		for(var i=0,f;f=files[i];i++){
			ParseFile(f);
			UploadFile(f);
		}
	}
	function ParseFile(file){
		if(file.type.indexOf("image") == 0){
			var reader = new FileReader();
			reader.onload = function(e){
				Output("<li class='span4'><div class='thumbnail'><img class='img-polaroid' style='width: 280px;' src='"+e.target.result+"' alt=''><h5>"+file.name+"</h5><p> Type: "+file.type+"<br/>Size: "+file.size+" bytes</p></div></li>");
			}
			reader.readAsDataURL(file);
		}else{
			Output("<li class='alert alert-error'><strong>Warning!</strong> The uploaded file <strong>"+file.name+"</strong> is not image.</li>");
		}
	}
	function UploadFile(file){
		if(location.host.indexOf("sitepointstatic") >= 0) return
		var xhr = new XMLHttpRequest();
		if(xhr.upload && (file.type == "image/jpeg" || file.type == "image/png" || file.type == "image/gif") && file.size <= $id("MAX_FILE_SIZE").value){
			var o = $id("progress");
			var progress = o.appendChild(document.createElement('div'));
			progress.className ="progress progress-info progress-striped active";
			var bar = progress.appendChild(document.createElement('div'));
			bar.className = "bar";
			var barTextNode = bar.appendChild(document.createTextNode("Upload file: " + file.name));
			xhr.upload.addEventListener("progress",function(e){
				var pc = parseInt((e.loaded/e.total)*100);
				if(pc >=100){pc = 100;}
				bar.style.width = pc+"%";
			}, false);
			xhr.onreadystatechange = function(e){
				if(xhr.readyState == 4){
					progress.className = (xhr.status == 200 ? "progress progress-success" : "progress progress-danger");
					bar.style.width = "100%";
					barTextNode.nodeValue = "Upload file: " + file.name + " successful!";
				}
			};
			xhr.open("POST", $id("upload").action,true);
			xhr.setRequestHeader("X_FILENAME",file.name);
			xhr.send(file);
		}
	}
	function Init() {
		var fileselect = $id("fileselect"),
			filedrag = $id("filedrag"),
			submitbutton = $id("submitbutton");
		fileselect.addEventListener("change", FileSelectHandler, false);
		var xhr = new XMLHttpRequest();
		if(xhr.upload){
			filedrag.addEventListener("dragover", FileDragHover, false);
			filedrag.addEventListener("dragleave", FileDragHover, false);
			filedrag.addEventListener("drop", FileSelectHandler, false);
			filedrag.style.display = "block";
			submitbutton.style.display = "none";
		}
	}
	if(window.File && window.FileList && window.FileReader){Init();}
})();