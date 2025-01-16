<?php

namespace App\Models;

use CodeIgniter\Model;

class UrlModel extends Model
{
    protected $table = 'urls';
    protected $primaryKey = 'id';
    protected $allowedFields = ['original_url', 'short_url', 'user_id', 'clicks', 'created_at', 'updated_at'];
    // protected $useTimestamps = false;

    public function getClicksLast24Hours($userId)
{
    $now = date('Y-m-d H:i:s');
    $last24Hours = date('Y-m-d H:i:s', strtotime('-24 hours'));

    // This will return the count of records directly
    return $this->where('user_id', $userId)
        ->where('created_at >=', $last24Hours)
        ->where('created_at <=', $now)
        ->countAllResults(); // Returns the count of records
}

public function getClicksLastWeek($userId)
{
    $now = date('Y-m-d H:i:s');
    $lastWeek = date('Y-m-d H:i:s', strtotime('-1 week'));

    // This will return the count of records directly
    return $this->where('user_id', $userId)
        ->where('created_at >=', $lastWeek)
        ->where('created_at <=', $now)
        ->countAllResults(); // Returns the count of records
}

public function getClicksLastMonth($userId)
{
    $now = date('Y-m-d H:i:s');
    $lastMonth = date('Y-m-d H:i:s', strtotime('-1 month'));

    // This will return the count of records directly
    return $this->where('user_id', $userId)
        ->where('created_at >=', $lastMonth)
        ->where('created_at <=', $now)
        ->countAllResults(); // Returns the count of records
}
}
