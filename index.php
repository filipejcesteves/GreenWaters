<!doctype html>
<html lang="pt" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
    <meta name="author" content="Filipe_Licinio"/>
    <meta name="copyright" content="Licensed under GPL and MIT."/>
    <meta name="description" content="Célula de reaproveitamento de águas cinzentas de baixo custo."/>

    <title>Green Waters</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="assets/css/master.css">
</head>
<body>
<?php
require_once('assets/scripts/php/session.php');
ie_box();
?>
<div class="container_12">
    <div class="grid_12">
        <div class="grid_12">
            <h1><a href="">Green Waters</a></h1>
        </div>
        <?php if (!session_is_valid()) { ?>
        <div class="grid_5 push_7">
            <form id="login_form" method="post">
                <input type="text" id="username" name="username" placeholder="Username">
                <input type="password" id="password" name="password" placeholder="Password">
                <button id="login">Login</button>
            </form>
        </div>
        <?php } else { ?>
        <div class="grid_2 push_10 align_right">
            <form id="logout_form" method="post">
                <span id="logged_user"><?php echo get_username(); ?></span>
                <button id="logout">Logout</button>
            </form>
        </div>
        <?php } ?>
        <div id="waiting" class="float_right"></div>
    </div>
</div>
<div class="container_12">
    <?php if (!session_is_valid()) { ?>
    <div class="grid_10 push_1">
        <p>
            Water is one of the world's most valuable resources and for a sustainable future, society must move towards
            the goal of efficient and appropriate water use. In water scarcity regions or facing droughts, wastewater
            reuse is already a common practice in the context of water resources management. Many solutions have been
            proposed and commercial equipments are already available. However, due to the inclusion of some kind of
            biological, chemical or mechanical treatment, they become expensive with costly maintenance and it´s
            installation requires complex adaptation works.
        </p>

        <p>
            Greywater, the wastewater generated from in house activities such as washing and bathing, can be directly
            reused in garden watering or inside the buildings in toilet flushing. GreenWaters is a new greywater reuse
            prototype being developed at the Polytechnic Institute of Coimbra. This system is quite simple, small in
            size, doesn’t require considerable adaptation works, complex filters or treatments and can be easily
            installed in any existing or new building - domestic, industrial, commercial and schools. It comprises a
            tank with a pump and an intelligent mechanism that monitors the water quality and manages the storage and
            the distribution.
        </p>


        <video class="grid_4 prefix_3 suffix_3 bottom_15" autoplay="autoplay" loop="loop" preload="auto">
            <source src="assets/videos/presentation.mp4" type="video/mp4">
            <source src="assets/videos/presentation.ogv" type="video/ogg">
            Your browser does not support the video tag.
        </video>


        <p>
            The prototype is being tested in a bathroom at the engineering campus and is actually providing a 25% direct
            reduction of the water used, plus an estimated indirect reduction of 5% through the toilet leakage detection
            performed by the intelligent system and internet monitoring. The energy consumption of the complete system
            represents less than 5% of the reduction in the water bill.
        </p>

        <p>
            The results obtained with this pilot experiment showed that the installation of this solution in the five
            school campus of the Polytechnic Institute of Coimbra could represent a water bill reduction of about
            45,000€/year. As indirect consequence, the local water company could attain an electric energy reduction of
            more than 5,300kWh/year (a saving greater than 750€/year), corresponding to a reduction in CO2 emissions of
            about 2.8ton/year.
        </p>

        <p>
            By reducing the water consumption, the wastewater generation, and the CO2 emissions, this system promises to
            be economically sustainable and environment friendly, and certainly will contribute to the buildings
            sustainability.
        </p>
    </div>
    <?php } else { ?>
    <?php require_once('assets/scripts/php/utils.php'); ?>
    <?php if (is_admin()) { ?>
        Olá administrador :)
        <?php } else { ?>
        <div class="grid_10 push_1">
            <?php draw_usage_chart(get_username()); ?>
        </div>
        <?php } ?>
    <?php } ?>
</div>
<div class="container_12">
    <div class="grid_8 push_2">
        <hr>
    </div>
    <div class="grid_12 align_center">
        <footer>Copyright &copy 2012 GreenTech, Sustainable Way of Life | All rights reserved</footer>
    </div>
</div>
</body>

<!-- Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="assets/scripts/js/adapt.config.js"></script>
<script src="assets/scripts/js/adapt.min.js"></script>
<script src="assets/scripts/js/jquery.formalize.min.js"></script>
<script src="assets/scripts/js/plugins.js"></script>
<script src="assets/scripts/js/main.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function () {

    });
</script>
</html>