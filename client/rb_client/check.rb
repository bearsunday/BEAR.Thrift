# Check versions of Ruby and gems
puts "Ruby version: #{RUBY_VERSION}"
puts "Installed gems:"
puts `gem list`

# Check environment variables
puts "Environment variables:"
puts ENV.to_h

# Check existence and content of important files
files_to_check = [
  "/path/to/file1",
  "/path/to/file2",
# add more file paths here
]
files_to_check.each do |file|
  if File.exist?(file)
    puts "Content of #{file}:"
    puts File.read(file)
  else
    puts "File #{file} does not exist"
  end
end