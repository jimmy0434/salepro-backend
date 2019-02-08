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
     *          response = 200,
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
     *          response = 200,
     *          description = "Salesman Refresh Response",
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */

    /**
     * @SWG\Get(
     *     path="/notifications",
     *     tags={"Notification"},
     *     summary="Notifications List",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Notifications List Response",
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="page", required=true, in="query", type="integer", description="Page start from 1", default=1),
     *     @SWG\Parameter(name="pageSize", required=true, in="query", type="integer", description="Page Size default 25", default=25),
     * )
     */

    /**
     * @SWG\Get(
     *     path="/notifications/latest",
     *     tags={"Notification"},
     *     summary="Latest Notifications List",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Latest Notifications List Response",
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     * )
     */

    /**
     * @SWG\Post(
     *      path="/notifications/read",
     *      tags={"Notification"},
     *      summary="Mark Notification as Read",
     *      @SWG\Response(
     *          response = 200,
     *          description = "Mark Notification as Read Response",
     *      ),
     *      security = {{"Bearer": {}}},
     *      @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *      @SWG\Parameter(name="id", required=true, in="formData", type="integer", description="Notification ID"),
     * )
     */

    /**
     * @SWG\Post(
     *      path="/notifications/push/registration",
     *      tags={"Notification"},
     *      summary="Push Notification Registration",
     *      @SWG\Response(
     *          response = 200,
     *          description = "Push Notification Registration Response",
     *      ),
     *      @SWG\Parameter(name="regId", required=true, in="formData", type="string", description="Device Registration ID"),
     *      @SWG\Parameter(name="platform", required=true, in="formData", type="string", description="Device Platform Type, android|ios|windows"),
     *      @SWG\Parameter(name="userId", required=false, in="formData", type="integer", description="User ID"),
     * )
     */
}
