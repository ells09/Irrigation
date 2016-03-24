<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
    </head>
    <body>
        <div class="container">
        <graph :labels="['January', 'February', 'March']" :values="[10,16,2]"></graph>
        <gauge :gid=1 data-value=22></gauge>
        <gauge :gid=2 data-value=32></gauge>
        <gauge :gid=3 data-value=26></gauge>
        <gauge :gid=4 data-value=28></gauge>
        </div>

        <script src="/js/main.js"></script>
    </body>
</html>
