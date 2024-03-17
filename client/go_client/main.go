// main.go_client
package main

import (
	"encoding/json"
	"fmt"
	"os"
	"strconv"
)

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

	response, err := ResourceInvoke(hostname, port, method, path, query)
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
