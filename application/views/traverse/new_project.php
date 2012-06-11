<script type="text/javascript">
  function check_form(form){
    if (form.num_points.value<2)
        alert("Lütfen nokta sayısı için 2 ve ya daha büyük bir sayı girin.");
    else
        form.submit();
  }
</script>
<h2>Yeni Proje</h2>
<form class="well" method="post" action="<? echo site_url("traverse/table"); ?>">
<fieldset>
	<label for="traverse_type">Poligon Türü:
		<input name="traverse_type" type="radio" value="free" checked="checked" /> Açık 
		<input name="traverse_type" type="radio" value="ring" /> Kapalı 
		<input name="traverse_type" type="radio" value="closed" /> Bağlı
	</label>
	<label for="num_points">Nokta Sayısı:
		<input type="text" name="num_points">
	</label>
	<input class="btn btn-large" type="button" onclick="javascript:check_form(this.form)" value="Devam >>" />
</fieldset>
</form>
<div class="alert alert-info">
	Yeni bir proje oluşturmak için <b>Poligon Türü</b> ve <b>Nokta Sayısı</b> kısımlarını doldurun.
</div>
