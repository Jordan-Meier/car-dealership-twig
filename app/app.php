<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/dealership.php";

    $app = new Silex\Application();

    $app->get("/", function() {
        $honda = new Car("1999 Honda CRV", 90000, 6000, "img/honda.jpg");
        $tesla = new Car("2014 Tesla Model S", 5000, 35000, "img/tesla.jpg");
        $nissan = new Car("2013 Nissan Leaf", 8000, 20000, "img/leaf.jpg");
        $toyota = new Car("2009 Toyota Prius", 20000, 15000, "img/toyota.jpg");
        $toyota->setPrice("$12000");
        $cars = array($honda, $tesla, $nissan, $toyota);

        $output = "";
        foreach ($cars as $car) {
            $output = $output . "<div class='row'>
                <div class='col-md-6'>
                    <h1>" . $car->getModel() . "</h1>
                </div>
                <div class='col-md-6'>
                    <p>$" . $car->getPrice() . "</p>
                    <p>" . $car->getMiles() . "</p>
                    <img src=" . $car->getPhoto() . ">
                </div>
            </div>
            ";
        }
        return $output;

    });

    return $app;
?>
