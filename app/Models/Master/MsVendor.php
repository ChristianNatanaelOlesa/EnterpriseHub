<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsVendor extends BaseModel
{
    protected $table = 'ms_vendor';

    protected $primaryKey = 'VendorID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'VendorID',
        'Vendor',
        'Description',
        'Address',
        'ContactPerson',
        'Phone',
        'Email',
        'IsActive',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
        'DeletedDate' => 'datetime',
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(MsAsset::class, 'VendorID', 'VendorID');
    }
}
