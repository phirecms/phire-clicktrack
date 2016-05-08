<?php

namespace Phire\ClickTrack\Table;

use Pop\Db\Record;

class Clicks extends Record
{

    /**
     * Table prefix
     * @var string
     */
    protected $prefix = DB_PREFIX;

    /**
     * Primary keys
     * @var array
     */
    protected $primaryKeys = ['id'];

}