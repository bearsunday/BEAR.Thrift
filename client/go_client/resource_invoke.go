// resource_invoke.go_client
package main

import (
	"context"
	"fmt"
	"github.com/apache/thrift/lib/go/thrift"
	"go_client/gen-go/ResourceService"
)

func ResourceInvoke(host string, port int, method, path, query string) (*ResourceService.ResourceResponse, error) {
	var transport thrift.TTransport
	transport, err := thrift.NewTSocket(fmt.Sprintf("%s:%d", host, port))
	if err != nil {
		return nil, fmt.Errorf("error resolving address: %v", err)
	}
	transport = thrift.NewTBufferedTransport(transport, 8192)

	protocol := thrift.NewTBinaryProtocolTransport(transport)
	client := ResourceService.NewResourceServiceClient(thrift.NewTStandardClient(protocol, protocol))

	if err := transport.Open(); err != nil {
		return nil, fmt.Errorf("error opening transport: %v", err)
	}

	defer transport.Close()

	request := ResourceService.ResourceRequest{
		Method: method,
		Path:   path,
		Query:  query,
	}

	response, err := client.InvokeRequest(context.Background(), &request)
	if err != nil {
		return nil, fmt.Errorf("error invoking request: %v", err)
	}

	return response, nil
}
