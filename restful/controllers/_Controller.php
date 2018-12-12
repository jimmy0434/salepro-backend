<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/12/2018
 * Time: 4:20 PM
 */

namespace restful\controllers;

use Swagger\Annotations as SWG;

class _Controller
{
    /**
     * @SWG\Post(
     *     path="/login",
     *     tags={"User"},
     *     summary="Salesman Login",
     *
     *     @SWG\Response(
     *         response = 200,
     *         description = "Salesman Login Response",
     *         @SWG\Schema(ref = "#/definitions/User")
     *     ),
     *
     *
     *     @SWG\Parameter(name="username", required=true, in="formData", type="string", description="Username of Salesman"),
     *     @SWG\Parameter(name="password", required=true, in="formData", type="string", description="Password of Salesman"),
     *     @SWG\Parameter(name="macAddress", required=true, in="formData", type="string", description="MacAddress of Salesman")
     * )
     */

    /**
     * @SWG\Post(
     *     path="/logout",
     *     tags={"User"},
     *     summary="Salesman Logout",
     *     @SWG\Response(
     *         response = 200,
     *          description = "Salesman Logout Response",
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */

    /**
     * @SWG\Post(
     *     path="/refresh",
     *     tags={"User"},
     *     summary="Salesman Refresh Data",
     *     @SWG\Response(
     *         response = 200,
     *          description = "Salesman Refresh Response",
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
}