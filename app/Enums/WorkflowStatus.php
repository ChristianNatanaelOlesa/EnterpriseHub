<?php

namespace App\Enums;

enum WorkflowStatus: string
{
    case DRAFT = 'DRAFT';
    case WAITING_APPROVAL = 'WAITING_APPROVAL';
    case REVISION_REQUIRED = 'REVISION_REQUIRED';
    case REJECTED = 'REJECTED';
    case APPROVED = 'APPROVED';
    case CANCELLED = 'CANCELLED';
    case COMPLETED = 'COMPLETED';
}
