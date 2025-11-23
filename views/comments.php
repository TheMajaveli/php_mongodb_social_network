<?php
$comments = ViewHelper::apiRequest('/comments');
?>

<div class="info">
    <p><strong>Total Comments:</strong> <?php echo count($comments); ?></p>
</div>

<?php if (!empty($comments)): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Content</th>
            <th>Post ID</th>
            <th>User ID</th>
            <th>Date</th>
        </tr>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?php echo ViewHelper::formatId($comment['_id'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars(substr($comment['content'] ?? '', 0, 50)); ?>...</td>
                <td><?php echo $comment['post_id'] ?? '-'; ?></td>
                <td><?php echo $comment['user_id'] ?? '-'; ?></td>
                <td><?php echo $comment['date'] ?? '-'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No comments found</p>
<?php endif; ?>
