package main

import (
	"context"
	"fmt"
	"github.com/apache/thrift/lib/go/thrift"
	"resource_client/thrift-server/gen-go/ResourceService" // 生成されたコードへのパスを適宜調整してください
)

// resourceInvoke関数の定義
func resourceInvoke(method, uri, query string) (*ResourceService.ResourceResponse, error) {
	// Thriftクライアントの設定
	var transport thrift.TTransport
	transport, err := thrift.NewTSocket("localhost:9090") // サーバーのアドレスを指定
	if err != nil {
		return nil, fmt.Errorf("error opening socket: %v", err)
	}
	transport = thrift.NewTBufferedTransport(transport, 8192)
	protocol := thrift.NewTBinaryProtocolTransport(transport)
	client := ResourceService.NewResourceServiceClient(thrift.NewTStandardClient(protocol, protocol))

	// Thriftサーバーへの接続を開始
	if err := transport.Open(); err != nil {
		return nil, fmt.Errorf("error opening transport: %v", err)
	}
	defer transport.Close()

	// ResourceRequestの作成
	request := ResourceService.ResourceRequest{
		Method: method,
		URI:    uri,
		Query:  query,
	}

	// invokeRequestメソッドの呼び出し
	response, err := client.InvokeRequest(context.Background(), &request)
	if err != nil {
		return nil, fmt.Errorf("error invoking request: %v", err)
	}

	return response, nil
}

func main() {
	//if len(os.Args) != 4 {
	//	fmt.Println("Usage: [executable] method uri query")
	//	return
	//}

	// コマンドライン引数からリクエストのパラメータを取得
	//method := os.Args[1]
	//uri := os.Args[2]
	//query := os.Args[3]

	method := "GET"
	uri := "/user"
	query := ""

	// resourceInvoke関数を呼び出し
	response, err := resourceInvoke(method, uri, query)
	if err != nil {
		fmt.Println("Error:", err)
		return
	}

	// レスポンスの内容を表示
	fmt.Println("Response Code:", response.Code)
	fmt.Println("Response Headers:", response.Headers)
	//fmt.Println("Response Value:", response.Value)
	//fmt.Println("Response View:", response.View)
}
