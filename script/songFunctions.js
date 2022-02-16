//songFunctions.js

"use strict";





     $(document).ready(function(){
  

            $("#frmSong").on("click",function(e){
              var hidid = $(this).find('input[name="hidId"]').val();
                   var hidtitle = $(this).find('input[name="hidTitle"]').val();
                  if (verifyDeleteOfSong(hidid,hidtitle)){


            }
                 else {
                     e.preventDefault();
                     e.stopPropagation();
                 }



            });

$(document).ready(function(){//funktion för att lägga in accordion
	var newDiv=$("<div id='accordion'>");//skapar en variabel med div taggen som innehåller accordion
	$("div[id='content']").append(newDiv);//lägger accordion i diven med id content
	$("form[name='frmSong']").each(function(){//för varje formulär med namn frmsong körs funktionen
		var Title=$(this).find("input[name='hidTitle']").val();//Sparar den aktuella låtens titel
		$(newDiv).append($(this));//placerar ut det aktuella formuläret i accordion diven
		var newH=$("<h3>").append(Title).insertBefore($(this));//placerar ut h3 "länken" till diven för att klicka på för att aktivera accordion funktionen
	});
	$("#accordion").accordion();//tilldela accordion på alla accordion id
});


        /*
            H�mtar frmNewUpdateSong n�r man trycker p� submit s� k�r functionen
            jag gjorde en ifsats om den submitas s� k�rs hela validatorn.
        */


         // SAVAE KNAPP
// i save knappen va felet att jag körde två samma function >.<
           $("#frmNewUpdateSong").on("submit",function(e){



            if (validateSongFormData(e)){


            }
                 else {
                     e.preventDefault(e);
                     e.stopPropagation(e);
                 }

            });
         /**
         *  p� Edit knappen hämtar alla v�rden och ger namn hidid,hidTittle,hidArtistId,hidSoundFileName,hidCount
            Sen anv�nder jag functionen som �r v�rden kodad copySongFormData och l�gger in mina function vilken g�r n�r man trycker p� edit knappen s� kopiera den/f�r v�rdet och skriver ut den.
        */
            // Edit knapp

         $('form[name="frmSong"]').find('input[type="button"]').on("click",function(e){

                var hidId = $(this).parent().find("[name=hidId]").val();   // parent F�r f�r�lder varje element i den aktuella nuverande matchade element eventuellt filtrerad av en v�ljare
                var hidArtistId = $(this).parent().find("[name=hidArtistId]").val();
            console.log(hidArtistId);

                var hidTitle = $(this).parent().find("[name=hidTitle]").val();

		        var hidSoundFileName = $(this).parent().find("[name=hidSoundFileName]").val();

		        var hidCount = $(this).parent().find("[name=hidCount]").val();

// Fixade till edit knappen nu och får in alla värden, felet var att jag inte följt efter functioner från copySongFormData -
// Den måste vara i ordning, den vet inte vad den ska gö ex den kör steg 1 2 3 4 5 men den kan inte hoppa av stegen kan man säga.
			copySongFormData(hidId, hidSoundFileName, hidArtistId, hidTitle, hidCount);
	});


         // Reset Knapp

          $("#btnReset").on("click",function(){
            resetSongFormData(); //  jag h�mtar resetSongFormData(); som �r f�rdigt kodat s� jag anv�nder den function och l�gger in den i en btnreset knapp n�r man clickar s� k�rs den h�r function som resetar alla v�rden tillbacks.
        });







});
/**
*	Funktionen resetSongFormData rensar inmatad data i formul�ret "frmNewUpdateSong"
*	samt meddelandetexten (om n�got fel uppst�tt) i "jsErrorMsg".
*	@version 1.1
*	@author Peter Bellstr�m
*/
function resetSongFormData() {

	var theForm = document.getElementById("frmNewUpdateSong");

    theForm.hidId.value = "";
    theForm.hidSoundFileName.value = "";
    theForm.reset();
	window.document.getElementById("jsErrorMsg").innerHTML = "";
}

