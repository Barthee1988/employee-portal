<?php
namespace App\Controllers;

use App\Models\Leave;
use App\Services\WorkflowService;
use App\Helpers\Response;
use App\Helpers\Validator;

class LeaveController {
  public function create() {
    Validator::require(['start_date','end_date','type','reason']);
    $payload = [
      'start_date' => $_POST['start_date'],
      'end_date'   => $_POST['end_date'],
      'half_day'   => $_POST['half_day'] ?? 'none',
      'type'       => $_POST['type'],
      'reason'     => trim($_POST['reason']),
      'substitutes'=> $_POST['substitutes'] ?? []
    ];
    $leaveId = Leave::create(auth()->id(), $payload, $_FILES['medical_doc'] ?? null);
    WorkflowService::init('leave', $leaveId, auth()->user()->department);
    return Response::json(['ok'=>true,'id'=>$leaveId], 201);
  }

  public function approve($params) {
    Rbac::must(['hr','manager','lead']); // example policy
    $id = (int)$params['id'];
    $result = WorkflowService::advance('leave', $id, auth()->id(), 'approved', $_POST['remarks'] ?? null);
    return Response::json($result);
  }

  public function reject($params) {
    Rbac::must(['hr','manager','lead']);
    $id = (int)$params['id'];
    $result = WorkflowService::advance('leave', $id, auth()->id(), 'rejected', $_POST['remarks'] ?? null);
    return Response::json($result);
  }
}
?>