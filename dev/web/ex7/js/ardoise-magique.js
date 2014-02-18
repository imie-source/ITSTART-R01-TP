/* 
 * Fichier contenant les scripts Javascript pour l'application Ardoise Magique 
 *
 */

var isMouseDown = false;
 
function getMousePos(e) {
	var canvas = document.getElementById("zoneEncre");
	var rect = canvas.getBoundingClientRect();
	return { 
		x: e.clientX - rect.left,
		y: e.clientY - rect.top
	};
}	
 
function noircir() {
	var canvas = document.getElementById("zoneEncre");	
	var context = canvas.getContext('2d');
	context.beginPath();
	context.rect(0,0,canvas.width,canvas.height);
	context.fillStyle = 'black';
	context.fill();
} 
 
function initEventListener() {

	noircir();
 
	var canvas = document.getElementById("zoneEncre");
	
	canvas.addEventListener('mousedown', function(e) { isMouseDown = true; } );
	canvas.addEventListener('mouseup', function(e) { isMouseDown = false; } );
	canvas.addEventListener('mousemove', function(e) { 
		var posMouse = getMousePos(e);
		if (isMouseDown) {
			var context = canvas.getContext('2d');
			var d = 20;
			context.clearRect(posMouse.x-d/2, posMouse.y-d/2, d, d);
			//console.log('mouseMove : ' + posMouse.x + 'x' + posMouse.y); 
		}	
	} );
	
}