<?php
namespace App\Enums;

enum TransactionStateEnum: string{
    case PENDING = "PENDING";
    case FAILED = "FAILED";
    case COMPLETED = "COMPLETED";
}
