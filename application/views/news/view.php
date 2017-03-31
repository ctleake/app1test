<?php
echo '<h2>News item: '.$news_item['title'].'</h2>';
echo 'News title: '.$news_item['text'];

if (!empty($categories)) {
    ?>
    <table border='1' cellpadding='4'>
    <tr>
        <td><strong>Category</strong></td>
    </tr>
    <?php
    echo '<h3>Here are its associated Categories:</h3>';
    foreach ($categories as $category) {
        ?>
        <tr>
            <td><?php echo $category['category']; ?></td>
        </tr>
        <?php
    }
    echo '</table>';
}
