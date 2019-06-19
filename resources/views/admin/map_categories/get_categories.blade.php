<?php if($results->count()>0){
?>
 <ul class="list-group category-list <?php echo $merchant_id;?>">
<?php
foreach($results as $row) {
?>
<li class="list-group-item" onClick="selectCategory(this,'<?php echo $merchant_id;?>','<?php echo $row->id;?>','<?php echo $row->categoryName;?>');"><?php echo $row->categoryName;?></li>
<?php } ?>
</ul>
<?php }?>
 

