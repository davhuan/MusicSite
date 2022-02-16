//commentFunctions.js


"use strict";

/**
*	Funktionen verifyDeleteOfComment visar en dialogruta med "OK" och "Cancel".
*	Texten i dialogrutan best�r av tal + text i inkommande parametrar.
*	Funktionen returnerar sant vid tryck p� "OK" och falskt vid tryck p� "Cancel.
*	@param {Number} inId - Id (prim�rnyckel i databasen) f�r kommentaren som skall tas bort.
*	@param {String} inText - Texten i kommentaren som skall tas bort.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellstr�m
*/



function verifyDeleteOfComment(inId, inText){

    return window.confirm("Delete " + inId + ": " + inText + "?");
}


/**
* Det f�rsta function , document.ready g�r att documentet f�rdig laddas och det r�cker att anv�nda den en g�ng.
* Vi h�mtar formul�r som heter "form" i html/php och i form function s� har den en 'each, vilket inneb�r en "iteration". Man kan s�ga "each"
  �r en for loop. Den k�r ig�ng function i varje kod som tr�ffar.
* $ tecken i jquery s� �r en biblotek till javascript och man beh�ver inte skriva jquery utan man beh�ver skriva $.
* Sen "this".find denna ska hitta i html koden name=hidId och f� v�rde.
* console.log �r att i webbl�sare s� har den in console d�r den matar ut text v�rdet som jag f�r.
* N�r man trycker p� submit knappen s� k�rs function och function heter e som �r kopplad till preventDefult s� att man hindrar sidan inte g�r i standard   beteende.
* i retur s� har jag tagit function fr�n den f�rdiga som labben hade redan skrivit functionen verifyDeleteOfComment och anv�nder den.
den retunera med en windows.confirm som �r d� windows "popup" f�nster som kommer st� delete + den datan som jag h�mtar fr�n id och idText
* om retur �r lika med falsk k�r e.preventDefault();   e.stopPropagation();
* $("#accordion").accordion(); <-- jag har lagt in en accordion id i html comment.php filen och sedan lagt en h3 rubrik. Accordion finns redan f�rdigt kodad som �r kopplad med header, footer.php jag har tagit accordion koden i f�rel�sningen 3 p� sida 23 och f�ljt efter stegen. Fr�n Peter Bellstr�m
*/
$(document).ready(function(){
    $("form").each(function(){

    var id = $(this).find("[name=hidId]").val();
        console.log(id);

        var idText = $(this).find("[name=hidText]").val();
        console.log(idText);

        $(this).on("submit", function(e){
            var retur = verifyDeleteOfComment(id , idText);

            if (retur === false){
                e.preventDefault();
                e.stopPropagation();
            }



        });

    });
    var newDiv=$("<div id='accordion'>");//skapar en variabel med div taggen som innehåller accordion
	$("div[id='content']").append(newDiv);//lägger accordion i diven med id content
	$("form[name='frmComment']").each(function(){//för varje formulär med namn frmartist körs funktionen
		var Id=$(this).find("input[name='hidId']").val();//Sparar den aktuella kommentarens id
		var Text=$(this).find("input[name='hidText']").val();//Sparar den aktuella kommentarens text
		$(newDiv).append($(this));//placerar ut det aktuella formuläret i accordion diven
		var newH=$("<h3>").append(Id + " " + Text).insertBefore($(this));//placerar ut h3 "länken" till diven för att klicka på för att aktivera accordion funktionen
	});
	$("#accordion").accordion();//tilldela accordion på alla accordion id
});

