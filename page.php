<?php
//get artifact to load
if (isset($_GET['v'])) {
	if ($_GET['v']) {
		$v = strtolower($_GET['v']);
	} else $v = 'index';
} else {
	$_GET['v'] = 'index';
	$v = $_GET['v'];
}

include 'assets/parser.php';
include 'assets/artifact.php';

//name of directory for artifact declarations
$pageDirectory = 'pages';

//single parser for all artifacts
$parser = new Parser();

//array holding artifacts
$artifacts = array();

//creates and formats artifacts
createArtifacts();
formatArtifacts();

//load artifact
if (getArtifact($v) != null) $artifact = getArtifact($v);
//if artifact doesn't exist, load 404
else $artifact = getArtifact('404');
?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Purity - <?php echo ucfirst($artifact->attributes['name']);?></title>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700|Roboto+Mono">
	<link rel="stylesheet" type="text/css" href="assets/styles/style.css?ver=<?php echo filemtime('assets/styles/style.css');?>">
</head>

<?php 
if ($artifact->attributes['white'] == 'true') {
	echo
	'
	<style>
	.header-title {
		color: #fff;
	}
	</style>
	';
}
?>

<body>
	<div id="header">
		<div class="header-image" style="background-image: url(<?php echo $artifact->attributes['image'];?>)">
			<span class="header-title"><?php echo $artifact->attributes['image name'];?></span>
		</div>
	</div>

	<div id="title">
		<h1 class="title"><?php echo $artifact->attributes['title'];?></h1>
	</div>

	<div id="body">
		<!--
		An artifact's `content` attribute must be placed inside a <p> tag with the class "text" assigned to it.
		This is because block elements break the <p> tag.

		The parser automatically starts another <p class="text"> after those elements, which is why the content needs
		to be in a <p class="text"> tag.

		If you wish to use another class name, this can be changed by simply switching the class name for your own,
		inside the parser functions: createTitleList, createLinkList, createDivider, createSubtitle.
		-->
		<p class="text"><?php echo $artifact->attributes['content'];?></p>
		</p>
	</div>

	<div id="footer">
		<p class="text">
		Tags:
		<?php
			if ($artifact->tags) {
				foreach($artifact->tags as $tag) {
					if ($tag !== end($artifact->tags)) echo $tag.', ';
					else echo $tag;
				}
			}
		?>
		<?php if ($artifact->attributes['github']) echo '<br><br><span class="github">'.$artifact->attributes['github'].'</span>';?>
		</p>
	</div>
</body>
</html>