<?php
    include 'functions.php';
    $pdo = pdo_connect_mysql();

    $stmt = $pdo->query('SELECT * FROM media ORDER BY uploaded_date DESC');
    $things= $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=pageHeader('Gallery')?>

<div class = "content home">
    <h2>hi dis a gallery</h2>
    <p>Click on a file to get its URL</p> 
    <label for = "mediaURL"><b>URL: </b></label>
    <input type = "text" id = "mediaURL"/>
    <a href= "upload.php" class = "upload-media">Upload File</a>

    <h2>Images & GIFs</h2>
    <div class = "images">
        <?php foreach($things as $thing): ?>
        <?php if(file_exists($thing['filepath'])): ?>
            <?php $ext = substr($thing['filepath'], -3); ?>
            <?php if(($ext === 'jpg' || $ext === 'jpeg' || $ext === 'png' || $ext === 'gif')): ?>
                <img src = "<?=$thing['filepath']?>" data-id = "<?=$thing['id']?>" data-title = "<?=$thing['title']?>" width = "300" height = "200">             
            <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>           
    </div>

    <h2>Videos</h2>
    <div class = "videos">
        <?php foreach($things as $thing): ?>
        <?php if(file_exists($thing['filepath'])): ?>
            <?php $ext = substr($thing['filepath'], -3); ?>
            <?php if($ext === 'mp4'): ?>
                <video src = "<?=$thing['filepath']?>" data-id = "<?=$thing['id']?>" data-title = "<?=$thing['title']?>" width = "300" height = "200" controls>
            <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>           
    </div> 
              
</div>

<script>
    let images = document.querySelectorAll('img');
    images.forEach(image => {
        image.addEventListener('click', event => {
            document.getElementById("mediaURL").value = image.currentSrc;         
        })
    })

    let vids = document.querySelectorAll('video');
    vids.forEach(vid => {
        vid.addEventListener('click', event => {
            document.getElementById("mediaURL").value = vid.src;         
        })
    })

</script>

<?=pageFooter()?>