import sys
import json
from resource_invoke import ResourceInvoke

def main():
    if len(sys.argv) < 5:
        print("Usage: python3 main.py hostname port method path [query]")
        return

    hostname = sys.argv[1]
    port = int(sys.argv[2])
    method = sys.argv[3]
    path = sys.argv[4]
    query = ""
    if len(sys.argv) > 5:
        query = sys.argv[5]

    response = ResourceInvoke(hostname, port, method, path, query)
    if not response:
        print("Request failed.")
        return

    print("Response Code:", response.code)
    print("Response Headers:", response.headers)
    print("Raw Response JsonValue:", response.jsonValue)

    try:
        value = json.loads(response.jsonValue)
    except json.JSONDecodeError as j_error:
        print("Error Unmarshalling JSON:", j_error)
        return

    print("Response Value:", value)
    print("Response View:", response.view)

if __name__ == "__main__":
    main()