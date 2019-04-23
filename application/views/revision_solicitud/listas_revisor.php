
<!-- listado de revisores -->
<div class="schedule-wrapper clear" data-animation="fadeIn" data-animation-delay="200">
  <div class="schedule-tabs lv1">
    <ul id="tabs-lv1"  class="nav nav-justified">
      <li class="active"><a href="#tab-trabajos-a-revisar" data-toggle="tab"><strong>Trabajos por evaluar</strong> <br/></a></li>
    </ul>
  </div>

  <div class="tab-content lv1">
    <!-- tab1 -->
    <div id="tab-trabajos-a-revisar" class="tab-pane fade in active">
      <div class="tab-content lv2">
        <div id="tab-lv21-revisar" class="tab-pane fade in active">
          <div class="timeline">
            <!-- lista nuevos trabajos a revisar -->
            <?php echo $main_content; ?>
            <!-- END lista nuevos trabajos a revisar -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END/listado de revisores -->
