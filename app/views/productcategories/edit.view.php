<form autocomplete="off" class="appForm clearfix" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>
            <?= $text_legend ?>
        </legend>
        <div class="input_wrapper n100">
            <label <?= $this->labelFloat('CategoryName', $category) ?>><?= $text_label_category_title ?></label>
            <input required type="text" name="CategoryName" value="<?= $this->showValue('CategoryName', $category) ?>">
        </div>
        <div class="input_wrapper n100" >
            <label class="floated"><?= $text_label_category_image ?></label>
            <input  type="file" name="CategoryImage" accept="image/*">
        </div>
        <?php
            if ($category->CategoryImage !== null):
        ?>
            <div class="input_wrapper_other n100">
                <img src="<?= '..\\..\\..\\uploads\\images' . DS . $category->CategoryImage ?>" width="30%">
            </div> 
        <?php endif; ?>
        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>