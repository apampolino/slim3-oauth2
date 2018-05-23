<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

abstract class SlimController {

    protected $container;

    public function __construct(ContainerInterface $container) {
        
        $this->container = $container;

        // Load Eloquent
        $this->container->eloquent;
    }
}