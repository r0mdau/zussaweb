function popitup(url){
	var newwindow = window.open(url,'name','height=400,width=400');
	if (window.focus) {newwindow.focus();}
	return false;
}

var loadedobjects = "";
var rootdomain = "http://"+window.location.hostname;

function ajaxpage(url, containerid){
	$.ajax({
		url : url
	}).done(function(request){
		$('#'+containerid).html('').append(request);
	});
}

function loadobjs(){
	if (!document.getElementById) return;
	for (i = 0; i<arguments.length; i++){
		var file = arguments[i];
		var fileref = "";
		if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
			if (file.indexOf(".js")!=-1){ //If object is a js file
				fileref = document.createElement('script');
				fileref.setAttribute("type","text/javascript");
				fileref.setAttribute("src", file);
			}
			else if (file.indexOf(".css")!=-1){ //If object is a css file
			fileref = document.createElement("link");
			fileref.setAttribute("rel", "stylesheet");
			fileref.setAttribute("type", "text/css");
			fileref.setAttribute("href", file);
			}
		}
		if (fileref != ""){
			document.getElementsByTagName("head").item(0).appendChild(fileref);
			loadedobjects += file+" "; //Remember this object as being already added to page
		}
	}
}