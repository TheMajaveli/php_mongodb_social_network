<?php
$likes = ViewHelper::apiRequest('/likes');
$average = ViewHelper::apiRequest('/likes/average?category_id=1');
?>

<div class="info">
    <p><strong>Total Likes:</strong> <?php echo count($likes); ?></p>
    <?php if (!empty($average)): ?>
        <p><strong>Average Likes (Category 1):</strong> <?php echo number_format($average['average'] ?? 0, 2); ?></p>
    <?php endif; ?>
</div>

<?php if (!empty($likes)): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Post ID</th>
            <th>User ID</th>
        </tr>
        <?php foreach (array_slice($likes, 0, 100) as $like): ?>
            <tr>
                <td><?php echo ViewHelper::formatId($like['_id'] ?? ''); ?></td>
                <td><?php echo $like['post_id'] ?? '-'; ?></td>
                <td><?php echo $like['user_id'] ?? '-'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if (count($likes) > 100): ?>
        <p>Showing 100 of <?php echo count($likes); ?> likes</p>
    <?php endif; ?>
<?php else: ?>
    <p>No likes found</p>
<?php endif; ?>
