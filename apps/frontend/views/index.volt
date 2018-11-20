<!DOCTYPE html>
<!--[if (IE 8)&!(IEMobile)]>
<html class="no-js lt-ie9" lang="{{ config.lang_active }}"><![endif]-->
<!--[if (gte IE 9)| IEMobile |!(IE)]><!-->
<html class="no-js" lang="{{ config.lang_active }}"><!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>404 — Page Not Found</title>
    <meta name="description" content="">
    <meta name="author" content="Valentyn Rasulov">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <link rel="shortcut icon" href="/favicon.ico">
    <meta http-equiv="cleartype" content="on">

    <!-- Load Fonts & Stylesheets -->
    {{ assets.outputCss('header') }}

</head>
<body class="">
<main role="main" id="main">
    {{ content() }}
</main>
<!-- -------------- Scripts -------------- -->
{{ assets.outputJs('footer') }}
</body>
</html>