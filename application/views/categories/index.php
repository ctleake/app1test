<h2><?php echo $title; ?></h2>

<table border='1' cellpadding='4'>
    <tr>
        <td><strong>Category</strong></td>
        <td><strong>Action</strong></td>
    </tr>
    <?php foreach ($categories as $categories_item): ?>
        <tr>
            <td><?php echo $categories_item['category']; ?></td>
            <td>
                <a href="<?php echo site_url('categories/'.$categories_item['slug']); ?>">View</a> |
                <a href="<?php echo site_url('categories/edit/'.$categories_item['id']); ?>">Edit</a> |
                <a href="<?php echo site_url('categories/delete/'.$categories_item['id']); ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>