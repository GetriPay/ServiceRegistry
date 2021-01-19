<?php
/**
 * Created by PhpStorm.
 * User: BABATUNDE
 * Date: 1/19/2021
 * Time: 2:24 PM
 */

namespace GetriPay\ServiceRegistry\Middleware;

use Closure;
use GetriPay\ServiceRegistry\ServiceRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Console\Command;


class AuthenticateService
{
    protected $crypton;

    public function __construct()
    {
        $this->crypton = ServiceRegistry::make();
    }

    public function handle(Request $request, Closure $next)
    {
        $services = cache("registry_services");

        if(!$request->has(config("service-registry.service_auth_header"))){
            throw new \Exception("Missing Service header");
        }
        $service = $request->header(config("service-registry.service_auth_header"));
        if($services instanceof Collection){
            $service_src = $services->firstWhere("SERVICE_NAME", $service);
            if(!$service_src) throw new \Exception("Unknown Service");
        } else {
            if(!in_array($service, $services)){
                throw new \Exception("Unknown Service");
            }
        }

        if ($request->header('X-REQUEST-ENCRYPTED')) {
            $this->modifyRequest($request);
        }

        $response = $next($request);
        if ($response instanceof JsonResponse) {
            if(config("service-registry.enc_response") == true){
                $this->modifyResponse($request, $response);
            }
        }

        return $response;
    }

    protected function modifyRequest(Request $request)
    {
        $decrypted = $request->payload ? $this->crypton->decrypt($request->payload) : null;
        if ($decrypted) {
            $request->merge($decrypted);
            $request->replace($request->except('payload'));
        }
    }

    protected function modifyResponse(Request $request, JsonResponse $response)
    {
        if ($request->header('X-RESPONSE-ENCRYPTED')) {
            $payload = ['payload' => $this->crypton->encrypt(json_decode($response->content(), true))];

            $response->setContent(json_encode($payload));
            $response->header('X-RESPONSE-ENCRYPTED', "1");
        }
    }
}