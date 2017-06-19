<?php
include_once( 'src/App.php' );

$dir_obj = \DirListing\Directory::Instance();
$files = $dir_obj->getFiles();
$dirs = $dir_obj->getDirectories();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Directory Listing</title>
	<link rel="stylesheet" href="css/styles.min.css">
</head>
<body>

<div class="container">
	<div>
		<?php if (!empty($dir_obj->getPreviousDirectory())) { ?>
			<a class="btn" href="?dir=<?php echo $dir_obj->getPreviousSanitizedDirectory(); ?>">Back</a>
		<?php } ?>
	</div>

	<ul class="listing">
		<?php if (!empty($dirs)) { ?>
			<?php foreach ($dirs as $dir) { ?>
				<li><a href="?dir=<?php echo $dir['dir'] . '/' . $dir['name']; ?>"><?php echo $dir['name']; ?></a></li>
			<?php } ?>
		<?php } ?>

		<?php if (!empty($files)) { ?>
			<?php foreach ($files as $file) { ?>
				<li><a href="<?php echo $file['dir'] . '/' . $file['name']; ?>" download="<?php echo $file['name']; ?>"><?php echo $file['name']; ?></a></li>
			<?php } ?>
		<?php } ?>
	</ul>
</div>

<script src="js/main.min.js"></script>
</body>
</html>