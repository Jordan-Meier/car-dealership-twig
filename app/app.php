<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/dealership.php";

    $app = new Silex\Application();

    $app->get("/car_form", function() {
        return "
        <!DOCTYPE html>
        <html>
            <head>
                <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
                <title>Find your car!</title>
            </head>
            <body>
                <div class='container'>
                    <h1>Find Your Car!</h1>
                    <form action='/car_results'>
                        <div class='form-group'>
                          <label for='price'>Enter Maximum Price:</label>
                          <input id='price' name='price' class='form-control' type='number'>
                        </div>
                        <div class='form-group'>
                          <label for='mileage'>Enter Maximum Mileage:</label>
                          <input id='mileage' name='mileage' class='form-control' type='number'>
                        </div>
                        <button type='submit' class='btn-success'>Create</button>
                    </form>
                </div>
            </body>
        </html>
        ";
    });

    $app->get("/car_results", function() {
        $honda = new Car("1999 Honda CRV", 90000, 6000, "img/honda.jpg");
        $tesla = new Car("2014 Tesla Model S", 5000, 35000, "img/tesla.jpg");
        $nissan = new Car("2013 Nissan Leaf", 8000, 20000, "img/leaf.jpg");
        $toyota = new Car("2009 Toyota Prius", 20000, 15000, "img/toyota.jpg");
        $toyota->setPrice("$12000");
        $cars = array($honda, $tesla, $nissan, $toyota);

        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying(($_GET["price"]), ($_GET["mileage"]))) {
                array_push($cars_matching_search, $car);
            }
        }

        $output = "";
        foreach ($cars_matching_search as $car) {
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
