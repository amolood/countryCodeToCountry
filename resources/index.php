<?php

use Amolood\countrycodeToCountryname\CountryCode;
use Amolood\countrycodeToCountryname\Locale;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';

$selectedLocale = !empty($_GET['locale']) ? $_GET['locale'] : Locale::DEFAULT_LOCALE;

$locale = new Locale($selectedLocale);

$countryCodes = new CountryCode($locale);
?>

<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Country codes</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <h1>Country Codes With localized labels</h1>

    <div class="row">
        <div class="col-md-offset-4">
            <h2>Used locale: <em><?= $locale->name(); ?></em></h2>
            <form class="form-inline" action="" method="get" role="form">

                <div class="form-group">
                    <label for="locale">Change: <span class="text-danger">*</span></label>
                    <select name="locale" id="locale" class="form-control" required="required">
                        <option value="" disabled="disabled" selected="selected"><?= $locale->name(); ?></option>
                        <?php foreach (Locale::all() as $localeName): ?>
                            <option value="<?= $localeName; ?>"><?= $localeName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Change</button>
            </form>
        </div>
    </div>

    <form class="row" action="#" role="form">
        <div class="form-group">
            <label for="country">Select Country: <span class="text-danger">*</span></label>
            <select name="country" id="country" class="form-control">
                <option value="" disabled="disabled" selected="selected"> -- Select One --</option>
                <?php foreach ($countryCodes->all() as $code => $label): ?>
                    <option value="<?= $code; ?>"><?= $label; ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </form>
</div>

</body>
</html>
