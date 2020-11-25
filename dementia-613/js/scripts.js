var directoryBtn = document.querySelectorAll('a.directory-btn');
var totalBtns = directoryBtn.length;

if(totalBtns){
	for(var x=0;x<totalBtns;x++){
		directoryBtn[x].addEventListener('click',function(e){
			e.preventDefault();

			var directory = document.querySelector('.directory');

			if(directory){
				directory.style.display = 'block';
			}
		});
	}
}

var directory = document.querySelector('.directory');

if(directory){
	var directoryToggle = directory.previousElementSibling.lastElementChild;

	if(directoryToggle){
		directoryToggle.addEventListener('click',function(){
			this.parentNode.nextElementSibling.style.display = 'block';
		});
	}

	var closeDirectory = directory.querySelector('.container .row .col-12 .title a');

	if(closeDirectory){
		closeDirectory.addEventListener('click',function(e){
			e.preventDefault();
			this.parentNode.parentNode.parentNode.parentNode.parentNode.style.display = 'none';
		});
	}
}

var resourceArchive = document.querySelector('.post-type-archive-resource, .archive.category');

if(resourceArchive){
	var toggleView = resourceArchive.querySelector('main .container.content .row .col-12:last-child ul li:last-child');

	if(toggleView){
		toggleView.addEventListener('click',function(){
			var body = document.querySelector('body');
			var width = width  = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
			
			if(width > 768){
				var isMapView = body.className.indexOf('map-view') === -1 ? true : false; 

				body.className = isMapView ? body.className + ' map-view' : body.className.replace(' map-view','');
			}else{
				var isFilterView = body.className.indexOf('filter-view') === -1 ? true : false; 

				body.className = isFilterView ? body.className + ' filter-view' : body.className.replace(' filter-view','');
			}
		});
	}

	var locations = resourceArchive.querySelectorAll('main .results .container .row .col-lg-9 .resource-item, main .results .container .row .col-12 .resource');
	var totalLocations = locations.length;

	if(totalLocations){
		var map = resourceArchive.querySelector('main .map .container .row .col-12 .g-map');

		if(map){
			var mapLocations = map.nextElementSibling.querySelectorAll('.location');
			var map = new google.maps.Map(map,{center:{lat:0,lng:0},scrollwheel:!0,styles:[],zoom:15,mapTypeControl:!1,minZoom:9,maxZoom:22,streetViewControl: false,fullscreenControl:false,zoomControl:true,disableDefaultUI:false,gestureHandling:"greedy"});
			var bounds = new google.maps.LatLngBounds();
			
			for(var x=0;x<totalLocations;x++){
				var lat = parseFloat(locations[x].getAttribute('data-lat'));
				var lng = parseFloat(locations[x].getAttribute('data-lng'));
				
				if(lat && lng){
					var marker = new google.maps.Marker({
						position:{
							lat:lat,
							lng:lng
						},
						map:map
					});

					if(mapLocations[x]){
						mapLocations[x].marker = marker;
						mapLocations[x].children[1].addEventListener('click',function(){
							map.setCenter(this.parentNode.marker.getPosition());
						})
					}

					bounds.extend(marker.position);
				}

				map.fitBounds(bounds);
			}
		}
	}
}

function resourcePage(_form){
	var url = _form.getAttribute('action');
	var categories = _form.querySelectorAll('input[name="category"]:checked');
	var totalCategories = categories.length;

	if(totalCategories){
		var categoryList = '';

		for(var x=0;x<totalCategories;x++){
			categoryList += categoryList ?  ',' + categories[x].value : categories[x].value;
		}

		url += '?category=' + categoryList;
	}

	var types = _form.querySelectorAll('input[name="types"]:checked');
	var totalTypes = types.length;

	if(totalTypes){
		var typeList = '';

		for(var x=0;x<totalTypes;x++){
			typeList += typeList ? ',' + types[x].value : types[x].value;
		}

		url += categoryList ? '&types=' + typeList : '?types=' + typeList;
	}

	var location = _form.querySelector('input[name="neighbourhood"]');

	if(location.value){
		url += categoryList || typeList ? '&neighbourhood=' + location.value : '?neighbourhood=' + location.value;
	}

	document.location.href = url;

	return false;
}

function submitForm(_form){
	var fields = _form.querySelectorAll('input,textarea,select');
	var totalFields = fields.length;
	var validFields = true;

	if(totalFields){
		for(var x=0;x<totalFields;x++){
			var valid = fields[x].validity.valid;
			
			fields[x].parentNode.className = valid ? '' : 'invalid';

			if(!valid && validFields){
				validFields = false;
			}
		}
	}

	if(validFields){
		var btn = _form.querySelector('button');
		var btnText = btn.innerText;
		var formData = new FormData(_form);
        var xhttp = new XMLHttpRequest();

        btn.disabled = true;
        btn.innerText = 'Please wait...';

        xhttp.onreadystatechange = function(){
            if(xhttp.readyState == 4){
                if(xhttp.status === 200){
                    try{
                        var response = JSON.parse(xhttp.response)
                    }catch(e){
                        var response = xhttp.response; 
                    }
                    
                    console.log(response);
                }else{
                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
                }
            }
        };
                                          
        xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
        xhttp.send(formData);
	}

	return false;
}