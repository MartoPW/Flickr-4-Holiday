<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Flickr 4 Holiday</title>

    <!-- Libs -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/masonry/dist/masonry.pkgd.min.js"></script>
    <script src="/bower_components/jquery-infinite-scroll/jquery.infinitescroll.min.js"></script>
    <script src="/bower_components/handlebars/handlebars.min.js"></script>


    <!-- Custom -->
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/Holidayextras.js"></script>
    <script src="/js/common.js"></script>

</head>
<body>
<div id="menu">
    <div class="wrapper">
        <input type="text" id="search" placeholder="Type some keywords and hit Enter"/>
        <label><input type="checkbox" id="allOrAny" value="all" />Check to perform 'AND' search (unchecked will do 'OR')</label>
    </div>
</div>
<div class="wrapper">
    <div id='grid'>

    </div>
</div>


</body>
</html>