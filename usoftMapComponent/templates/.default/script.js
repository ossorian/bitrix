function usoftMapInit()
{
	usoftMap = new ymaps.Map("map", {
		center: [55.76, 37.64],
		zoom: 10
	});

	$(usoftMap).on('click', function(){
		alert('ok');
	});
}

//$(document).ready(function(){
//});