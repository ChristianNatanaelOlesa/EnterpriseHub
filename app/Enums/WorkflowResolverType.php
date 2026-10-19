<?php

namespace App\Enums;

enum WorkflowResolverType: string
{
    case REQUESTER_REPORT_TO = 'REQUESTER_REPORT_TO';
    case TARGET_EMPLOYEE_REPORT_TO = 'TARGET_EMPLOYEE_REPORT_TO';
    case HEAD_DEPARTMENT = 'HEAD_DEPARTMENT';
    case HEAD_DIVISION = 'HEAD_DIVISION';
    case DIRECTOR = 'DIRECTOR';
    case FIXED_USER = 'FIXED_USER';
    case GROUP = 'GROUP';
}
