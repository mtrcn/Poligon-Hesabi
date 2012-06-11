<script type="text/javascript" src="<?php echo base_url(); ?>java_scripts/tablecloth.js"></script>
<script type="text/javascript">
  function comma_block(that) {
    that.value = that.value.replace(/,/g,".");
  }
</script>
<h3><?php echo $title; ?></h3>
  <form class="form-inline" action="<?=base_url()?>traverse/calculate" id="traverseTable" method="post">
    <input type="hidden" name="num_points" value="<?php echo $numPoints; ?>">
    <input type="hidden" name="traverse_type" value="<?php echo $traverseType;?>">
    <table class="table table-striped">
        <thead>
	        <tr>
	          <th>Nokta Adı</th>
	          <th>Poligon Açısı<br/>(grad)</th>
	          <th>Açıklık Açısı<br/>(grad)</th>
	          <th>Kenar Uzunluğu<br/>(metre)</th>
	          <th>Delta X</th>
	          <th>Delta Y</th>
	          <th>Y<br/>(metre)</th>
	          <th>X<br/>(metre)</th>
	        </tr>
        </thead>