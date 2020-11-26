<?php

namespace App\DomainObjects\Enums;

class WidgetStartBehaviour extends BaseEnum
{
    public const ON_CLICK = 'ON_CLICK';
    public const OPEN_AUTOMATICALLY = 'OPEN_AUTOMATICALLY';
    public const ON_HOVER = 'ON_HOVER';
}