<!doctype html>
<head>
	<title>theme-check.run</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Serif:400,700">
	<link rel="stylesheet" href="/style.css">
</head>
<body>
	<div id="main">
		<form id="test" action="/create.php" method="POST">
			<label for="theme">Theme:</label>
			<div id="createFields">
				<input name="theme" type="text" required value="https://themes.svn.wordpress.org/twentyten/3.3/">
				<input type="submit" value="Test">
			</div>
		</form>
	</div>
</body>
