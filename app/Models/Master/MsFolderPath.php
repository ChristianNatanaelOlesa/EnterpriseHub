<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'ParentFolderPathID',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'ParentFolderPathID',
            'FolderPathID'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            self::class,
            'ParentFolderPathID',
            'FolderPathID'
        );
    }
}
