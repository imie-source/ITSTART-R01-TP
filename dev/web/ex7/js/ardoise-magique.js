/* 
 * Fichier contenant les scripts Javascript pour l'application Ardoise Magique 
 *
 */

var isMouseDown = false;
 
function getMousePos(e, idCanvas) {
	var canvas = document.getElementById(idCanvas);
	var rect = canvas.getBoundingClientRect();
	return { 
		x: e.clientX - rect.left,
		y: e.clientY - rect.top
	};
}	
 
function noircir(idCanvas) {
	var canvas = document.getElementById(idCanvas);	
	var context = canvas.getContext('2d');
	context.beginPath();
	context.rect(0,0,canvas.width,canvas.height);
	context.fillStyle = 'black';
	context.fill();
} 
 
function initEventListener(idCanvas, d) {

	noircir(idCanvas);
 
	var canvas = document.getElementById(idCanvas);
	
	canvas.addEventListener('mousedown', function(e) { isMouseDown = true; } );
	canvas.addEventListener('mouseup', function(e) { isMouseDown = false; } );
	canvas.addEventListener('mousemove', function(e) { 
		var posMouse = getMousePos(e, idCanvas);
		if (isMouseDown) {
			var context = canvas.getContext('2d');
			context.clearRect(posMouse.x-d/2, posMouse.y-d/2, d, d);
			//console.log('mouseMove : ' + posMouse.x + 'x' + posMouse.y); 
		}	
	} );
	
}