// ResourceService.thrift

namespace php ResourceService
namespace go ResourceService

struct ResourceRequest {
    1: string method,
}

struct ResourceResponse {
    1: i32 code,
}

service ResourceService {
    ResourceResponse invokeRequest(1:ResourceRequest request)
}
