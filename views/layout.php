<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Social Network API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        nav {
            background: #333;
            padding: 10px;
            margin-bottom: 20px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            padding: 5px 10px;
        }
        nav a:hover {
            background: #555;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #333;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .info {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <nav>
        <a href="/view">Dashboard</a>
        <a href="/view/users">Users</a>
        <a href="/view/posts">Posts</a>
        <a href="/view/categories">Categories</a>
        <a href="/view/comments">Comments</a>
        <a href="/view/likes">Likes</a>
        <a href="/view/follows">Follows</a>
    </nav>
    
    <h1><?php echo isset($title) ? $title : 'Social Network API'; ?></h1>
    
    <?php echo $content; ?>
</body>
</html>
