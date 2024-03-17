// ResourceService.thrift

namespace php ResourceService
namespace go ResourceService

struct ResourceRequest {
    1: string method,
    2: string uri,
    3: string query
}

struct ResourceResponse {
    1: i32 code,
    2: list<string> headers,
    3: string jsonValue,
    4: string view
}

service ResourceService {
    ResourceResponse invokeRequest(1:ResourceRequest request)
}
