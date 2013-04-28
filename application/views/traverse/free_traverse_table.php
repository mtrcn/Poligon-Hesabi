    <tr align="center">
      <td><input type="text" name="id0" class="input-mini" value="<?php echo isset($id[0])?$id[0]:null; ?>"></td>
      <td></td> <td></td> <td></td> <td></td> <td></td>
      <td><input class="input-small" type="text" name="Y0"  value="<?php echo isset($Y[0])?$Y[0]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><input class="input-small" type="text" name="X0"  value="<?php echo isset($X[0])?$X[0]:null; ?>" onkeyup="comma_block(this)"></td>
    </tr>
    <tr align="center">
      <td></td> <td></td>
      <td><input class="input-small" type="text" name="azimuth0"  value="<?php echo isset($azimuth[0])?$azimuth[0]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><input class="input-small" type="text" name="distance0"  value="<?php echo isset($distance[0])?$distance[0]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><?php echo isset($dx[0])?sprintf("%.3f",$dx[0]):null; ?></td>
      <td><?php echo isset($dx[0])?sprintf("%.3f",$dy[0]):null; ?></td>
      <td></td>
      <td></td>
    </tr>

<?
  for ($i=1;$i < $numPoints-1;$i++) {
?>
    <tr align="center">
      <td><input type="text" name="id<?php echo $i; ?>" class="input-mini" value="<?php echo isset($id[$i])?$id[$i]:null; ?>"></td>
      <td><input class="input-small" type="text" name="angle<?php echo $i; ?>"  value="<?php echo isset($angle[$i])?$angle[$i]:null; ?>" onkeyup="comma_block(this)"></td>
      <td></td> <td></td> <td></td> <td></td>
      <td><?php echo isset($Y[$i])?sprintf("%.3f",$Y[$i]):null; ?></td>
      <td><?php echo isset($X[$i])?sprintf("%.3f",$X[$i]):null; ?></td>
    </tr>
    <tr align="center">
      <td></td> <td></td>
      <td><?php echo isset($azimuth[$i])?sprintf("%.4f",$azimuth[$i]):null; ?></td>
      <td><input class="input-small" type="text" name="distance<?php echo $i; ?>"  value="<?php echo isset($distance[$i])?$distance[$i]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><?php echo isset($dx[$i])?sprintf("%.3f",$dx[$i]):null; ?></td>
      <td><?php echo isset($dx[$i])?sprintf("%.3f",$dy[$i]):null; ?></td>
      <td></td> <td></td>
    </tr>
<?
    }
?>
    <tr align="center">
      <td><input type="text" name="id<?php echo $i; ?>" class="input-mini" value="<?php echo isset($id[$i])?$id[$i]:null; ?>"></td>
      <td></td> <td></td> <td></td> <td></td> <td></td>
      <td><?php echo isset($Y[$i])?sprintf("%.3f",$Y[$i]):null; ?></td>
      <td><?php echo isset($X[$i])?sprintf("%.3f",$X[$i]):null; ?></td>
    </tr>