<script type="text/javascript"
	src="http://maps.googleapis.com/maps/api/js?sensor=false">
</script>
<script type="text/javascript">
 
	var map;
	var type;
	var map_markers = new Array();
	function init(lat,lng,title,type) {
		this.type=type;
		var latlng = new google.maps.LatLng(lat, lng);
		var myOptions = {
			zoom: 8,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById("map"),myOptions);
		var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: title,
		});
		google.maps.event.addListener(map, 'tilesloaded', init2);

	}
	
	function setState(){
		type=document.getElementById("type").value;
		init2();
	}

	function init2(){
		google.maps.event.addListener(map, 'bounds_changed', getPoints('getMapPoints.php',map.getBounds()));
	}

	function addPoint(lat,lng,title,type,img,notes,breed,color,user_id){
		var latlng = new google.maps.LatLng(lat, lng);
		var image='images/'+type+'.gif';	
		
		var infowindow = new google.maps.InfoWindow({
		    content:"<table><tr><td><img height=75 src='"+img+"'></img></td><td><b>"+breed+" - "+color+"</b><br><br><center>"+notes+"<br><br><a href='profile.php?uid="+user_id+"'>User</a></center></td></tr></table>" 
		});

		var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: title ,
			icon: image
		});

		google.maps.event.addListener(marker, 'click', function() {
		  infowindow.open(map,marker);
		});

		map_markers[map_markers.length] = marker;
	}

	function getPoints(strURL,bounds) {
		//Clear Old markers	
		for(var i=0; i<map_markers.length; i++){
			google.maps.event.clearInstanceListeners(map_markers[i]);
			map_markers[i].setMap(null);
			delete  map_markers[i];
		}
		map_markers = new Array();	
		strURL+="?l1="+bounds.getNorthEast().lat()+"&l2="+bounds.getSouthWest().lat();	
		strURL+="&n1="+bounds.getNorthEast().lng()+"&n2="+bounds.getSouthWest().lng();
		strURL+="&type="+type;
		var self = this;
		// Mozilla/Safari
		if (window.XMLHttpRequest) {
			self.xmlHttpReq = new XMLHttpRequest();
		}
		// IE
		else if (window.ActiveXObject) {
			self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
		}
		self.xmlHttpReq.open('POST', strURL, true);
		self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		self.xmlHttpReq.onreadystatechange=function() {
		    if(self.xmlHttpReq.readyState == 4) {
		      	addXmlPoints(self.xmlHttpReq.responseXML);
		    }
		}
		self.xmlHttpReq.send();
	}

	function addXmlPoints(data){
		var markers = data.documentElement.getElementsByTagName("marker");
		for (var i = 0; i < markers.length; i++) {
			 addPoint(markers[i].getAttribute("lat"),markers[i].getAttribute("lng"),markers[i].getAttribute("type"),markers[i].getAttribute("type"),markers[i].getAttribute("image"),markers[i].getAttribute("notes"),markers[i].getAttribute("breed"),markers[i].getAttribute("color"),markers[i].getAttribute("user_id"));
		}
	}

</script>
