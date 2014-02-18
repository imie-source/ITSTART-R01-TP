/* 
 * Fichier contenant les scripts Javascript pour l'application Ardoise Magique 
 *
 */
 
 function initEventListener() {
 
	var canvas = document.getElementById("zoneEncre");
	
	canvas.addEventListener('mousedown', function(e) { alert('mouseDown'); } );
	
}