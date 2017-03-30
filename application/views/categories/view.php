<?php
echo '<h2>'.$categories_item['category'].'</h2>';

if (!empty($news_items)) {
    ?>
    <table border='1' cellpadding='4'>
    <tr>
        <td><strong>Title</strong></td>
        <td><strong>Content</strong></td>
    </tr>
    <?php
    echo '<h3>Here are the associated News Items:</h3>';
    foreach ($news_items as $news_item) {
        ?>
        <tr>
            <td><?php echo $news_item['title']; ?></td>
            <td><?php echo $news_item['text']; ?></td>
        </tr>
        <?php
    }
    echo '</table>';
}
