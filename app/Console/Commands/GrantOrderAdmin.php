<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GrantOrderAdmin extends Command
{
    protected $signature = 'orders:admin {email : Email of an existing verified admin account} {--revoke : Remove order-management access instead}';
    protected $description = 'Disabled: admin authorization is restricted to the single configured House Of Maithili account.';

    public function handle(): int
    {
        $this->error('Admin access cannot be granted or revoked through this command. Only the authorized email can pass the admin gates.');
        return self::FAILURE;
    }
}
