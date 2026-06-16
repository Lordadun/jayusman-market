<?php
namespace App\Http\Controllers; use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
public function index(Request $request)
{
$logs = AuditLog::with('user')
->when($request->module, function ($query) use ($request) {
$query->where('module', $request->module);
})
->when($request->action, function ($query) use ($request) {
$query->where('action', $request->action);
})
->when($request->start_date, function ($query) use ($request) {
$query->whereDate('created_at', '>=', $request->start_date);
})
->when($request->end_date, function ($query) use ($request) {
$query->whereDate('created_at', '<=', $request->end_date);
})
->latest()
->paginate(15);

return view('audit_logs.index', compact('logs'));
}
}
