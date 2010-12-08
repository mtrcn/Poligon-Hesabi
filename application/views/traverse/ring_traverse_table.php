<?php
    for ($i = 0; $i < @$numPoints + 1; $i++) {
    if ($i == 0) {
?>
    <tr align="center">
      <td><input type="text" name="id<?=$i ?>" size="4" onblur="getElementById('n1').value=this.value" value="<?php echo isset($id[$i])?$id[$i]:null; ?>"></td>
      <td></td> <td></td> <td></td>  <td></td> <td></td>
      <td><input class="numerical_input" type="text" name="Y<?=$i ?>" size="10" value="<?php echo isset($Y[$i])?$Y[$i]:null; ?>" onkeyup="comma_block(this)"></td>
      <td><input class="numerical_input" type="text" name="X<?=$i ?>" size="10" value="<?php echo isset($X[$i])?$X[$i]:null; ?>" onkeyup="comma_block(this)"></td>
    </tr>
    <tr align="center">
      <td></td> <td></td>
      <td><input class="numerical_input" type="text" name="azimuth<?=$i ?>" size="10" value="<?php echo isset($azimuth[$i])?sprintf("%0.4f",$azimuth[$i]):null; ?>" onkeyup="comma_block(this)"></td>
      <td><input class="numerical_input" type="text" name="distance<?=$i ?>" size="10" value="<?php echo isset($distance[$i])?sprintf("%0.3f",$distance[$i]):null; ?>" onkeyup="comma_block(this)"></td>
      <td><?php echo isset($dx[$i])?sprintf("%0.3f",$dx[$i]):null; ?><?php echo isset($vx[$i])?sprintf(" <sup>%.0fmm</sup>",1000*$vx[$i]):null; ?></td>
      <td><?php echo isset($dy[$i])?sprintf("%0.3f",$dy[$i]):null; ?><?php echo isset($vy[$i])?sprintf(" <sup>%.0fmm</sup>",1000*$vy[$i]):null; ?></td>
      <td></td> <td></td>
    </tr>
<?php
    }
    elseif ($i != 0 and ($i + 1) % @$numPoints == 1)
    {
?>
    <tr align="center">
      <td><input id="n1" size="4" disabled="disabled" value="<?php echo isset($id[0])?$id[0]:null; ?>"></td>
      <td><input class="numerical_input" type="text" name="angle0" size="10" value="<?php echo isset($angle[0])?sprintf("%0.4f",$angle[0]):null; ?>" onkeyup="comma_block(this)"><?php echo isset($aDiff)?sprintf("<sup>%0.0f<sup>cc</sup></sup>",10000 * $aDiff):null; ?></td>
      <td></td> <td></td> <td></td> <td></td>
      <td><?php echo isset($Y[$i])?sprintf("%0.3f",$Y[$i]):null; ?></td>
      <td><?php echo isset($X[$i])?sprintf("%0.3f",$X[$i]):null; ?></td>
    </tr>
<?php
    }
    else {
?>
    <tr align="center">
    <?php if ($i == 1) : ?>
      <td><input type="text" name="id<?=$i ?>" size="4" onblur="getElementById('n2').value=this.value" value="<?php echo isset($id[$i])?$id[$i]:null; ?>"></td>
    <?else : ?>
      <td><input type="text" name="id<?=$i ?>" size="4" value="<?php echo isset($id[$i])?$id[$i]:null; ?>"></td>
    <?endif;?>
      <td><input class="numerical_input" type="text" name="angle<?=$i ?>" size="10" value="<?php echo isset($angle[$i])?sprintf("%0.4f",$angle[$i]):null; ?>" onkeyup="comma_block(this)"><?php echo isset($aDiff)?sprintf("<sup>%0.0f<sup>cc</sup></sup>",10000 * $aDiff):null; ?></td>
      <td></td> <td></td> <td></td> <td></td>
      <td><?php echo isset($Y[$i])?sprintf("%0.3f",$Y[$i]):null; ?></td>
      <td><?php echo isset($X[$i])?sprintf("%0.3f",$X[$i]):null; ?></td>
    </tr>
    <tr align="center">
      <td></td> <td></td>
      <td><?php echo isset($azimuth[$i])?sprintf("%0.4f",$azimuth[$i]):null; ?></td>
      <td><input class="numerical_input" type="text" name="distance<?=$i ?>" size="10" value="<?php echo isset($distance[$i])?sprintf("%0.3f",$distance[$i]):null; ?>" onkeyup="comma_block(this)"></td>
      <td><?php echo isset($dx[$i])?sprintf("%0.3f",$dx[$i]):null; ?><?php echo isset($vx[$i])?sprintf(" <sup>%.0fmm</sup>",1000*$vx[$i]):null; ?></td>
      <td><?php echo isset($dy[$i])?sprintf("%0.3f",$dy[$i]):null; ?><?php echo isset($vy[$i])?sprintf(" <sup>%.0fmm</sup>",1000*$vy[$i]):null; ?></td>
      <td></td> <td></td>
    </tr>
<?php
        }
      }
?>
    <tr align="center">
      <td>&nbsp;</td>
      <td></td>
      <td><?php echo isset($azimuth[$i-1])?sprintf("%0.4f",$azimuth[$i-1]):null; ?></td>
      <td></td> <td></td> <td></td> <td></td> <td></td>
    </tr>
    <tr align="center">
      <td><input id="n2" size="4" disabled="disabled" value="<?php echo isset($id[1])?$id[1]:null; ?>"></td>
      <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td>
    </tr>
<?
     if ($isValid && !$isEmpty) {   
?>
    <tr align="center">
      <td>Toplam:</td>
      <td><?php echo isset($angle)?sprintf("%0.4f",array_sum($angle)):null; ?></td>
      <td></td>
      <td><?php echo isset($distance)?sprintf("%0.3f",array_sum($distance)):null; ?></td>
      <td><?php echo isset($dx)?sprintf("%0.3f",array_sum($dx)):null; ?></td>
      <td><?php echo isset($dx)?sprintf("%0.3f",array_sum($dy)):null; ?></td>
      <td></td> <td></td>
    </tr>
<?php 
     }
?>