<?php

namespace App\Enums;

enum ProcessStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
