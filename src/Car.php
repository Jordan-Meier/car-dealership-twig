<?php
class Car
{
    private $make_model;
    private $price;
    private $miles;
    private $photo;

    function __construct($car_model, $car_miles, $car_price, $car_photo)
    {
        $this->make_model = $car_model;
        $this->price = $car_price;
        $this->miles = $car_miles;
        $this->photo = $car_photo;
    }


    function setPrice($new_price)
    {
        $float_price = (float) $new_price;
        if ($float_price != 0) {
            $this->price = $float_price;
        }
        else {
            $this->price = $new_price;
        }
    }

    function getPrice()
    {
        return $this->price;
    }

    function getModel()
    {
        return $this->make_model;
    }

    function getMiles ()
    {
        return $this->miles;
    }

    function getPhoto ()
    {
        return $this->photo;
    }

    function worthBuying($max_price, $max_miles)
    {
        return ($this->price <= ($max_price + 500) && $this->miles <= $max_miles);
    }

    function save()
    {
        array_push($_SESSION['list_of_cars'], $this);
    }

    static function getAll()
    {
        return $_SESSION['list_of_cars'];
    }

    static function deleteAll()
    {
        $_SESSION['list_of_cars'] = array();
    }

}    

?>
