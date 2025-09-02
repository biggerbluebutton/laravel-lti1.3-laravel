<?php
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use xcesaralejandro\lti1p3\Http\Requests\NewPlatformRequest;
use App\Models\LtiPlatform;

class PlatformsController {

    public function index() : View {
        $platforms = $platforms = LtiPlatform::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$lookup' => [
                        'from'         => 'lti_deployments',
                        'localField'   => '_id',              // LtiPlatform _id
                        'foreignField' => 'lti_platform_id',  // in LtiDeployment
                        'as'           => 'deployments',
                    ],
                ],
                [
                    '$addFields' => [
                        'deployments_count' => ['$size' => '$deployments'],
                    ],
                ],
                [
                    '$project' => [
                        'deployments' => 0, // drop the big array, keep only the count
                    ],
                ],
            ]);
        });
        return View('lti1p3::admin.platforms.index')->with([
            'platforms' => $platforms
        ]);
    }

    public function create() : View {
        return View('lti1p3::admin.platforms.create');
    }

    public function store(NewPlatformRequest $request) : View {
        $record = $request->all();
        $record['deployment_id_autoregister'] = isset($request->deployment_id_autoregister);
        LtiPlatform::create($record);
        return View('lti1p3::admin.platforms.create')
        ->with(['wasCreated' => true]);
    }

    public function show($id) : mixed {
        return redirect()->back();
    }

    public function edit($id) : mixed {
        $platform = LtiPlatform::findOrFail($id);
        return View('lti1p3::admin.platforms.config')
        ->with('platform', $platform);
    }

    public function update(Request $request, $id) : mixed {
        $platform = LtiPlatform::findOrFail($id);
        $platform->fill($request->all());
        $platform->deployment_id_autoregister = isset($request->deployment_id_autoregister);
        $platform->update();
        return View('lti1p3::admin.platforms.config')
        ->with(['wasUpdated' => true, 'platform' => $platform]);
    }

    public function destroy($id) : mixed {
        LtiPlatform::destroy($id);
        return redirect()->back();
    }
}
