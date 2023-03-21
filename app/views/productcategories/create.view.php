<form autocomplete="off" class="appForm clearfix" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>
            <?=$text_legend?>
        </legend>
        <div class="input_wrapper n100">
            <label <?=$this->labelFloat('CategoryNumber')?>><?= $text_label_category_title ?></label>
            <input required type="text" name="CategoryName" value="<?=$this->showValue('CategoryName')?>" >
        </div>
        <div class="input_wrapper n100" >
            <label class="floated"><?= $text_label_category_image ?></label>
            <input  type="file" name="CategoryImage" accept="image/*">
        </div>
        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>