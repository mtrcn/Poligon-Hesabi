    <tr align="center">
      <td><input type="text" name="id0" size="4" value="<?php echo isset($id[0])?$id[0]:null; ?>"></td>
      <td></td> <td></td> <td></td> <td></td> <td></td>
      <td><input class="numerical_input" type="text" name="Y0" size="10" value="<?php echo isset($Y[0])?$Y[0]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><input class="numerical_input" type="text" name="X0" size="10" value="<?php echo isset($X[0])?$X[0]:null; ?>" onkeyup="comma_block(this)"></td>
    </tr>
    <tr align="center">
      <td></td> <td></td>
      <td><?php echo isset($azimuth[0])?sprintf("%0.4f",$azimuth[0]):null; ?></td>
      <td></td> <td></td> <td></td> <td></td> <td></td>
    </tr>
    <tr align="center">
      <td><input type="text" name="id1" size="4" value="<?php echo isset($id[1])?$id[1]:null; ?>"></td>
      <td><input class="numerical_input" type="text" name="angle0" size="10" value="<?php echo isset($angle[0])?sprintf("%0.4f",$angle[0]):null; ?>" onkeyup="comma_block(this)"><?php echo isset($aDiff)?sprintf("<sup>%.0f<sup>cc</sup></sup>",$aDiff*10000):null; ?></td>
      <td></td> <td></td> <td></td> <td></td>
      <td><input class="numerical_input" type="text" name="Y1" size="10" value="<?php echo isset($Y[1])?$Y[1]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><input class="numerical_input" type="text" name="X1" size="10" value="<?php echo isset($X[1])?$X[1]:null; ?>" onkeyup="comma_block(this)"></td>
    </tr>
    <tr align="center">
      <td></td> <td></td>
      <td><?php echo isset($azimuth[1])?sprintf("%0.4f",$azimuth[1]):null; ?></td>
      <td><input class="numerical_input" type="text" name="distance0" size="10" value="<?php echo isset($distance[0])?$distance[0]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><?php echo isset($dx[0])?sprintf("%0.3f",$dx[0]):null; ?><?php echo isset($vx[0])?sprintf(" <sup>%.0fmm</sup>",1000*$vx[0]):null; ?></td>
      <td><?php echo isset($dy[0])?sprintf("%0.3f",$dy[0]):null; ?><?php echo isset($vy[0])?sprintf(" <sup>%.0fmm</sup>",1000*$vy[0]):null; ?></td>
      <td></td> <td></td>
    </tr>
      <?
      for ($i = 0; $i < $numPoints; $i++) {
        ?>
    <tr align="center">
      <td><input type="text" name="id<?php echo ($i+2); ?>" size="4" value="<?php echo isset($id[$i+2])?$id[$i+2]:null; ?>"></td>
      <td><input class="numerical_input" type="text" name="angle<?php echo ($i + 1); ?>" size="10" value="<?php echo isset($angle[$i+1])?sprintf("%0.4f",$angle[$i+1]):null; ?>" onkeyup="comma_block(this)"><?php echo isset($aDiff)?sprintf("<sup>%.0f<sup>cc</sup></sup>",$aDiff*10000):null; ?></td>
      <td></td> <td></td> <td></td> <td></td>
      <td><?php echo isset($Y[$i+2])?sprintf("%0.3f",$Y[$i+2]):null; ?></td>
      <td><?php echo isset($X[$i+2])?sprintf("%0.3f",$X[$i+2]):null; ?></td>
    </tr>
    <tr align="center">
      <td></td> <td></td>
      <td><?php echo isset($azimuth[$i+2])?sprintf("%0.4f",$azimuth[$i+2]):null; ?></td>
      <td><input class="numerical_input" type="text" name="distance<?php echo ($i + 1); ?>" size="10" value="<?php echo isset($distance[$i+1])?$distance[$i+1]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><?php echo isset($dx[$i+1])?sprintf("%0.3f",$dx[$i+1]):null; ?><?php echo isset($vx[$i])?sprintf(" <sup>%.0fmm</sup>",1000*$vx[$i]):null; ?></td>
      <td><?php echo isset($dy[$i+1])?sprintf("%0.3f",$dy[$i+1]):null; ?><?php echo isset($vy[$i])?sprintf(" <sup>%.0fmm</sup>",1000*$vy[$i]):null; ?></td>
      <td></td> <td></td>
    </tr>
        <?
      }
      ?>
    <tr align="center">
      <td><input type="text" name="id<?php echo ($numPoints+2); ?>" size="4" value="<?php echo isset($id[$numPoints+2])?$id[$numPoints+2]:null; ?>"></td>
      <td><input class="numerical_input" type="text" name="angle<?php echo ($numPoints+1); ?>" size="10" value="<?php echo isset($angle[$numPoints+1])?sprintf("%0.4f",$angle[$numPoints+1]):null; ?>" onkeyup="comma_block(this)"><?php echo isset($aDiff)?sprintf("<sup>%.0f<sup>cc</sup></sup>",$aDiff*10000):null; ?></td>
      <td></td> <td></td> <td></td> <td></td>
      <td><input class="numerical_input" type="text" name="Y<?php echo ($numPoints+2); ?>" size="10" value="<?php echo isset($Y[$numPoints+2])?sprintf("%0.3f",$Y[$numPoints+2]):null; ?>" onkeyup="comma_block(this)"></td>
      <td><input class="numerical_input" type="text" name="X<?php echo ($numPoints+2); ?>" size="10" value="<?php echo isset($X[$numPoints+2])?sprintf("%0.3f",$X[$numPoints+2]):null; ?>" onkeyup="comma_block(this)"></td>
    </tr>
    <tr align="center">
      <td></td> <td></td>
      <td><?php echo isset($azimuth[$numPoints+2])?sprintf("%0.4f",$azimuth[$numPoints+2]):null; ?></td> <td></td> <td></td> <td></td> <td></td> <td></td>
    </tr>
    <tr align="center">
      <td><input type="text" name="id<?php echo ($numPoints+3); ?>" size="4" value="<?php echo isset($id[$numPoints+3])?$id[$numPoints+3]:null; ?>"></td>
      <td></td> <td></td> <td></td> <td></td> <td></td>
      <td><input class="numerical_input" type="text" name="Y<?php echo ($numPoints+3); ?>" size="10" value="<?php echo isset($Y[$numPoints+3])?sprintf("%0.3f",$Y[$numPoints+3]):null; ?>" onkeyup="comma_block(this)"></td>
      <td><input class="numerical_input" type="text" name="X<?php echo ($numPoints+3); ?>" size="10" value="<?php echo isset($X[$numPoints+3])?sprintf("%0.3f",$X[$numPoints+3]):null; ?>" onkeyup="comma_block(this)"></td>
    </tr>
<?
     if ($isValid && !$isEmpty) {   
?>
    <tr align="center">
      <td>Toplam:</td>
      <td><?php echo isset($angle)?sprintf("%0.4f", array_sum($angle)):null; ?></td>
      <td></td>
      <td><?php echo isset($distance)?sprintf("%0.3f", array_sum($distance)):null; ?></td>
      <td><?php echo isset($dx)?sprintf("%0.3f", array_sum($dx)):null; ?></td>
      <td><?php echo isset($dy)?sprintf("%0.3f", array_sum($dy)):null; ?></td>
      <td></td> <td></td>
    </tr>
<?
      }
?>