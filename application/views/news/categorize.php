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
                <a href="<?php echo site_url('news/add_news_to_category/'.$news['id'].'/'.$categories_item['id']); ?>">Select</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>