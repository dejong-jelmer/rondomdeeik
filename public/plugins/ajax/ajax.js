
function getXMLHttp()
{
  var xmlHttp;
  try
  {
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    try
    {
      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e)
    {
      try
      {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e)
      {
          alert("Er zijn veel redenen om u browser te updaten. Het kunnen bekijken van deze site is er één!");
          return false;
      }

    }
  }
  return xmlHttp;
}


// handle ajax request for article list
function ajaxListArticles(value)
{
  
  var xmlHttp = getXMLHttp();
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4) {
      handleArticleListResponse(xmlHttp.responseText);
    } else {
      handleArticleListResponse("<option value='loading'>Laden ...</option>");    
    }
  }
  if(value != '') {
    xmlHttp.open("GET", "../public/plugins/ajax/listArticles.php?page_id="+value, true);
    xmlHttp.send();
  }
}

function handleArticleListResponse(response)
{
  document.getElementById('selectArticle').innerHTML = response;
}

// handle ajax request for article
function ajaxRequestArticle(value)
{
  
  var xmlHttp = getXMLHttp();
    
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4) {
      handleArticleResponse(xmlHttp.responseText);
    } else {
      
    }
  }

  if(value != '') {
    xmlHttp.open("GET", "../public/plugins/ajax/articleRequest.php?article_id="+value, true);
    xmlHttp.send();
  }
  
}

function handleArticleResponse(response)
{
  var response = JSON.parse(response);
  
  if(document.getElementById("ajaxImageField").children.length == 0) {
          
      for (i in response.images) {
          document.getElementById('ajaxImageField').innerHTML += "<div class='col-sm-6 image'><span class='glyphicon glyphicon-remove img-remove' onClick='removeImage("+response.images[i].id+");'></span><img class='img-responsive center-block img-thumbnail' src='" + response.images[i].location + "'></div>";
      }
          

  }
  
  document.getElementById('title').value = response.article.title;
  document.getElementById('lead').value = response.article.lead;
    
  var content = response.article.content;
  var editor = CKEDITOR.instances.content;
  editor.setData(content);


}
