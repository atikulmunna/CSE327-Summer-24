<?php
//factory design pattern
abstract class Product {
    protected $product_id;
    protected $name;
    protected $description;
    protected $price;
    protected $image_url;
    protected $product_type;

    public function __construct($product_id, $name, $description, $price, $image_url) {
        $this->product_id = $product_id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image_url = $image_url;
    }

    abstract public function getProductType();
}

class LandingProduct extends Product {
    public function __construct($product_id, $name, $description, $price, $image_url) {
        parent::__construct($product_id, $name, $description, $price, $image_url);
        $this->product_type = 'landing';
    }

    public function getProductType() {
        return $this->product_type;
    }
}

class IndoorProduct extends Product {
    public function __construct($product_id, $name, $description, $price, $image_url) {
        parent::__construct($product_id, $name, $description, $price, $image_url);
        $this->product_type = 'indoor';
    }

    public function getProductType() {
        return $this->product_type;
    }
}

class OutdoorProduct extends Product {
    public function __construct($product_id, $name, $description, $price, $image_url) {
        parent::__construct($product_id, $name, $description, $price, $image_url);
        $this->product_type = 'outdoor';
    }

    public function getProductType() {
        return $this->product_type;
    }
}

class FertilizerProduct extends Product {
    public function __construct($product_id, $name, $description, $price, $image_url) {
        parent::__construct($product_id, $name, $description, $price, $image_url);
        $this->product_type = 'fertilizer';
    }

    public function getProductType() {
        return $this->product_type;
    }
}

class ToolsProduct extends Product {
    public function __construct($product_id, $name, $description, $price, $image_url) {
        parent::__construct($product_id, $name, $description, $price, $image_url);
        $this->product_type = 'tools';
    }

    public function getProductType() {
        return $this->product_type;
    }
}
?>

<?php
class ProductFactory {
    public static function createProduct($type, $product_id, $name, $description, $price, $image_url) {
        switch ($type) {
            case 'landing':
                return new LandingProduct($product_id, $name, $description, $price, $image_url);
            case 'indoor':
                return new IndoorProduct($product_id, $name, $description, $price, $image_url);
            case 'outdoor':
                return new OutdoorProduct($product_id, $name, $description, $price, $image_url);
            case 'fertilizer':
                return new FertilizerProduct($product_id, $name, $description, $price, $image_url);
            case 'tools':
                return new ToolsProduct($product_id, $name, $description, $price, $image_url);
            default:
                throw new Exception("Invalid product type");
        }
    }
}
?>