<?php // app/Controllers/Hr/ApprovalsController.php
public function list()
{
  $draw = (int)($_GET['draw'] ?? 1);
  $start = (int)($_GET['start'] ?? 0);
  $length = min( (int)($_GET['length'] ?? 10), 100);

  [$rows, $total] = ChangeRequest::forApprover(auth()->id(), $start, $length);
  return Response::json([
    'draw' => $draw,
    'recordsTotal' => $total,
    'recordsFiltered' => $total,
    'data' => array_map(fn($r)=>[
      'id'=>$r->id,
      'module'=>$r->module,
      'requester'=>$r->requester_name,
      'level'=> "{$r->approver_level}/{$r->max_level}", 
      'created_at'=>$r->created_at
    ], $rows)
  ]);
}

?>