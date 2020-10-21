<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function all();

    public function create();

    public function moveFile();

    public function update($product);

    public function duplicateProduct();
}
