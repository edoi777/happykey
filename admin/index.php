<?php include('core/init.php');?><!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8"/>
<title>Control panel | EnSiStudio</title>


    <link type="text/css" rel="stylesheet" href="/admin/css/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/animate.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/all.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/style.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/pace.css">
    <link type="text/css" rel="stylesheet" href="/admin/css/jquery.news-ticker.css">








</head>
<body>
<?php
if(!empty($_LOGGED_IN)) {
	include('core/workspace.php');
}
else {
	echo '<form action="/" method="post" class="modal fade in" style="display: block;">
        <div class="modal-dialog modal-lg" style="position:fixed;margin:auto;left:0;top:0;right:0;bottom:0;width:400px;height:220px;">
          <div class="modal-content" style="height:220px;">
            <div class="modal-header">
              <h4 class="modal-title" style="background:url(\'../img/preferences24.png\') no-repeat left center;padding-left:32px;">Control panel | <a href="http://ensistudio.com/" target="_blank">EnSiStudio</a></h4>
            </div>
            <div class="modal-body" style="height:100px;">
		<input type="text" name="u" placeholder="Username" class="form-control login_form_user" />
		<input type="password" name="p" placeholder="Password" class="form-control login_form_pass" />
            </div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Login</button>
		</div>
          </div>
        </div>
      </form><div class="copy" style="display:block;position:fixed;left:0;right:0;bottom:10px;text-align:center"><a href="http://ensistudio.com/" target="_blank">EnSiStudio</a> &copy; '.date('Y').'</div>';
}
?>

<!-- SCRIPTS -->
    <script src="/admin/script/jquery-1.10.2.min.js"></script>
    <script src="/admin/script/jquery-migrate-1.2.1.min.js"></script>
    <script src="/admin/script/jquery-ui.js"></script>
	<?php if($_LOGGED_IN) echo '<script src="/admin/js/ui.js"></script>'; ?>
    <script src="/admin/script/bootstrap.min.js"></script>
    <script src="/admin/script/bootstrap-hover-dropdown.js"></script>
    <script src="/admin/script/html5shiv.js"></script>
    <script src="/admin/script/respond.min.js"></script>
    <script src="/admin/script/jquery.metisMenu.js"></script>
    <script src="/admin/script/jquery.slimscroll.js"></script>
    <script src="/admin/script/jquery.cookie.js"></script>
    <script src="/admin/script/icheck.min.js"></script>
    <script src="/admin/script/custom.min.js"></script>
    <script src="/admin/script/jquery.news-ticker.js"></script>
    <script src="/admin/script/jquery.menu.js"></script>
    <script src="/admin/script/pace.min.js"></script>
    <script src="/admin/script/holder.js"></script>
    <script src="/admin/script/responsive-tabs.js"></script>
    <script src="/admin/script/jquery.flot.js"></script>
    <script src="/admin/script/jquery.flot.categories.js"></script>
    <script src="/admin/script/jquery.flot.pie.js"></script>
    <script src="/admin/script/jquery.flot.tooltip.js"></script>
    <script src="/admin/script/jquery.flot.resize.js"></script>
    <script src="/admin/script/jquery.flot.fillbetween.js"></script>
    <script src="/admin/script/jquery.flot.stack.js"></script>
    <script src="/admin/script/jquery.flot.spline.js"></script>
    <script src="/admin/script/zabuto_calendar.min.js"></script>
    <script src="/admin/script/index.js"></script>
    <!--LOADING SCRIPTS FOR CHARTS-->
    <script src="/admin/script/highcharts.js"></script>
    <script src="/admin/script/data.js"></script>
    <script src="/admin/script/drilldown.js"></script>
    <script src="/admin/script/exporting.js"></script>
    <script src="/admin/script/highcharts-more.js"></script>
    <script src="/admin/script/charts-highchart-pie.js"></script>
    <script src="/admin/script/charts-highchart-more.js"></script>
    <!--CORE JAVASCRIPT-->
    <script>        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-145464-12', 'auto');
        ga('send', 'pageview');


</script>
<script>
    $('#codegen').click(function(){
	 $('#codegenerator').val((Math.random()+'').slice(2, 2 + Math.max(1, Math.min(10, 15))));		
	});
	</script>

<!-- END -->
</body>
</html>
