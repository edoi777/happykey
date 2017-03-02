
<?
if(empty($URIa[4])) {
 include('top.php'); menu('Пользователи');


$num = 25;
$page =0;
if(!empty($_POST['page'])){
	$page =$_POST['page'];
}
$page =$_POST['page'];
$count  = $db->getRow('SELECT COUNT(*) as cnt FROM users');

$temp = mysql_fetch_array($count);
$post = $count['cnt'];
$total =(($post -1)/$num) +1;
$total = intval($total);

$page = intval($page);
if(empty($page) or $page <0) $page =1;
if($page > $total) $page = $total;
$start = $page * $num - $num;

if ($page != 1) $prevpage =' <li> <form  method="POST"><input type="hidden" name="page" value="'.($page -1).'" class="form-control" ><button type="submit" class="btn btn-primary">&laquo;</button></form></li>';
if ($page != $total) $nextpage ='<li><form  method="POST"><input type="hidden" name="page" value="'.($page +1).'" class="form-control" ><button type="submit" class="btn btn-primary">&lt;</button></form></li>';

if($page - 5 > 0) $page5left = '<li><form method="POST"><input type="hidden" name="page" value="'.($page -5).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page -5).'</button></form></li>';
if($page - 4 > 0) $page4left = '<li><form method="POST"><input type="hidden" name="page" value="'.($page -4).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page -4).'</button></form></li>';
if($page - 3 > 0) $page3left = '<li><form method="POST"><input type="hidden" name="page" value="'.($page -3).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page -3).'</button></form></li>';
if($page - 2 > 0) $page2left = '<li><form method="POST"><input type="hidden" name="page" value="'.($page -2).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page -2).'</button></form></li>';
if($page - 1 > 0) $page1left = '<li><form method="POST"><input type="hidden" name="page" value="'.($page -1).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page -1).'</button></form></li>';

if($page + 5 > 0 && $page+ 5 <=$total) $page5right = '<li><form method="POST"><input type="hidden" name="page" value="'.($page +5).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page +5).'</button></form></li>';
if($page + 4 > 0 && $page+ 4 <=$total) $page4right = '<li><form method="POST"><input type="hidden" name="page" value="'.($page +4).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page +4).'</button></form></li>';
if($page + 3 > 0 && $page+ 3 <=$total) $page3right = '<li><form method="POST"><input type="hidden" name="page" value="'.($page +3).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page +3).'</button></form></li>';
if($page + 2 > 0 && $page+ 2 <=$total) $page2right = '<li><form method="POST"><input type="hidden" name="page" value="'.($page +2).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page +2).'</button></form></li>';
if($page + 1 > 0 && $page+ 1 <=$total) $page1right = '<li><form method="POST"><input type="hidden" name="page" value="'.($page +1).'" class="form-control" ><button type="submit" class="btn btn-primary">'.($page +1).'</button></form></li>';

$pagehtml = '';
if ($total > 1)
{
$pagehtml= '  <ul class="pagination" style="display: -webkit-box;">'.$prevpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><form method='POST'><input type='hidden' name='page' value='".$page."' class='form-control' ><button type='submit' class='btn btn-info'>".$page."</button></form></li>".$page1right.$page2right.$page3right.$page4right.$page5right.'</ul>';
}
echo $pagehtml;

	    



$where = '';
if(!empty($_POST['q'])){
	$where = " WHERE steam LIKE '%".$_POST['q']."%'";
	$rows = $db->getRows('SELECT * FROM users '.$where);
}else{
	$rows = $db->getRows('SELECT * FROM users ORDER BY id ASC LIMIT '.$start.', '.$num.'');
}
?>

<form style="width:300px;"  class="navbar-form navbar-right search_form" method="POST" id="search_form">
						<div class="input-group">
							<?$q = (empty($_POST['q'])? '': $_POST['q'])?>
							<input type="text" name="q" value="<?=htmlspecialchars($q)?>" class="form-control" placeholder="ID пользователя">
							<span class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
							</span>
						</div>
