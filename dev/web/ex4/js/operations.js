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
	var vOp1 = cOp1.value;
	var vOp2 = cOp2.value;
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


