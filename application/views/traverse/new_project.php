<script type="text/javascript">
  function check_form(form){
    if (form.num_points.value<2)
        alert("Lütfen nokta sayısı için 2 ve ya daha büyük bir sayı girin.");
    else
        form.submit();
  }
</script>
<h1>Yeni Proje</h1>
<form method="post" action="<? echo site_url("traverse/table"); ?>">
<table width="100%">
	<tr>
		<td width="120px">Poligon Türü</td>
		<td>: <input name="traverse_type" type="radio" value="free"
			checked="checked" /> Açık <input name="traverse_type" type="radio"
			value="ring" /> Kapalı <input name="traverse_type" type="radio"
			value="closed" /> Bağlı</td>
	</tr>
	<tr>
		<td>Nokta Sayısı</td>
		<td>: <input type="text" size="5" style="text-align: center;"
			name="num_points"></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input style="width: 200px; text-align: center;" type="button"
	onclick="javascript:check_form(this.form)" value="Devam >>" />
		</td>
	</tr>
</table>
</form>
<div id="help">
	<div class="helpItem">
		<p>Yeni bir proje oluşturmak için <b>Poligon Türü</b> ve <b>Nokta Sayısı</b> kısımlarını doldurun.</p>
	</div>
</div>
</div>
