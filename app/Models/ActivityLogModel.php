<?php
namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'activity', 'description', 'ip_address', 'user_agent'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function logActivity($userId, $activity, $description = '')
    {
        $request = service('request');
        
        $data = [
            'user_id' => $userId,
            'activity' => $activity,
            'description' => $description,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent()->getAgentString()
        ];
        
        return $this->insert($data);
    }

    public function getUserActivities($userId, $limit = 50)
    {
        return $this->where('user_id', $userId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll($limit);
    }
}