<?php

namespace App\Enums;

enum WorkflowAction: string
{
    case APPROVE = 'APPROVE';
    case REQUEST_REVISION = 'REQUEST_REVISION';
    case REJECT = 'REJECT';
}
