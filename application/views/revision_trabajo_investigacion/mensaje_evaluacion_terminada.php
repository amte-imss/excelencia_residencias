
<!-- Content area -->
<div class="content-area">

    <!-- <div id="main"> -->
        <section class="page-section background-img">
            <div class="container">
                <div class="row">
                  <div class="panel panel-default">
                    <h1 class="page-head-line"></h1>
                    <div class="panel-body">
                      <div class="jumbotron">
                        <h1 class="display-4">Evaluación terminada</h1>
                        <p class="lead">Ha finalizado exitosamente su revisión, gracias por su colaboración.</p>
                        <hr class="my-4">
                        <p>Prevención de la diabtes<p>
                        <p>Promedio de la evaluación: 85%</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </section>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        theme.init();
        theme.initMainSlider();
        theme.initCountDown();
        theme.initPartnerSlider();
        theme.initTestimonials();
        theme.initGoogleMap();
    });
    jQuery(window).load(function () {
        theme.initAnimation();
    });

    jQuery(window).load(function () { jQuery('body').scrollspy({offset: 100, target: '.navigation'}); });
    jQuery(window).load(function () { jQuery('body').scrollspy('refresh'); });
    jQuery(window).resize(function () { jQuery('body').scrollspy('refresh'); });

    jQuery(document).ready(function () { theme.onResize(); });
    jQuery(window).load(function(){ theme.onResize(); });
    jQuery(window).resize(function(){ theme.onResize(); });

    jQuery(window).load(function() {
        if (location.hash != '') {
            var hash = '#' + window.location.hash.substr(1);
            if (hash.length) {
                jQuery('html,body').delay(0).animate({
                    scrollTop: jQuery(hash).offset().top - 44 + 'px'
                }, {
                    duration: 1200,
                    easing: "easeInOutExpo"
                });
            }
        }
    });

</script>


</body></html>
