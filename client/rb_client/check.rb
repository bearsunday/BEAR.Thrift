# Check versions of Ruby and gems
puts "Ruby version: #{RUBY_VERSION}"
puts "Installed gems:"
puts `gem list`

# Check environment variables
puts "Environment variables:"
puts ENV.to_h
