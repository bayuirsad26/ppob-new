<?php
namespace App\Enums;

enum TransactionStateEnum: string{
    case PENDING = "PENDING";
    case PROGRESS = "PROGRESS";
    case COMPLETED = "COMPLETED";
}