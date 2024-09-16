<?php namespace Legato\Api\Api;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;

class AuthVerificationCheck extends AbstractAuth
{
    /**
     * @Post(
     *     path="/api/v1/auth/login",
     *     summary="Login",
     *     tags={"Auth"},
     *     @Parameter(ref="#/components/parameters/lang"),
     *     @RequestBody(
     *          @MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @Schema(
     *                  required="user,password",
     *                  @Property(property="user", ref="#/components/schemas/UserField"),
     *                  @Property(property="password", ref="#/components/schemas/PasswordField")
     *              )
     *          ),
     *      ),
     *     @Response(
     *          response="200",
     *          description="OK",
     *          @JsonContent(
     *              @Property(property="message", type="string", example="OK"),
     *              @Property(property="server_time", ref="#/components/schemas/ServerTimeField"),
     *              @Property(property="data", type="object",
     *                  @Property(property="user_token", ref="#/components/schemas/UserTokenField"),
     *                  @Property(property="user", ref="#/components/schemas/User")
     *              ),
     *          ),
     *     ),
     *     @Response(response="400", ref="#/components/responses/BadRequestResponse"),
     *     @Response(response="401", ref="#/components/responses/UnAuthorizedResponse"),
     *     @Response(response="403", ref="#/components/responses/ForbiddenResponse"),
     *     @Response(response="500", ref="#/components/responses/InternalErrorResponse"),
     * )
     * @throws ValidationException
     */
    public function __invoke(Request $request): array
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'user' => 'required',
            'password' => 'required',
        ]);

        return $this->userRepository->apiLogin($params);
    }
}
