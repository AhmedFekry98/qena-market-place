<?php

namespace App\Features\AuthManagement\Controllers;

use App\Features\AuthManagement\Models\ExpoToken;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ExpoController extends Controller
{
    use ApiResponses;


    /**
        * Inject your service in constructor
        */
    public function __construct() {}



    /**
        * Store a newly created resource in storage.
        */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $result = ExpoToken::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'token' => $validated['token'],
            ],
            ['updated_at' => now()]
        );

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            $result,
            "Success api call"
        );
    }

}
