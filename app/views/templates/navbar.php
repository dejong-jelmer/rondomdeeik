
<div class="row">
    <img id="rondomdeeikImage" class="img-responsive" src="<?php echo $this->root; ?>/public/img/eik-bw.jpg">
</div>
<div class="row" style="margin:0; width: 100%;">;
    <img id="rondomdeeikLogo" class="img-responsive" src="<?php echo $this->root; ?>/public/img/rodeik-bannerII.png">
</div>
<!-- <div class="container-fluid"> -->
    <div class="row" style="background-color: #ffffff;">
        <nav id="nav" class="navbar navbar-default">
           
                <button id="navBtn" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <div id="menu" class="collapse navbar-collapse">
                    <ul class="brackets nav navbar-nav pull-right collapse in up" >
                        <?php 
                        foreach ($pages as $page) {
                        ?>
                            <li class="text-right"><a data-toggle="tab" href="#<?php echo $page['name']; ?>"><?php echo str_replace('_', ' ', ucfirst(strtolower($page['name']))); ?></a></li>
                        <?php 
                        }
                        ?>
                    </ul>
                </div>
           
        </nav>
    </div>
<!-- </div> -->
<!--  navbar-fixed-top  -->

<script type="text/javascript">
    
   
    
    $(window).on("resize", function () {  
        
        // var logoHeight = $("#rondomdeeikLogo").height();
        // var halfLogoHeigth = logoHeight/2;

        // $("#rondomdeeikLogo").css("marginTop", -halfLogoHeigth);

        var logoHeight = $("#rondomdeeikLogo").height();
        var halfLogoHeigth = logoHeight/2;

        $("#rondomdeeikLogo").css("marginTop", -logoHeight);
    }).resize();
    


    // Create a clone of the menu, right next to original.
    $('#nav').addClass('original-menu').clone().insertAfter('#nav').addClass('cloned-menu').css('position','fixed').css('top','0').css('margin-top','-1').css('z-index','1040').removeClass('original-menu').hide();

    $(".cloned-menu>#menu").attr("id", "menu-cloned");
    $(".cloned-menu>button").attr("data-target", "#menu-cloned");
    
    $('#rondomdeeikLogo').addClass('original-logo').clone().insertAfter('#rondomdeeikLogo').addClass('cloned-logo').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','1040').removeClass('original-logo').hide();

    scrollIntervalID = setInterval(stickLogo, 10);
    scrollIntervalID = setInterval(stickMenu, 10);

    function stickLogo()
    {
        
        // logo
        var orglogoPos = $('.original-logo').offset();
        var orglogoTop = orglogoPos.top;
        
        
        if ($(window).scrollTop() >= (orglogoTop)) {
            var orglogo = $(".original-logo");
            var orglogoOffset = orglogo.offset();
           
            var leftOrglogo = orglogoOffset.left;
            var widthOrglogo = orglogo.css("width");

            $('.cloned-logo').css('left',leftOrglogo+'px').css('top','0px').show();
            $('.original-logo').css('visibility', 'hidden');
            
        } else {
            // not scrolled past the logo; only show the original logo.
            $('.cloned-logo').hide();
            $('.original-logo').css('visibility','visible');
            
      }
    }

    function stickMenu()
    {
        var logoHeight = $("#rondomdeeikLogo").height();
        
        // menu
        var orglogoPos = $('.original-logo').offset();
        var orglogoTop = orglogoPos.top;

        var orgMenuPos = $('.original-menu').offset();
        var orgMenuTop = orgMenuPos.top;
        
        if ($(window).scrollTop() >= (orglogoTop)) {
            var orgMenu = $(".original-menu");
            var orgMenuOffset = orgMenu.offset();
            
            var leftOrgMenu = orgMenuOffset.left;
            var widthOrgMenu = orgMenu.css("width");
            var heightOrgMenu = orgMenu.css("height");
           
            $('.cloned-menu').css('left',leftOrgMenu+'px').css('top', logoHeight+'px').show();
            $('.original-menu').css('visibility', 'hidden');

                      
        } else {
        // not scrolled past the menu; only show the original menu.
        $('.cloned-menu').hide();
        $('.original-menu').css('visibility','visible');
    
      }

    }

  
</script>