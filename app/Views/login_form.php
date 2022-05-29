<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<title>Halaman Login</title>
</head>
<body>
	<div class="container">
		<div class="alert alert-primary">
			Silahkan Login!
		</div>
		<form action="/login/auth">
			<div class="mb-3 mt-3">
				<label for="username" class="form-label">Username</label>
				<input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
			</div>
			<div class="mb-3">
				<input class="btn btn-primary" type="submit" name="submit" value="Login">
			</div>
		</form>
	</div>
</body>
</html>