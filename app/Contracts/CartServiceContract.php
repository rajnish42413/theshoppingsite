<?php
namespace App\Contracts;

interface CartServiceContract {
    public function cart();
    public function cart_data($cart_id);
}
