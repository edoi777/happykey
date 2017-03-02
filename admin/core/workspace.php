<div id="header-topbar-option-demo" class="page-header-topbar">
            <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
               
                <a id="logo" class="navbar-brand"><span class="fa fa-rocket"></span><span class="logo-text">AdminPanel</span><span style="display: none" class="logo-text-icon">µ</span></a></div>
            <div class="topbar-main">
                
               
                <ul class="nav navbar navbar-top-links navbar-right mbn">
                    <li class="dropdown topbar-user"><a data-hover="dropdown" href="#" class="dropdown-toggle"><img src="<? echo $_SESSION["avatar"]; ?>" alt="" class="img-responsive img-circle">&nbsp;<span class="hidden-xs"><? echo $_SESSION["name"]; ?></span>&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            <li><a href="/?logout"><i class="fa fa-key"></i>Выход</a></li>
                        </ul>
                    </li>
                                   </ul>
            </div>
        </nav>
        </div>

<div class="wrapper">

	<div class="sidebar">

		<div class="list-group">
			<a href="/admin/" class="list-group-item list-group-item_icon" style="background-image:url('/admin/img/history24.png');">		
			Статистика
			</a>
			<a href="/admin/mod/users" class="list-group-item list-group-item_icon" style="background-image:url('/admin/img/history24.png');">
			Пользователи
			</a>
			<a href="/admin/mod/vauchers" class="list-group-item list-group-item_icon" style="background-image:url('/admin/img/history24.png');">
			Ваучеры
			</a>
			<a href="/admin/mod/promo" class="list-group-item list-group-item_icon" style="background-image:url('/admin/img/history24.png');">
			Промокоды
			</a>
		</div>

		<div class="list-group">
		<a href="/admin/mod/cases" class="list-group-item list-group-item_icon" style="background-image:url('/admin/img/preferences24.png');">
			Управление играми
			</a>
		</div>

	</div>
	
	<div class="page"><?php 
	$MODULE = ($URIa[2]=='mod' && !empty($URIa[3]))?str_replace('..','',$URIa[3]):'index';
	$MODULES_DIR = $_SERVER['DOCUMENT_ROOT'].'/admin/core/modules/';
	if(file_exists($MODULES_DIR.$MODULE.'.php')) include($MODULES_DIR.$MODULE.'.php');
	else include($MODULES_DIR.'404.php');
?></div>
</div>
