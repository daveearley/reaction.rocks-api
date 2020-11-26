<?php

namespace App\Transformer\Interfaces;

interface HasIncludes
{
    /**
     * Return the available includes for a transformer.
     *
     * This should return a map like so:
     *
     * return [
     *      'tickets' => TicketDomainObject::class
     * ]
     *
     * You will need to pass in the data to be included from the controller.
     *
     * @return array
     */
    public function getIncludes(): array;
}
