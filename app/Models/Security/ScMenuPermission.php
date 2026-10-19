<?php

namespace App\Models\Security;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScMenuPermission extends BaseModel
{
    protected $table = 'sc_menu_permission';
    protected $primaryKey = 'MenuPermissionID';

    protected $fillable = [
        'MenuID', 'PermissionID', 'IsActive', 'InputUser', 'InputDate',
        'ModifUser', 'ModifDate', 'DeletedBy', 'DeletedDate',
    ];

    protected $casts = ['IsActive' => 'boolean'];

    public function menu(): BelongsTo { return $this->belongsTo(ScMenu::class, 'MenuID', 'MenuID'); }
    public function permission(): BelongsTo { return $this->belongsTo(ScPermission::class, 'PermissionID', 'PermissionID'); }
}
