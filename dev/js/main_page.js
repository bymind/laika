/*
* $ - Ready page function
*	Declarations and inits
*/

$(function() {
	VClickInit();
});


/*
* VClickInit()
* Initialisation click to the cover-image of video;
* @return 0
*/
function VClickInit() {
	$(document).on('click', '.video-plumb', function(event) {
		VClickHandler($(this));
	});
	return 0;
}


/*
* VClickHandler(obj)
* Handler click to the cover-image of video;
* @param obj
* @return 0
*/
function VClickHandler(obj) {
	var vStrBegin = '<iframe height="100%" width="100%" src="https://www.youtube.com/embed/';
	var vStrEnd = '?autoplay=1" frameborder="0" allowfullscreen></iframe>';
	var vStr = vStrBegin + obj.data('videoId') + vStrEnd;
	var vContainer = obj.parent();
	vContainer.append(vStr);
	obj.remove();
}