/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require ('../css/app.css');
//import 'bootstrap';
//import 'bootstrap/dist/css/bootstrap.min.css';

//any javascript
//import 'bootstrap/dist/js/bootstrap';
//import 'bootstrap/dist/js/bootstrap.bundle.min';

// загружает пакет jquery из node_modules
//import $ from 'jquery/dist/jquery.min.js';

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $(".#wrapper").toggleClass("toggled");
    });