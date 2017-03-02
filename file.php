<?php
			if(isset($_FILES['codestxt'])){
				
			    $file_name = $_FILES['codestxt']['name'];
			    $file_ext=strtolower(end(explode('.',$_FILES['codestxt']['name'])));
			    $expensions= array("txt");
                if(in_array($file_ext,$expensions)=== false){
                   die('not txt');
                }
			    $img  = "../".$file_name;
			    $sqlimg = "/".$file_name;
			    move_uploaded_file($_FILES['codestxt']['tmp_name'],$img);
			   	$f = fopen($img, "r");
	            while (!feof($f)) { 
	                $arrM = explode(":",fgets($f)); 
	                echo "<p>code" . $arrM[1] . " game " . $arrM[0]. "</p>"; 

	            }
	            fclose($f);
		    }
			?>
			 <form  enctype="multipart/form-data" method="POST">
			
				<input type="file" name="codestxt" />
				<input id="submit_form" type="submit" class="btn btn-primary" value="Добавить проект"/>
				</form>