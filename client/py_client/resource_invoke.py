# resource_invoke.py
from thrift.protocol import TBinaryProtocol
from thrift.transport import TSocket, TTransport
from thrift import Thrift
from gen_py.ResourceService import ResourceService
from gen_py.ResourceService.ttypes import ResourceRequest

def ResourceInvoke(host, port, method, path, query):
    transport = TTransport.TBufferedTransport(TSocket.TSocket(host, port))
    protocol = TBinaryProtocol.TBinaryProtocol(transport)
    client = ResourceService.Client(protocol)

    transport.open()

    request = ResourceRequest()
    request.method = method
    request.path = path
    request.query = query

    try:
        response = client.invokeRequest(request)
    except Thrift.TException as tx:
        print("Error invoking request: %s" % tx.message)
        return None

    transport.close()

    return response