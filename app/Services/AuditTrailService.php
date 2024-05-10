<?php

namespace App\Service;

use App\Exports\AuditTrailExport;
use App\Models\AuditTrail;
use App\Repositories\AuditTrailRepository;
use App\Results\ErrorCollection;
use App\Http\Requests\AuditTrailRequest;
use App\Results\GeneralResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditTrailService
{
    private $auditTrailRepository;

    public function __construct(
        AuditTrailRepository $auditTrailRepository
    )
    {
        $this->auditTrailRepository = $auditTrailRepository;
    }

    /**
     * @param string $activity
     * @param string $createdBy
     *
     * @return bool
     */
    public static function saveActivity(string $activity)
    {
        AuditTrail::create([
            'action' => $activity,
        ]);
    }
}
