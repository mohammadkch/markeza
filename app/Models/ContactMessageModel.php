<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactMessageModel extends Model
{
    protected $table = 'contact_message';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'full_name',
        'mobile',
        'email',
        'message',
        'session_key',
        'ip_address',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function countForSessionBetween(string $sessionKey, int $start, int $end): int
    {
        return $this->where('session_key', $sessionKey)
            ->where('created_at >=', $start)
            ->where('created_at <', $end)
            ->countAllResults();
    }
}
