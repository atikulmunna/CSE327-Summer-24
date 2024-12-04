<?php
abstract class OrderDecorator extends Order {
    protected $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }

    abstract public function getTotal();
}

class GiftWrapDecorator extends OrderDecorator {
    private $giftWrapCost = 10; // Example cost for gift wrap

    public function getTotal() {
        return $this->order->getTotal() + $this->giftWrapCost;
    }
}
?>