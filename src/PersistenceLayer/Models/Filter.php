<?php

namespace Polyloans\Filter\PersistenceLayer\Models;

class Filter extends Base
{
    protected $table = 'polyloans_filters';

    public $fillable = [
        'name',
        'filter_key',
        'filter_url',
        'user_id',
        'form_data',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
