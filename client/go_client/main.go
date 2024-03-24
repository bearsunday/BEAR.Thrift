// main.go_client
package main

import (
	"encoding/json"
	"fmt"
	"os"
	"strconv"
)

func main() {
	if len(os.Args) < 4 {
		fmt.Println("Usage: [executable] hostname port method uri")
		return
	}

	hostname := os.Args[1]
	port, err := strconv.Atoi(os.Args[2])
	if err != nil {
		fmt.Println("Error parsing port:", err)
		return
	}

	method := os.Args[3]
	uri := os.Args[4]

	response, err := ResourceInvoke(hostname, port, method, uri)
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
