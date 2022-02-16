//searchFunctions.js
"use strict";
/*
* Här så har jag gjort en egen event lyssnare när clickar så körs slidetoggle men först så ska hideid gömma sina värde som jag har plockat vilket det blir texten
* Anoder gör så att den blir som en länk och jag vill ha texten från legend och gömma efteråt.
* Vissa delar har jag tagit från föreläsning som toggle va från F3 animation från Peter Bellström. Den gör att den slidar up och ner vilket som jag vill ha det så!
*
*
*
*/

$(document).ready(function() {
function addevent(hideid, Anoder) {

    hideid.hide();
    Anoder.on("click", function(e) {
        hideid.slideToggle();
        e.stopPropagation();
        e.preventDefault();

    });
}


    $('form[name="frmcomment"]').each(function() {
        var hideid = $(this);
    	var dataid = $(this).attr("data-id");
        var textNode = $(this).find("legend").text();
        $(this).find("input[name='btnSave']").attr("id",dataid); // Hittar spar knappen
    var Anoder = $("<a href='#'> "+textNode+" </a> <br>").insertBefore(hideid);


			addevent(hideid,Anoder);
      });

    /*
    * Här hämtar jag värdet på hidid och text kommentar som jag kommer använda den till Ajaxen.
    *
    */
     $("input[name='btnSave']").on("click", function(e) {
				var idNr = $(this).attr('id');


                var textcomment=$("textarea[name='txtComment']", $(this).parent()).val();

                e.stopPropagation();
                e.preventDefault();

         /*
         * Jag har tagit Ajax Function från räknestugan 2 och anpassar den till min lösning.
         *
         */

$.ajax({

    dataType:"json", // datatyp som kommer tillbaka från anropen blir jason
    type:"post",  // vilken metod som server ska kommunicera med
    url:"ajax/savecomment.php", //länken till filerna och ska användas
    data:{idNr : idNr , textcomment : textcomment}, // data är det den som ska skicka till server
	success: function(d){ // Vad händer när detr blir Sucess är den koden som ska köras och här dömte jag function till d som är från räknestugan 2


			//Jag följde efter i html att som finns <p> <b> och <i>  d.date här så kommunmicera jag med servern jag vill ha date som finns i savecomment.php i den finns det en kod som heter date som skickar den till hit som jag får ut datumet i webbläsaren samma sak som comment dock i comment så var den hårdkodad "detta är en kommentar" prependTo annväder jag för att jag vill att den ska skruva ut förset övre dom andra kommentar som finns redan

      var pNode = $("<p></p>").prependTo("div[data-id='" + idNr + "']");
      var bNode = $("<b>" + d.date  + "  : </b>").appendTo(pNode);
      var iNode = $("<i> " + d.comment + "</i>").appendTo(pNode);


			},
	error: function(xhr,status,error){ // en error function ifall det är nåt fel men jag kan ta bort denna function eftersom jag inte använder den
    $("<span>").insertBefore("form[data-id='" + idNr + "']").text(error);

		}

	});

  });




        $("[data-comments=comments]").each(function(){
               var hideid = $(this);
			var dataid = $(this).attr("data-id");

				var Anoder = $("<a href='#'> Show All Comments </a> <br>").insertBefore(hideid); // Här ändrar jag namnet i länken till Show all comment

            addevent(hideid,Anoder);
        });



	$("a[data-id]").on("click", function(e) {//händelselyssnare för alla a taggar med data-id
		e.stopPropagation();//stoppar uppbubbling
		e.preventDefault();//stoppar default beteendet

		var id=$(this).attr('data-id');//sparar id
		var gilla=$("span[data-id='" + id + "']").text();//sparar antalet gillningar
		$.ajax({//startar ajax kod

			url : "ajax/likesong.php",//sökvägen
			type : "POST",//metod
			dataType : "json",//datatyp
			data : {gilla : gilla, id : id},//deklarerar vilka variabler som ska skickas med

			success: function(jsonData){//om det lyckas
				$("span[data-id='" + id + "']").text(jsonData['gilla']);//ändrar antalet gillningar i spanen med data-id=id
			},

			error: function(xhr, status, error){//om det misslyckas
				$("<span>").insertBefore("form[data-id='" + id + "']").text(error);//skickar en span nod som innehåller ett fel medelande
			}
		});
	});

/* Det sista är att jag har tagit bort alla // som har kommenterat bort i varje php/html filen som har en koppling med servern sen har jag lagt en slimbox "använder den"
*<a href="upload_jpg/acdc.jpg" title="Alen Walker" rel="lightbox"><img src="upload_jpg/acdc.jpg" alt="acdc.jpg" /> jag följde efter föreläsningen 3 animation från Peter Bellström hur man använder den färdiga slimbox.
*/

     });
