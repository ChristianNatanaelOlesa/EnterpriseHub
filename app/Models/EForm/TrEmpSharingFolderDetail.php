<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Master\MsFolderPath;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpSharingFolderDetail extends BaseModel
{
    protected $table = 'Tr_EmpSharingFolderDetail';
    protected $primaryKey = 'EmpSharingFolderDetailID';

    protected $fillable = [
        'EmpSharingFolderID',
        'FolderPathID',
        'ParentFolderPathID',
        'FolderName',
        'RequestedPath',
        'AccessType',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function header(): BelongsTo
    {
        return $this->belongsTo(
            TrEmpSharingFolder::class,
            'EmpSharingFolderID',
            'EmpSharingFolderID'
        );
    }

    public function folderPath(): BelongsTo
    {
        return $this->belongsTo(
            MsFolderPath::class,
            'FolderPathID',
            'FolderPathID'
        );
    }

    public function parentFolder(): BelongsTo
    {
        return $this->belongsTo(
            MsFolderPath::class,
            'ParentFolderPathID',
            'FolderPathID'
        );
    }
}
