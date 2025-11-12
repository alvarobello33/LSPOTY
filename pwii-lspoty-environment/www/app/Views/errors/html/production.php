<!-- Modificació de la pàgina Whoops -->
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $exception->getMessage() ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<div class="container text-center mt-5">
    <h1><?= esc($exception->getMessage()) ?></h1>
    <br>
    <h2><?= lang('app.errorNoSpecified') ?></h2>
    <br>
    <br>
    <h2><a href="<?= site_url('home') ?>">Home</a></h2>
</div>
</body>
</html>

