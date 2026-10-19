<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsParentFolder extends BaseModel
{
    protected $table = 'Ms_ParentFolder';
    protected $primaryKey = 'ParentFolderID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ParentFolderID','ParentFolderName','ParentFolderPath','IsActive',
        'InputDate','InputUser','ModifDate','ModifUser','DeletedBy','DeletedDate',
    ];

    protected $casts = ['IsActive'=>'boolean','InputDate'=>'datetime','ModifDate'=>'datetime','DeletedDate'=>'datetime'];

    public function folderPaths(): HasMany
    {
        return $this->hasMany(MsFolderPath::class, 'ParentFolderID', 'ParentFolderID');
    }
}