</form>
<h1> <a class="btn btn-warning" href="/admin/mod/users/add">Добавить</a></h1>
<table style="margin-top:20px; text-align: center;" class="table table-bordered table-striped"><tr><th><center>ID</center></th><th><center>Пользователь</center></th><th><center>Баланс</center></th><th><center>TRADE link</center></th><th><center>БАН</center></th><th><center>Редактировать</center></th></tr>

<?if($rows):?>
<?foreach($rows as $row):?>
<tr>
	<td><?=$row['id']?></td>
	<td><a href="http://steamcommunity.com/profiles/<?=$row['steam']?>" target="_blank"><?=$row['name']?></a><br><?=$row['steamid']?></td>
	<td><?=$row['money']?> руб.</td>
	<td><? if(isset($row['link'])) echo '<span class="label label-success">'.$row['link'].'</span>';?></td>
	<td><? if($row['ban']=="1") echo '<span class="label label-danger">Есть</span>';else echo '<span class="label label-success">Нету</span>';?></td>
	<td><div class="leftgo">
	    <form action="/admin/mod/user" style="width:100px;" class="navbar-form navbar-right search_form" method="POST">
						<div class="input-group">
							<input type="hidden" name="user" value="<?=$row['id']?>" class="form-control" >
							<span class="input-group-btn">
							<button type="submit" class="btn btn-primary">Редактировать</button>
							</span>
						</div>

		
		</form>
		<form action="/admin/mod/user" style="width:100px;" class="navbar-form navbar-right search_form" method="POST">
						<div class="input-group">
							<input type="hidden" name="delete" value="<?=$row['id']?>" class="form-control" >
							<span class="input-group-btn">
							<button type="submit" class="btn btn-danger">Удалить</button>
							</span>
						</div>

		
		</form>
		</div>
	</td>
</tr>
<?endforeach;?>
<?endif;
}
if($URIa[4]=='add') {
	$msg = '';
	if(isset($_POST['token']) AND $_POST['token']==$_SESSION['admin_token']) {
		if(!empty($_POST['steamid']) AND !empty($_POST['fake'])) {	
            $urljson = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=F11B264B88B90C237C13853D9D8A7404&steamids=".$_POST['steamid'], false, $context);
            $data = json_decode($urljson, true);
		    $name = $data['response']['players'][0]['personaname'];
            $ava = $data['response']['players'][0]['avatarfull'];
			$db->insertRow('INSERT INTO users SET steam = ?, name = ?, avatar = ?, admin=  ?', array($_POST['steamid'],$name,$ava,$_POST['fake']));
		
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/users');exit;
		}else{
			$msg = 'Заполните все поля';
		}
	}
	include('top.php'); menu('Добавление пользователя');
	
	?>
	
	</br>
	<div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="panel panel-green">
                                            <div class="panel-heading">
                                                Общее описание</div>
                                            <div class="panel-body pan">
   <form  enctype="multipart/form-data" method="POST">
                                                <div class="form-body pal">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                               <label for="calssCase" class="control-label">
                                                                    STEAMID</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-share"></i>
                                                                    <input id="calssCase" type="text" placeholder="" class="form-control" name="steamid"/></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="caseName" class="control-label">
                                                                  Фейковый?</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-bolt"></i>
                                                                    <input id="caseName" type="text" placeholder="" class="form-control" name="fake"/></div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                            </div>
											    <div class="form-actions text-right pal">
												     <input type="hidden" name="token" value="<?=$_SESSION['admin_token']?>"/>
                                                     <input id="submit_form" type="submit" class="btn btn-primary" value="Добавить пользователя"/>
                                                </div>
                                                </form>
                                        </div>
                                </div>
                                 <div class="col-lg-4">

                                   <div class="panel panel-green" style="background:#fff;">
                                            <div class="panel-heading">
                                                FAQ</div>
                                            <div class="panel-body pan">
											<br>
											<center>
									</center>
											  <div class="col-lg-12">
											<div class="tab-content">
                                         
											<p>Поле "Фейковый": 0 - нет,2 - да!</p>
											


											 </div>
											</div>
											
											
											
											
											
											
											
                                           
                                               
                                            </div>
                                        </div>
</div>

<? } ?>
</table>