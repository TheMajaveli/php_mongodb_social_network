<?php
$follows = ViewHelper::apiRequest('/follows');
$topThree = ViewHelper::apiRequest('/follows/top-three');
?>

<div class="info">
    <p><strong>Total Follows:</strong> <?php echo count($follows); ?></p>
</div>

<?php if (!empty($topThree)): ?>
    <div class="info">
        <h2>Top 3 Most Followed Users</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Followers Count</th>
            </tr>
            <?php foreach ($topThree as $user): ?>
                <tr>
                    <td><?php echo $user['_id'] ?? '-'; ?></td>
                    <td><?php echo $user['followers_count'] ?? 0; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>

<?php if (!empty($follows)): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Follows User ID</th>
        </tr>
        <?php foreach (array_slice($follows, 0, 100) as $follow): ?>
            <tr>
                <td><?php echo ViewHelper::formatId($follow['_id'] ?? ''); ?></td>
                <td><?php echo $follow['user_id'] ?? '-'; ?></td>
                <td><?php echo $follow['user_follow_id'] ?? '-'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if (count($follows) > 100): ?>
        <p>Showing 100 of <?php echo count($follows); ?> follows</p>
    <?php endif; ?>
<?php else: ?>
    <p>No follows found</p>
<?php endif; ?>
