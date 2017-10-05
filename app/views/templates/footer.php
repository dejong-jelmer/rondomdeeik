        
    
<footer class="footer">
        <div class="row">
            <!-- <div class="col-sm-6 col-sm-offset-1 clearfix" style="margin-top: 85px"> -->
            <div class="col-sm-6 col-sm-push-1 clearfix" style="margin-top: 15%;">
                <div>Partners:</div>  
                <a href="http://www.iewan.nl/" target="_blank"><img class="pull-left img-responsive logo" src="<?php echo $this->root; ?>/public/img/iewan-logo.png"></a>
                <a href="http://www.woongemeenschapeikpunt.nl/" target="_blank"><img class="pull-left img-responsive img-rounded logo" src="<?php echo $this->root; ?>/public/img/boom-logo-300x239.jpg"></a>
                <a href="http://www.wbvg.nl/" target="_blank"><img class="pull-left img-responsive img-rounded logo" src="<?php echo $this->root; ?>/public/img/wbvg-logo.png"></a>
                <a href="http://www.talis.nl/" target="_blank"><img class="pull-left img-responsive img-rounded logo" src="<?php echo $this->root; ?>/public/img/talis-logo.jpg"></a>
                <a href="https://www.nijmegen.nl/" target="_blank"><img class="pull-left img-responsive img-rounded logo" src="<?php echo $this->root; ?>/public/img/logo-gemeente.png"></a>
            
            </div>
           
            <div class="text-left col-sm-3 col-sm-push-2" style="margin-top: 5%; margin-bottom: 5%;">
                <p class="text">
                    <u>Contact:</u> <br>
                    Wijkvereniging Rondom de Eik <br>
                    <span class="glyphicon glyphicon-envelope"></span><a href="mailto:info@rondomdeeik.nl"> info@rondomdeeik.nl</a> <br>
                    <span class="glyphicon glyphicon-map-marker"></span> Karl Marxstraat, LENT <br>
                    KVK: 63406268  <br>
                    Bank: NL034TRIO123456789 <br>
                </p>
            </div>
        </div> <!-- end of row -->

        <div class="row">
            <div class="col-sm-12 text-center">
                <span class="credit-link text">2017<?php if(date('Y') != '2017') echo(' - '.date('Y')) ?> © wijkvereniging rondom de eik | Development and design: <a class="credit-link" href="http://www.codeweaver.nl">Jelmer de Jong</a></span>
            </div>
         </div> <!-- end of row -->
</footer> <!-- end of footer -->

</body>
</html>


<?php 
    // include JS for admin side menu
    if($this->authUser()) { 
    ?>
        <script type="text/javascript">
            
            // open side nav
            function openNav() {
                document.getElementById("sideNav").style.width = "250px";
                // document.getElementById("wrapper").style.marginLeft = "250px";
                document.getElementById("wrapper").style.opacity = "0.3";
                
                // $("#wrapper").dimBackground({darkness : 0.4});
                // $("#test").dimBackground({darkness : 0.3});
                
                $("#sideNavContent").fadeIn(500);
                
               
            }

            // close side nav
            function closeNav() {
              
                document.getElementById("sideNav").style.width = "0";
                // document.getElementById("wrapper").style.marginLeft = "0";
                document.getElementById("wrapper").style.opacity = "1";
                
                // $("#wrapper").undim();

                $("#sideNavContent").fadeOut(500);
                
            }

           
            
        </script>
<?php } ?>
