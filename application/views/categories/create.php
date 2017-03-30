<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('categories/create'); ?>
<table>
    <tr>
        <td><label for="category">Category</label></td>
        <td><textarea name="category" rows="10" cols="40"></textarea></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="submit" value="Create categories item" /></td>
    </tr>
</table>
</form>