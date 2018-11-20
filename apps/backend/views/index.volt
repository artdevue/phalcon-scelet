<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    {{ getTitle() }}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Valentun Rasulov">
    <meta name="csrf-token" content="" key="">
    <!-- Load Fonts & Stylesheets -->
    {{ assets.outputCss('header') }}
</head>
<body>
    {{ content() }}
<!-- -------------- Scripts -------------- -->
    {{ assets.outputJs('footer') }}
</body>
</html>