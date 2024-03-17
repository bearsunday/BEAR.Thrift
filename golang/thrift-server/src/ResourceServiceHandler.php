<?php
namespace BEARSunday\Thrift;

use ResourceService\ResourceRequest;
use ResourceService\ResourceResponse;
use ResourceService\ResourceServiceIf;

class ResourceServiceHandler implements ResourceServiceIf {
    public function invokeRequest(ResourceRequest $request): ResourceResponse
    {
        // リクエストの処理ロジックをここに記述します。

        // ここでは、ダミーレスポンスを返すようにしています。
        $response = new ResourceResponse();
        $response->code = 200;
        $response->headers = [];
        $response->value = 'hello';
        $response->view = 'Hello';

        return $response;
    }
}
