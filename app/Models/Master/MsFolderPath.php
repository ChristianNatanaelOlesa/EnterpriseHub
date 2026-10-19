<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\Master\MsParentFolder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MsFolderPath extends BaseModel
{
    protected $table = 'Ms_FolderPath';
    protected $primaryKey = 'FolderPathID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'FolderPathID',
        'FolderName',
        'FolderPath',
        'ParentFolderID',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
        'DeletedDate' => 'datetime',
    ];

    public function parentFolder(): BelongsTo
    {
        return $this->belongsTo(MsParentFolder::class, 'ParentFolderID', 'ParentFolderID');
    }

}
