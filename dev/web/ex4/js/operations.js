/*
	Fichier : operations.js
	
	Fichier contenant l'ensemble des fonctions javascript 
	permettant le fonctionnement de l'exercice 4

*/

/*
	clearForm efface l'ensemble des 3 champs du "formulaire" 
*/
function clearForm() {
	var cOp1 = document.getElementById("op1");
	var cOp2 = document.getElementById("op2");
	var cResultat = document.getElementById("resultat");
	cOp1.value = "";
	cOp2.value = "";
	cResultat.value = "";
	/* var bEgal = document.getElementById("egal");
	bEgal.style.display = "none";
	bEgal.style.visibility = "hidden"; */
}

/*
	doOperation effectue l'opération passée en argument
	des deux opérandes passées en argument et place le
	résultat dans le dernier argument
*/
function doOperation(ope, op1, op2, resultat) {
	var cOp1 = document.getElementById(op1);
	var cOp2 = document.getElementById(op2);
	var cResultat = document.getElementById(resultat);
	var vOp1 = parseInt(cOp1.value);
	var vOp2 = parseInt(cOp2.value);
	switch(ope) {
		case "addition":
			cResultat.value = vOp1 + vOp2;
			break;
		case "soustraction":
			cResultat.value = vOp1 - vOp2;
			break;			
		case "multiplication":
			cResultat.value = vOp1 * vOp2;
			break;			
		case "division":
			cResultat.value = vOp1 / vOp2;
			break;			
		default:
			cResultat.value = "NaN";
	}		
}

/*
	getParameterByName renvoie la valeur de la variable name passée
	dans la query string
*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
    var results = regex.exec(location.search);
	/*
		if (results == null) {
			return "";
		} else {
			return decodeURIComponent(results[1].replace(/\+/g, " "));
		}
	*/	
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

/*
	capitaliseFirstLetter met la première lettre de la chaîne de 
	caractère en majuscule
*/
function capitaliseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/*
	tunningPage met à jour dynamiquement le contenu de la page
	operation.html en fonction de l'opération passée en argument
*/
function tunningPage(ope) {
	var titrePropre = capitaliseFirstLetter(ope);
	document.title = document.title + " " + titrePropre;
	document.getElementById("titre").innerHTML += " " + titrePropre;
	switch(ope) {
		case "addition":
			document.getElementById("operateur").innerHTML = "+";
			break;
		case "soustraction":
			document.getElementById("operateur").innerHTML = "-";
			break;			
		case "multiplication":
			document.getElementById("operateur").innerHTML = "x";
			break;			
		case "division":
			document.getElementById("operateur").innerHTML = "&divide;";
			break;			
		default:
			document.getElementById("operateur").innerHTML = "?";
			break;
	}
}