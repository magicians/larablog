<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * @param string $fileContent
     * @param string $filename
     * @param string $mimetype
     * @return Response
     */
    public function respondDownload($fileContent, $filename, $mimetype)
    {
        return (new Response($fileContent, 200))
            ->header('Content-Type', $mimetype)
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
    
    /**
     * @param array $permissions
     */
    protected function setNeededPermissions(array $permissions)
    {
        foreach ($permissions as $permission => $methods) {
            $this->middleware('needsPermission:' . $permission, ['only' => $methods]);
        }
    }
}
