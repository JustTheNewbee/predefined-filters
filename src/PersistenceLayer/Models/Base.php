<?php

namespace Polyloans\Filter\PersistenceLayer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Base extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;
}
