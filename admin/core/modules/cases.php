
<? 

if(empty($URIa[4])) {
include('top.php'); menu('Управление играми');
$where = '';
if(!empty($_POST['q'])){
	$where = " WHERE name LIKE '%".$_POST['q']."%'";
	$rows = $db->getRows('SELECT * FROM cases '.$where);
}else{
	$rows = $db->getRows('SELECT * FROM cases ORDER BY id');
}
?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
<div class="col-sm-8">
<h1> <a class="btn btn-warning" href="/admin/mod/cases/add">Добавить</a></h1>
</div>
<div class="col-sm-4">
<form style="width:300px;"  class="navbar-form navbar-right search_form" method="POST" id="search_form">

						<div class="input-group">
							<?$q = (empty($_POST['q'])? '': $_POST['q'])?>
							<input type="text" name="q" value="<?=htmlspecialchars($q)?>" class="form-control" placeholder="Поиск кейса">
							<span class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
							</span>
						</div>
</form>
</div>
<div class="clearfix">
                    </div>
</div>
<br>
<?if($rows):?>
<?foreach($rows as $row):?>
<div class="col-sm-6 col-md-3"><div class="visotaDiva">
<div class="thumbnail">  <img src="../<?=$row['img']?>" width="150" height="150">
<div class="caption">
<h3><?=$row['name']?></h3>
<p>

		<form action="/admin/mod/case" style="width:100px;margin-top: -35px;" class="navbar-form navbar-right search_form" method="POST">
						<div class="input-group">
							<input type="hidden" name="case" value="<?=$row['id']?>" class="form-control" >
							<span class="input-group-btn">
							<button type="submit" class="btn btn-primary">Изменить</button>
							</span>
						</div>

		
		</form>
		<form action="/admin/mod/case" style="width:100px;margin-top: -35px;" class="navbar-form navbar-right search_form" method="POST">
						<div class="input-group">
							<input type="hidden" name="delete" value="<?=$row['id']?>" class="form-control" >
							<span class="input-group-btn">
							<button  type="submit" class="btn btn-danger">Удалить</button>
							</span>
						</div>

		
		</form>
</p></div>
</div></div></div>











<?endforeach;?>
<?endif;
}else if($URIa[4]=='add') {
	$msg = '';
	if(isset($_POST['token']) AND $_POST['token']==$_SESSION['admin_token']) {
		if(!empty($_POST['name']) AND !empty($_POST['disp_name'])) {	
        if(isset($_FILES['upload_image'])){
			$file_name = $_FILES['upload_image']['name'];
			$file_ext=strtolower(end(explode('.',$_FILES['upload_image']['name'])));
			$file_tmp =$_FILES['upload_image']['tmp_name'];
			$expensions= array("jpeg","jpg","png");
            if(in_array($file_ext,$expensions)=== false){
               die('not img');
            }
			$img = "../template/img/cases/".$file_name;
			move_uploaded_file($file_tmp,$img);
		}
			$db->insertRow('INSERT INTO cases SET name = ?, disp_name = ?, img=  ?, status=  ?', array($_POST['name'],$_POST['disp_name'],$img,$_POST['status']));
		
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/cases');exit;
		}else{
			$msg = 'Заполните все поля';
		}
	}
	include('top.php'); menu('Добавление игры');
	
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
                                                                    Имя (en)</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-share"></i>
                                                                    <input id="calssCase" type="text" placeholder="" class="form-control" name="name"/></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="caseName" class="control-label">
                                                                   Имя (en)</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-bolt"></i>
                                                                    <input id="caseName" type="text" placeholder="" class="form-control" name="disp_name"/></div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

														<div class="col-md-4">
                                                     <div class="form-group">
                                                        <label for="casePrice" class="control-label">
                                                           Выпадение</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-credit-card"></i>
                                                            <input id="casePrice" type="text" placeholder="" class="form-control" name="status"/></div>
                                                    </div></div>
													<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<div id="baseimg-upload">
																
																<input type="file" name="upload_image" />
															</div>
														</div>
													</div>	
													</div>
                                                </div>
                                            </div>
											    <div class="form-actions text-right pal">
												     <input type="hidden" name="token" value="<?=$_SESSION['admin_token']?>"/>
                                                     <input id="submit_form" type="submit" class="btn btn-primary" value="Добавить проект"/>
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
                                         
											<p>Поле "Выпадение": 0 - выпадает,1 - только фейкам,2-некому!</p>
											


											 </div>
											</div>
											
											
											
											
											
											
											
                                           
                                               
                                            </div>
                                        </div>
</div>

<? } ?>
</table>