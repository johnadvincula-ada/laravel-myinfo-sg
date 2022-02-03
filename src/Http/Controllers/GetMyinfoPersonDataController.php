<?php

namespace Ziming\LaravelMyinfoSg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ziming\LaravelMyinfoSg\Exceptions\InvalidStateException;
use Ziming\LaravelMyinfoSg\LaravelMyinfoSg;

class GetMyinfoPersonDataController extends Controller
{
    /**
     * Fetch MyInfo Person Data after authorization code is given back.
     *
     * @throws \Exception
     */
    public function __invoke(Request $request, LaravelMyinfoSg $laravelMyinfoSg): \Illuminate\Http\JsonResponse
    {
        $state = $request->input('state');

        if ($state === null || $state !== $request->session()->pull('state')) {
            throw new InvalidStateException;
        }

        $code = $request->input('code');

        $personData = $laravelMyinfoSg->getMyinfoPersonData($code);

        $this->preResponseHook($request, $personData);

        return response()->json($personData);
    }

    protected function preResponseHook(Request $request, array $personData)
    {
        // Extend this class, override this method.
        // And do your logging and whatever stuffs here if needed.
        // person information is in the 'data' key of $personData array.
    }
}
