<form autocomplete="off" class="appForm clearfix" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>
            <?=$text_legend?>
        </legend>
        <div class="input_wrapper n50 border">
            <label  <?=$this->labelFloat('Name',$product)?>><?= $text_label_Name ?></label>
            <input required type="text" name="Name" value="<?=$this->showValue('Name',$product)?>" >
        </div>
        <div class="input_wrapper_other n50 padding select">
            <select required name="CategoryId">
                <option value=""><?=$text_label_CategoryId?></option>
                <?php if($categories !== false): foreach($categories as $category): ?>
                <option value="<?=$category->CategoryId?>" <?=$this->selectedIf('CategoryId',$category->CategoryId,$product)?>><?=$category->CategoryName?></option>
                <?php endforeach; endif;?>
            </select>
        </div>
        <div class="input_wrapper n20 border">
            <label  <?=$this->labelFloat('Quantity',$product)?>><?= $text_label_Quantity ?></label>
            <input required type="number" name="Quantity" min="1" step="1" value="<?=$this->showValue('Quantity',$product)?>" >
        </div>
        <div class="input_wrapper n20 border padding" >
            <label <?=$this->labelFloat('BuyPrice',$product)?>><?= $text_label_BuyPrice ?></label>
            <input  type="number" name="BuyPrice" step="0.01" value="<?=$this->showValue('BuyPrice',$product)?>">
        </div>
        <div class="input_wrapper n20 border padding" >
            <label <?=$this->labelFloat('SellPrice',$product)?>><?= $text_label_SellPrice ?></label>
            <input  type="number" name="SellPrice" step="0.01" value="<?=$this->showValue('SellPrice',$product)?>">
        </div>
        <div class="input_wrapper_other n40 padding select">
            <select required name="Unit">
                <option value=""><?=$text_label_Unit?></option>
                <option value="1" <?=$this->selectedIf('Unit',1,$product)?>><?=$text_unit_1?></option>
                <option value="2" <?=$this->selectedIf('Unit',2,$product)?>><?=$text_unit_2?></option>
                <option value="3" <?=$this->selectedIf('Unit',3,$product)?>><?=$text_unit_3?></option>
                <option value="4" <?=$this->selectedIf('Unit',4,$product)?>><?=$text_unit_4?></option>
            </select>
        </div>
        <div class="input_wrapper n100 padding" >
            <label class="floated"><?= $text_label_Image ?></label>
            <input  type="file" name="Image" accept="image/*" >
        </div>
        <?php
            if ($product->Image !== null):
        ?>
            <div class="input_wrapper_other n100">
                <img src="<?= '..\\..\\..\\uploads\\images' . DS . $product->Image ?>" width="30%">
            </div> 
        <?php endif; ?>
        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>