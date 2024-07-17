<?php

namespace Legato\Api\Api;

use Illuminate\Http\Request;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Response;

class AuthLogout extends AbstractAuth
{
    /**
     * @Post(
     *     path="/api/v1/auth/logout",
     *     summary="Logout",
     *     tags={"Auth"},
     *     security={{
     *          "bearerAuth":{}
     *     }},
     *     @Parameter(ref="#/components/parameters/lang"),
     *     @Response(
     *          response="200",
     *          description="OK",
     *          @JsonContent(
     *              @Property(property="message", type="string", example="OK"),
     *              @Property(property="server_time", ref="#/components/schemas/ServerTimeField"),
     *          ),
     *     ),
     *     @Response(response="401", ref="#/components/responses/UnAuthorizedResponse"),
     *     @Response(response="500", ref="#/components/responses/InternalErrorResponse"),
     * )
     */
    public function __invoke(Request $request)
    {
        $this->userRepository->apiLogout($request);
    }
}
