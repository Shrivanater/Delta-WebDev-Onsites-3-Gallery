<?php
include 'functions.php';
$msg = '';
if (isset($_FILES['fileUpload'], $_POST['title'])) {
	$target_dir = 'mediaGoHere/';
	$media_path = $target_dir . basename($_FILES['fileUpload']['name']);
	
	$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);

	if (!empty($_FILES['fileUpload']['tmp_name'] && ($ext === 'jpg' || $ext === 'jpeg' || $ext === 'png' || $ext === 'gif' || $ext === 'mp4'))) {
		if(file_exists($media_path)){
			$msg = "File already exists in gallery";
		}
		else{
			move_uploaded_file($_FILES['fileUpload']['tmp_name'], $media_path);
			$pdo = pdo_connect_mysql();
			$stmt = $pdo->prepare('INSERT INTO media (title, filepath, uploaded_date) VALUES (?, ?, CURRENT_TIMESTAMP)');
			$stmt->execute([ $_POST['title'], $media_path ]);
			$msg = 'File uploaded successfully!';	
		}
	} 
    else {
		
		$msg = 'Upload Failed!';
	}
}
?>


<?=pageHeader('Upload File')?>

<div class="content upload">
	<h2>Upload File. Allowed formats: .jpg .jpeg .png .gif .mp4</h2>
	<form action = "upload.php" method = "post" enctype = "multipart/form-data">
		<label for = "file">Choose File</label>
		<input type = "file" name = "fileUpload" id = "fileUpload">
		<label for = "title">Title</label>
		<input type = "text" name = "title" id = "title">
	    <input type = "submit" value = "Upload Image" name = "submit">
	</form>
	<p><?=$msg?></p>
</div>

<?=pageFooter()?>