/**
*	Funktionen copySongFormData kopierar inkommande parametrar till formul�ret "frmNewUpdateSong".
*	@param {Number} inId - Id (prim�rnyckel i databasen) f�r s�ngen som skall redigeras.
*	@param {String} inFileName - Filnamn f�r s�ngen som skall redigeras.
*	@param {Number} inArtistId - Id (fr�mmandenyckel i databasen) f�r artisten s�ngen knyts till.
*	@param {String} inTitle - S�ngtitel f�r s�ngen som skall redigeras.
*	@param {Number} inCount - Antal "gilla" f�r s�ngen som skall redigeras.
*	@version 1.0
*	@author Peter Bellstr�m
*/
function copySongFormData(inId, inFileName, inArtistId, inTitle, inCount) {

	var theForm = document.getElementById("frmNewUpdateSong");

    theForm.hidId.value = inId;
    theForm.hidSoundFileName.value = inFileName;
    theForm.selArtistId.value = inArtistId;

	theForm.txtTitle.value = inTitle;
    theForm.txtCount.value = inCount;
}

/**
*	Funktionen verifyDeleteOfSong visar en dialogruta med "OK" och "Cancel".
*	Texten i dialogrutan best�r av tal + text i inkommande parametrar.
*	Funktionen returnerar sant vid tryck p� "OK" och falskt vid tryck p� "Cancel.
*	@param {Number} inId - Id (prim�rnyckel i databasen) f�r s�ngen som skall tas bort.
*	@param {String} inTitle - S�ngtitel f�r s�ngen som skall tas bort.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellstr�m
*/
function verifyDeleteOfSong(inId, inTitle) {
   return window.confirm("Delete " + inId + " " + inTitle + "?");
}

/**
*	Funktionen checkFileExtension kontrollerar fil�ndelsen f�r inkommande parameter och
*	returnerar sant om det �r "ogg" annars falskt.
*	@param {String} inFileName - Filnamn f�r filen som skall kontrolleras.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellstr�m
*/
function checkFileExtension(inFileName) {

    var fileExtension = inFileName.substring(inFileName.length - 3);
	fileExtension = fileExtension.toLowerCase();

    if(fileExtension !== 'ogg'){
        return false;
    }
    return true;
}

/**
*	Funktionen validateSongFormData kontrollerar att indata i formul�ret "frmNewUpdateSong" uppfyller
*	givna villkor.Om alla villkor uppfylls returneras sant om inte visas en felet i elementet med id=jsErrorMsg.
*	D�refter s�tts focus p� det elementet som genererade felet och avslutningsvis returneras falskt.
*	@returns {Boolean}
*	@version 1.1
*	@author Peter Bellstr�m
*/
function validateSongFormData() {
	var theForm = document.getElementById("frmNewUpdateSong");

  	try {
		if(theForm.selArtistId.selectedIndex === 0) {
			//throw new Error("Artist is missing!");
			throw {
					"name" : "",
					"message" : "Arist is missing!",
					"id" : theForm.selArtistId.getAttribute("id")
			};
		}

		if(theForm.txtTitle.value === "") {
			//throw new Error("Songtitle is missing!");
			throw {
					"name" : "",
					"message" : "Songtitle is missing!",
					"id" : theForm.txtTitle.getAttribute("id")
			};
		}

		if(theForm.hidId.value === ""){
			if(theForm.fileSoundFileName.value === "") {
                //throw new Error("Soundname is missing!");
				throw {
					"name" : "",
					"message" : "Soundname is missing!",
					"id" : theForm.fileSoundFileName.getAttribute("id")
				};
            }
            else {
                if(checkFileExtension(theForm.fileSoundFileName.value) === false) {
					//throw new Error('Only ogg files are valid!');
					throw {
						"name" : "",
						"message" : "Only ogg files are valid!",
						"id" : theForm.fileSoundFileName.getAttribute("id")
					};
				}
            }

		}

		if(theForm.hidId.value !== "") {
			if(theForm.hidSoundFileName.value !== null || theForm.hidSoundFileName.value !== "") {
                if(checkFileExtension(theForm.hidSoundFileName.value) == false) {
					//throw new Error("Only ogg files are valid!");
					throw {
						"name" : "",
						"message" : "Only ogg files are valid!",
						"id" : theForm.fileSoundFileName.getAttribute("id")
					};
				}
            }
		}

		if(theForm.txtCount.value === "") {
			//throw new Error("Count is missing!");
			throw {
				"name" : "",
				"message" : "Count is missing!",
				"id" : theForm.txtCount.getAttribute("id")
			};
		}

		if(isNaN(theForm.txtCount.value)) {
			//throw new Error("Count is not a number!");
			throw {
				"name" : "",
				"message" : "Count is not a number!",
				"id" : theForm.txtCount.getAttribute("id")
			};
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
