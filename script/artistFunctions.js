//artistFunctions.js
/*
Jag har typ gjorde exakt samma från Songfunction men har bara ändrat lite
vart jag hämtar från html
*/
"use strict";

/**
*	Funktionen resetArtistFormData rensar inmatad data i formuläret "frmNewUpdateArtist"
*	samt meddelandetexten (om något fel uppstått) i "jsErrorMsg".
*	@version 1.1
*	@author Peter Bellström
*/
function resetArtistFormData() {
	var theForm = document.getElementById("frmNewUpdateArtist");
    theForm.hidId.value = "";
    theForm.hidPictureFileName.value = "";
    theForm.reset();
	window.document.getElementById("jsErrorMsg").innerHTML = "";
}

    $(document).ready(function(){
        $("#btnReset").on("click",function(){
            resetArtistFormData();
        });



/**
*	Funktionen copyArtistFormData kopierar inkommande parametrar till formuläret "frmNewUpdateArtist".
*	@param {Number} inId - Id (primärnyckel i databasen) för artisten som skall redigeras.
*	@param {String} inFileName - Filnamn för artisten som skall redigeras.
*	@param {String} inArtist - Artistnamn för artisten som skall redigeras.
*	@version 1.0
*	@author Peter Bellström
*/
function copyArtistFormData(inId, inFileName, inArtist) {
	var theForm = document.getElementById("frmNewUpdateArtist");
    theForm.hidId.value = inId;
    theForm.hidPictureFileName.value = inFileName;
    theForm.txtArtist.value = inArtist;
}


		$('form[name="frmArtist"]').find('input[type="button"]').on("click",function(e){

                var hidId = $(this).parent().find("[name=hidId]").val();

                var hidArtistId = $(this).parent().find("[name=hidArtist]").val();

		        var hidPictureFileName = $(this).parent().find("[name=hidPictureFileName]").val();




			copyArtistFormData(hidId,hidPictureFileName,hidArtistId);
	});








/**
*	Funktionen verifyDeleteOfArtist visar en dialogruta med "OK" och "Cancel".
*	Texten i dialogrutan består av tal + text i inkommande parametrar.
*	Funktionen returnerar sant vid tryck på "OK" och falskt vid tryck på "Cancel.
*	@param {Number} inId - Id (primärnyckel i databasen) för artisten som skall tas bort.
*	@param {String} inArtist - Artistnamn för artisten som skall tas bort.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellström
*/
function verifyDeleteOfArtist(inId, inArtist) {
		return window.confirm("Delete " + inId + " " + inArtist + "?");
}


    $("form").each(function(){

    var id = $(this).find("[name=hidId]").val();
        console.log(id);

        var idArtist = $(this).find("[name=hidArtist]").val();
        console.log(idArtist);

        $(this).find('input[name="btnDelete"]').on("click", function(e){
            var retur = verifyDeleteOfArtist(id , idArtist);

            if (retur === false){
                e.preventDefault();
                e.stopPropagation();
            }



        });

    });
   $(document).ready(function(){//funktion för att lägga in accordion
	var newDiv=$("<div id='accordion'>");//skapar en variabel med div taggen som innehåller accordion
	$("div[id='content']").append(newDiv);//lägger accordion i diven med id content
	$("form[name='frmArtist']").each(function(){//för varje formulär med namn frmartist körs funktionen
		var Artist=$(this).find("input[name='hidArtist']").val();//Sparar den aktuella artistens namn
		$(newDiv).append($(this));//placerar ut det aktuella formuläret i accordion diven
		var newH=$("<h3>").append(Artist).insertBefore($(this));//placerar ut h3 "länken" till diven för att klicka på för att aktivera accordion funktionen
	});
	$("#accordion").accordion();//tilldela accordion på alla accordion id
});



/**
*	Funktionen checkFileExtension kontrollerar filändelsen för inkommande parameter och
*	returnerar sant om det är "jpg" annars falskt.
*	@param {String} inFileName - Filnamn för filen som skall kontrolleras.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellström
*/
function checkFileExtension(inFileName) {
    var fileExtension = inFileName.substring(inFileName.length - 3);

	fileExtension = fileExtension.toLowerCase();

    if(fileExtension !== "jpg")
    {
        return false;
    }

    return true;

}

/**
*	Funktionen validateArtistFormData kontrollerar att indata i formuläret "frmNewUpdateArtist" uppfyller
*	givna villkor. Om alla villkor uppfylls returneras sant om inte visas en felet i elementet med id=jsErrorMsg.
*	Därefter sätts focus på det elementet som genererade felet och avslutningsvis returneras falskt.
*	@returns {Boolean}
*	@version 1.1
*	@author Peter Bellström
*/


             $("#frmNewUpdateArtist").on("submit",function(e){
                validateArtistFormData();
                  if (validateArtistFormData()){


            }
            else {
                 e.preventDefault();
                e.stopPropagation();
            }
            });



function validateArtistFormData() {
	var theForm = document.getElementById("frmNewUpdateArtist");

	try
	{
		if(theForm.txtArtist.value === "")
		{
			//throw new Error("Artistname is missing!");
			throw {
					"name" : "",
					"message" : "Artistname is missing!",
					"id" : theForm.txtArtist.getAttribute("id")
				};
		}

		if(theForm.hidId.value === "")
		{
			if(theForm.filePictureFileName.value === "")
            {
                //throw new Error("Picturename is missing!");
				throw {
					"name" : "",
					"message" : "Picturename is missing!",
					"id" : theForm.filePictureFileName.getAttribute("id")
				};
		   }
            else
            {
                if(checkFileExtension(theForm.filePictureFileName.value) === false)
				{
					//throw new Error("Only jpg files are valid!");
					throw {
						"name" : "",
						"message" : "Only jpg files are valid!",
						"id" : theForm.filePictureFileName.getAttribute("id")
					};
				}
            }

		}

		if(theForm.hidId.value !== "")
		{
			if(theForm.filePictureFileName.value !== "")
            {
                if(checkFileExtension(theForm.filePictureFileName.value) === false)
				{
					//throw new Error("Only jpg files are valid!");
					throw {
						"name" : "",
						"message" : "Only jpg files are valid!",
						"id" : theForm.filePictureFileName.getAttribute("id")
					};
				}
            }

		}

		return true;

	}
	catch(oException)
	{
		window.document.getElementById("jsErrorMsg").innerHTML = oException.message;
		window.document.getElementById(oException.id).focus();

		return false;
	}
}

});
