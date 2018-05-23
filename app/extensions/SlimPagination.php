<?php

namespace App\Extensions;

use Illuminate\Pagination\LengthAwarePaginator;

class SlimPagination extends LengthAwarePaginator {

    public $elements;

    public function __construct($items, $total, $perPage, $currentPage = null, array $options = []) {

        parent::__construct($items, $total, $perPage, $currentPage, $options);

        $this->getElements();

        $this->items = $this->items->slice(($currentPage - 1) * $perPage, $perPage);
    }

    public function getElements() {

        return $this->elements = $this->elements();
    }
}