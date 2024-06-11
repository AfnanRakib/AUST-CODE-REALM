<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script src="../js/jquery-2.0.3.min.js"></script><!-- https://code.jquery.com/jquery-2.0.3.min.js -->
    <script src="../js/jquery.glanceyear.min.js"></script>
    <link rel="stylesheet" href="../css/glanceyear.css">
</head>
<body>
    <div class="glanceyear-container">
        <h1 class="glanceyear-header">Glance Year
            <span class="glanceyear-quantity"></span>
        </h1>
        <div class="glanceyear-content" id="js-glanceyear">
        </div>
        <div class="glanceyear-summary">
            <div class="glanceyear-legend">
                Less&nbsp;
                <span style="background-color: #eee"></span>
                <span style="background-color: #c3dbda"></span>
                <span style="background-color: #5caeaa"></span>
                <span style="background-color: #277672"></span>
                &nbsp;More
            </div>
            Calendar with map data entered <br>
            <span id="debug"></span>
        </div>
    </div>
    <script>
        $(function() {
            //data points with date and submissions
            var massive = [
                {date: '2024-1-3', value:'1'},
                {date: '2024-2-4', value:'2'},
                {date: '2024-2-3', value:'3'},
                {date: '2024-1-14', value:'2'},
                {date: '2024-1-13', value:'8'},
                {date: '2024-3-3', value:'1'},
                {date: '2024-3-4', value:'2'},
                {date: '2024-4-7', value:'3'},
                {date: '2024-4-14', value:'2'},
                {date: '2024-6-3', value:'1'},
                {date: '2024-5-4', value:'2'},
                {date: '2024-5-5', value:'3'},
                {date: '2024-4-14', value:'2'}
            ];
            $('#js-glanceyear').glanceyear(massive,{
            eventClick: function(e) { alert('Date: ' + e.date + ', Count:' + e.count); },
                months: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                weeks: ['M','T','W','T','F','S', 'S'],
                targetQuantity: '.glanceyear-quantity',
                tagId: 'glanceyear-svgTag',
                showToday: true,
                today: new Date()
            });
        });      
    </script>
</body>
</html>
