package main

import (
	"context"
	"encoding/json"
	"fmt"
	"github.com/apache/thrift/lib/go/thrift"
	"os"
	"resource_client/gen-go/ResourceService"
	"strconv"
)

func resourceInvoke(host string, port int, method, path, query string) (*ResourceService.ResourceResponse, error) {
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

func main() {
	if len(os.Args) < 5 {
		fmt.Println("Usage: [executable] hostname port method path [query]")
		return
	}

	hostname := os.Args[1]
	port, err := strconv.Atoi(os.Args[2])
	if err != nil {
		fmt.Println("Error parsing port:", err)
		return
	}

	method := os.Args[3]
	path := os.Args[4]
	query := ""
	if len(os.Args) > 5 {
		query = os.Args[5]
	}

	response, err := resourceInvoke(hostname, port, method, path, query)
	if err != nil {
		fmt.Println("Error:", err)
		return
	}

	fmt.Println("Response Code:", response.Code)
	fmt.Println("Response Headers:", response.Headers)
	fmt.Println("Raw Response JsonValue: ", response.JsonValue)

	var value interface{}
	err = json.Unmarshal([]byte(response.JsonValue), &value)
	if err != nil {
		fmt.Println("Error Unmarshaling JSON: ", err)
	} else {
		fmt.Println("Response Value: ", value)
	}

	fmt.Println("Response View:", response.View)
}
