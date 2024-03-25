# main_client.rb

$LOAD_PATH.unshift(File.expand_path('./gen_rb/'))

require 'json'
require_relative './gen_rb/resource_service'
require_relative 'resource_invoke'

def main
  if ARGV.length < 4
    puts "Usage: ruby main_client.rb hostname port method uri"
    return
  end

  hostname = ARGV[0]
  port = ARGV[1].to_i
  method = ARGV[2]
  uri = ARGV[3]

  resource_invoke = ResourceInvoke.new(hostname, port)
  response = resource_invoke.call(method, uri)

  if response.is_a?(String) && response.start_with?("Error:")
    puts response
    return
  end

  puts "Response Code: #{response.code}"
  puts "Response Headers: #{response.headers}"
  puts "Raw Response JsonValue: #{response.jsonValue}"
  puts "Response View: #{response.view}"
end

main
