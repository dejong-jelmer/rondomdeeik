$(document).ready(function() { 

    // var logoHeight = $("#rondomdeeikLogo").height();
    // var halfLogoHeigth = logoHeight/2;

    // $("#rondomdeeikLogo").css("marginTop", -halfLogoHeigth);

    var logoHeight = $("#rondomdeeikLogo").height();
    var halfLogoHeigth = logoHeight/2;

    $("#rondomdeeikLogo").css("marginTop", -logoHeight);


    // remove hidden afte page is loaded to prefent change before content is loaded
    $("#selectPage").removeClass("hidden");
    $("#deletePage").removeClass("hidden");

    // Toggle edit options field 
    $("#selectPage").change(function() {
        
        clearImages();
        document.getElementById('title').value = '';
        document.getElementById('lead').value = '';
        document.getElementById('article').value = '';

        var editor = CKEDITOR.instances.content;
        editor.setData();
        
        if($("#articleField").hasClass("hidden") || this.value != "") {
            
            $("#articleField").removeClass("hidden");

        } else {
            $("#articleField").addClass("hidden");

        }
        
    });

    // click on image and open file input dialog
    $("#addImageBtn").click(function() {
        $("#imageInput").trigger('click');

        // set enctype for form element
        $("#articleForm").attr("enctype", "multipart/form-data");
    });

    // change button text (new to edit) and toggle delete button 
    $("#selectArticle").change(function() {
        
        clearImages();

        if(this.value == "") { 
           
            //empty form / content field / images
            clearImages();
            document.getElementById('articleForm').reset();
        
            var editor = CKEDITOR.instances.content;
            editor.setData();
            
        }

    });

    // article form handler buttons
    $(".articleFormHandlerBtn").click(function(){
        var value = this.value;
        var msg = "";
        var errMsg = "";

        // set selected value to article form handler value
        $("#articleFormHandler").val(value);

        switch(value) {
            case "newArticle":
                msg = "Nieuw artikel plaatsen?";
                if($("#selectArticle").val()) {
                    errMsg = "Je hebt al een ander artikel geselecteerd.";
                }

                if(!$("#selectPage").val()) {
                    errMsg = "Je hebt geen pagina geselecteerd voor het nieuwe artikel.";
                }
                break;
            case "editArticle":
                msg = "Artikel aanpassen?";
                if(!$("#selectArticle").val()) {
                    errMsg = "Je hebt geen artikel geselecteerd om aan te passen.";
                }
                break;
            case "deleteArticle":
                msg = "Weet je zeker dat het artikel wilt verwijderen?";
                if(!$("#selectArticle").val()) {
                    errMsg = "Je hebt geen artikel geselecteerd om te verwijderen.";
                }
                break;
            case "switchPage":
                msg = "Weet je zeker dat het artikel koppelen aan deze pagina?";
                if(!$("#selectArticle").val()) {
                    errMsg = "Je hebt geen artikel geselecteerd om te koppelen.";
                }
                break;
            default:
                break;
        }
        if(errMsg) {

            alert(errMsg);

        } else if(confirm(msg)) {
            // if no image is selected remove enctype in POST so $_FILES in empty for check
            if(!$("#imageInput").val()) {
                $("#articleForm").removeAttr("enctype");
            }
            // if article input select is disabled enable it before submit to get value in form handeling
            if($("#selectArticle").attr('disabled', true)) {

                $("#selectArticle").attr('disabled', false);
            }  
            //submit article form
            $("#articleForm").submit();
        }
    });

    // page form handler buttons
    $(".pageFormHandlerBtn").click(function(){
        var value = this.value;
        var msg = "";
        var errMsg = "";
        
        // set selected value to page form handler value
        $("#pageFormHandler").val(value);

        switch(value) {
            case "newPage":
                msg = "Nieuw pagina aanmaken?";
                if(!$("#pageName").val()) {
                    errMsg = "Je pagina naam is nog leeg.";
                }            
                break;
            case "deletePage":
                msg = "Pagina verwijderen?";
                if(!$("#deletePage").val()) {
                    errMsg = "Je hebt geen pagina geselecteerd om te verwijderen.";
                }
                break;
            default:
                break;
        }

        if(errMsg) {

            alert(errMsg);

        } else if(confirm(msg)) {

            //submit page form
            $("#pageForm").submit();
        }

    });


    $("#newPageBtn").click(function(){

        if(confirm("Pagina aanmaken?")) {

            $("#pageForm").submit();
        }
    });

    // bind article to other pages
    $("#switchPageCheckBox").click(function(){

        // checkable only if article is selected 
        if(!$("#selectArticle").val()){
            $(this).prop('checked', false);
        } 

        if($(this).is(":checked")) {
            // select a page without ajax changing the article list
            $("#selectPage").removeAttr("onchange");
            // show submit button
            $("#switchPage").removeClass("hidden");
            // disable article select
            $('#selectArticle').prop('disabled', 'disabled');                
            $('#selectArticle').attr('value', 'test');                
        } else {
            $("#selectPage").attr("onchange", "ajaxListArticles(this.value)");
            $("#switchPage").addClass("hidden");
            $("#selectArticle").attr('disabled', false);        
        }
        
        
    });

  // -------------------------- functions -------------------------- //

    // clear images
    function clearImages()
    {
        var ajaxImageField = document.getElementById('ajaxImageField');   
        var length = ajaxImageField.children.length;
        
        // set the image add button back to default image
        $('#addImageBtn').attr('src', '../public/img/addImgField.jpg');
        // remove enctype from article form
        $("#articleForm").removeAttr("enctype");
        
        while(ajaxImageField.hasChildNodes()) {

            ajaxImageField.removeChild(ajaxImageField.firstChild);
        }

    }

   
});
