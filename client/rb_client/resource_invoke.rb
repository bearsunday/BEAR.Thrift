require 'thrift'
require './gen_rb/resource_service'
require './gen_rb/resource_service_types'

class ResourceInvoke
  def initialize(host, port)
    @socket = Thrift::Socket.new(host, port)
    @transport = Thrift::BufferedTransport.new(@socket)
    @protocol = Thrift::BinaryProtocol.new(@transport)
    @client = ResourceService::ResourceService::Client.new(@protocol)
  end

  def call(method, uri)
    @socket.open unless @socket.open?
    request = ResourceService::ResourceRequest.new(method: method, uri: uri)

    begin
      response = @client.invokeRequest(request)
    rescue => e
      puts "Error: #{e.message}"
      puts "Backtrace: #{e.backtrace.join("\n")}"
    end
  rescue Thrift::Exception => e
    "Error: #{e.message}"
  ensure
    @socket.close if @socket.open?
    response
  end
end
