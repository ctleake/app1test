<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('categories/edit/'.$categories_item['id']); ?>
<table>
    <tr>
        <td><label for="title">Category</label></td>
        <td><input type="input" name="category" size="50" value="<?php echo $categories_item['category'] ?>" /></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="submit" value="Edit categories item" /></td>
    </tr>
</table>
</form>