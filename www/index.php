<!doctype html>
<head>
	<title>theme-check.run</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Serif:400,700">
	<link rel="stylesheet" href="/style.css?1">
</head>
<body>
	<div id="main">
		<form id="test" action="/create.php" method="POST">
			<label for="theme">Theme:</label>
			<div id="createFields">
				<input name="theme" id="theme" type="text" required value="https://themes.svn.wordpress.org/twentytwentyone/1.4/">
				<input type="submit" value="Test">
			</div>
			<p>For now, the only supported input is a full SVN URL.</p>
		</form>
	</div>
</body>
