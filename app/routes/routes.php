<?php
return function($app){
    import_route($app, "Example");
    import_route($app, "Test");
    import_route($app, "Auth");
};