<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    session_start();
    if (empty($_SESSION['list_of_cars'])) {
        $_SESSION['list_of_cars'] = array(
            new Car("1999 Honda CRV", 90000, 6000, "img/honda.jpg"),
            new Car("2014 Tesla Model S", 5000, 35000, "img/tesla.jpg"),
            new Car("2013 Nissan Leaf", 8000, 20000, "img/leaf.jpg"),
            new Car("2009 Toyota Prius", 20000, 15000, "img/toyota.jpg"),
        );
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //routes
    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig')
        ;
    });

    $app->get("/car_form", function() use ($app){
        return $app['twig']->render('search.html.twig')
        ;
    });

    $app->get("/car_results", function() use ($app){

        $cars = Car::getAll();
        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying(($_GET["price"]), ($_GET["mileage"]))) {
                array_push($cars_matching_search, $car);
            }
        }
        return $app['twig']->render('results.html.twig', array('cars' => $cars_matching_search
        ));
    });

    $app->get("/car_sell", function() use ($app){
        return $app['twig']->render('sellCar.html.twig', array('message'=> NULL));

    });

    $app->post("/car_sell", function() use ($app){
        $new_car = new Car($_POST['sell-model'], $_POST['sell-miles'], $_POST['sell-price'], $_POST['sell-photo']);
        $new_car->save();

        return $app['twig']->render('sellCar.html.twig', array(
            'message' => array(
                'text' => 'Thanks for adding a car!',
                'type' => 'info'
            )
        ));
    });

    $app->get("/car_browse", function() use ($app){
        return $app['twig']->render('browse_car.html.twig', array('cars'=> Car::getAll()));

    });

    $app->post('/delete_all', function() use ($app) {
        Car::deleteAll();

        return $app['twig']->render('index.html.twig', array(
            'cars' => Car::getAll()
        ));
    });



    return $app;
?>
