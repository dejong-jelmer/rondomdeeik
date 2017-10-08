 <?php 
    require __DIR__.'/../templates/header.php';

    
    $pages = null;
    
    if(array_key_exists('pages', $data)) {
        
        $pages = $data['pages']->pages;
    }

?>
<!-- include sidemenu -->
<?php include __DIR__.'/../templates/sidemenu.php'; ?>

<!-- main page content starts here -->
<div id="wrapper">
    <button type="button" class="btn btn-default btn-sm" onClick="openNav()">
                <span class="glyphicon glyphicon-menu-hamburger"></span>
    </button>
    <div class="row">
        <div style="height:100px;">
           
            <!-- include messages -->
            <?php  include __DIR__.'/../templates/messages.php'; ?>
        </div>
    </div>
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-1">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#article">Artikel</a></li>
                    <li><a data-toggle="tab" href="#page">Pagina</a></li>
                </ul>
            </div>
        </div> <!-- end of row -->
        <div class="tab-content">
            <div id="article" class="tab-pane fade in active">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-12 col-sm-offset-1">                          
                                <button value="newArticle" type="button" class="btn btn-sm btn-success articleFormHandlerBtn formHandlerBtn"><span class="glyphicon glyphicon-ok-circle"></span> Nieuw artikel publiceren</button>
                                <button value="editArticle" type="button" class="btn btn-sm btn-warning articleFormHandlerBtn formHandlerBtn"><span class="glyphicon glyphicon-edit"></span> Artikel aanpassen</button>
                                <button value="deleteArticle" type="button" class="btn btn-sm btn-danger articleFormHandlerBtn formHandlerBtn"><span class="glyphicon glyphicon-remove-circle"></span> Artikel verwijderen</button>
                                <button id="switchPage" value="switchPage" type="button" class="btn btn-sm btn-default articleFormHandlerBtn formHandlerBtn hidden"><span class="glyphicon glyphicon-refresh"></span> Artikel verplaatsen</button>
                                
                            </div>
                        </div> <!-- end of row -->
                    </div> <!-- end of panel-heading -->
                    <div class="panel-body">
                        <div class="row">
                            <form id="articleForm" class="form-horizontal" action="<?php echo $this->route('article/create'); ?>" method="POST" >
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="control-label col-md-1" for="title" style="text-align: left;">Titel:</label>
                                        <div class="col-md-11 form-group-sm">
                                            <input type="text" id="title" class="form-control" name="title">
                                        </div>    
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <label class="control-label col-sm-1" for="selectPage" style="text-align: left;">Pagina:</label>
                                        <div class="col-md-5">
                                            <select id="selectPage" class="select hidden"  name="selectPage" onChange="ajaxListArticles(this.value)" size="3">
                                                <option value="" selected>-- Kies een pagina --</option>
                                                <?php 
                                                    foreach ($pages as $page) {
                                                    ?>
                                                        <option value="<?php echo $page['id']; ?>"><?php echo ucfirst(strtolower($page['name'])); ?></option>
                                                <?php 
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-1" for="selectArticle">Artikel:</label>
                                        <div id="articleField" class="col-sm-5 hidden">
                                            <select id="selectArticle" class="select" name="selectArticle" onChange="ajaxRequestArticle(this.value);" size="3">
                                            </select>
                                        </div> 
                                    </div>                                                       
                                    <div class="form-group form-group-sm">
                                        <div class="col-sm-6"></div>
                                        <label class="control-label col-sm-1" for="switchPageCheckBox" style="text-align: left;">Wijzig pagina:</label>
                                        <div class="col-sm-5">
                                            <label class="checkbox-inline"><input id="switchPageCheckBox" type="checkbox" name="switchPageCheckBox"></label>
                                        </div>                                   
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <label class="control-label col-sm-1" for="lead" style="text-align: left;">Inleiding:</label>
                                        <div class="col-sm-11">
                                            <textarea class="form-control" rows="2" cols="50" name="lead" id="lead"></textarea>
                                        </div>
                                       
                                    </div>
                                </div> <!-- end of title and lead form input -->
                                
                                <!-- start of image add fields -->
                                <div class="col-md-3 pull-right">
                                    <h4>Afbeeldingen:</h4>
                                    
                                    <!-- Ajax output -->
                                    <div id="ajaxImageField"></div>
                                                      
                                    <div class="col-sm-6 col-sm-offset-3"> 
                                        <input id="addImageBtn" type="image" class="img-responsive img-thumbnail center-block" src="<?php echo $this->root; ?>/public/img/addImgField.jpg" alt="nieuwe afbeelding" onClick="event.preventDefault();">
                                    </div>
                                </div> <!-- end of image add fields -->
                                <div class="col-md-9 pull-left">
                                    <div class="form-group">
                                        <label class="control-label col-sm-1 sr-only" for="content">Artikel tekst:</label>
                                        <div class="col-sm-11 col-sm-offset-1">
                                           <textarea type="text" class="form-control" rows="10" cols="50" name="content" id="content"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group hidden">
                                        <label for="image">Upload een afbeelding (optioneel):</label>
                                        <input id="imageInput" class="form-control" type="file" name="image">
                                    </div>
                                                   
                                </div>
                                <!-- hidden inputfields -->
                                <input id="articleFormHandler" type="hidden" name="articleFormHandler">
                                <input type="hidden" name="csrf_token" value="<?php echo $this->token(); ?>">
                                <!-- end of content fields -->
                            </form> <!-- end of edit article form -->
                        </div> <!-- end of row -->
                    </div> <!-- end of panel-body -->
                </div> <!-- end of panel -->
           </div> <!-- end of tab-pane - #article -->
           <div id="page" class="tab-pane fade">
                <div class="panel panel-default">
                    <div class="panel-heading">
                         <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <button value="newPage" class="btn btn-sm btn-success formHandlerBtn pageFormHandlerBtn"><span class="glyphicon glyphicon-ok-circle"></span> Nieuwe pagina aanmaken</button>
                                <button value="deletePage" type="button" class="btn btn-sm btn-danger formHandlerBtn pageFormHandlerBtn"><span class="glyphicon glyphicon-remove-circle"></span> Pagina verwijderen</button>
                            </div>
                        </div> <!-- end of row -->
                    </div> <!-- end of panel-heading -->
                    
                    <div class="panel-body">
                        <div class="row">
                            <form id="pageForm" class="form-horizontal" action="<?php echo $this->route('page/create'); ?>" method="POST">
                                <div class="col-md-12">
                                    <div class="form-group form-group-sm">
                                        <label class="control-label col-md-1" for="page" style="text-align: left;">Naam:</label>
                                        <div class="col-md-5 form-group-sm">
                                            <input type="text" id="pageName" class="form-control" name="pageName">
                                        </div>
                                        <label class="control-label col-sm-1" for="selectPage" style="text-align: left;">Pagina:</label>
                                        <div class="col-md-5">
                                            <select id="deletePage" class="select hidden"  name="deletePage" size="3">
                                                <option value="" selected>-- Kies een pagina --</option>
                                                <?php 
                                                    foreach ($pages as $page) {
                                                    ?>
                                                        <option value="<?php echo $page['id']; ?>"><?php echo ucfirst(strtolower($page['name'])); ?></option>
                                                <?php 
                                                    }
                                                    ?>
                                            </select>
                                        </div>  
                                    </div>
                                </div>
                                <!-- hidden inputfields -->
                                <input id="pageFormHandler" type="hidden" name="pageFormHandler">
                                <input type="hidden" name="csrf_token" value="<?php echo $this->token(); ?>">
                            </form> <!-- end of edit page form -->
                        </div> <!-- end of row -->
                    </div> <!-- end of panel body -->
                </div> <!-- end of panel -->
            </div> <!-- end of tab-pane - #page -->
        </div> <!-- end of tab-content -->
        <form id="deleteImageForm" action="<?php echo $this->route('image/delete'); ?>" method="POST">
            <input type="hidden" id="deleteImage" name="imageId">
            <input type="hidden" name="csrf_token" value="<?php echo $this->token(); ?>">
        </form>   
        
        <div class="row">
            <br>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of #wrapper -->
<!-- include footer -->
<?php include __DIR__.'/../templates/footer.php';?>

<script>CKEDITOR.replace('content');</script>

<script type="text/javascript">
    
    // add image
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#addImageBtn').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imageInput").change(function(){
        readURL(this);
    });

    // remove image
    function removeImage(value)
    {
        if(confirm("Weet je zeker dat je de afbeelding wilt verwijderen?")) {
            document.getElementById("deleteImage").value = value;
            document.getElementById("deleteImageForm").submit();
        }
    }

</script>

