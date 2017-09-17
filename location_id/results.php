<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://unpkg.com/vue@2.4.2"></script>

</head>

<body>
    <header>
        <img src="">
        <a href="search.php">Search</a>
    </header>
    <main>
        <h1>4 results found</h1>
        <div id="app">
            <ul>
                <li v-for="item in items">
                    <img id="ptag" src="images/p.png">
                    <h3>{{item.address}}</h3>
                    <h4>({{item.distance}}km away)</h4>

                </li>
            </ul>
        </div>
    </main>
</body>
<script src="vue.js"></script>

</html>
