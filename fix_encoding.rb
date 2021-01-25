#!/usr/bin/env ruby

require 'cgi'
require 'iconv'
require 'mysql'

DB_CONNECTION_DATA = File.expand_path('etc/db_connection_data.txt', File.dirname(__FILE__))
def connect
  db_data = load_db_connection_data
  Mysql.new(db_data['host'], db_data['user'], db_data['password'], db_data['db'])
end
def load_db_connection_data
  hash = {}
  File.foreach(DB_CONNECTION_DATA) do |line|
    if(match = /(\w+)\s*=\s*([^\s]+)/.match(line))
      hash.store(match[1], match[2])
    end
  end
  hash
end

conn = connect
latin1 = Iconv.new('iso-8859-1', 'utf-8')
utf8   = Iconv.new('utf-8', 'iso-8859-1')

query = <<-EOS
SELECT id, Titel, Zusammenfassung, location, Zielpublikum
FROM vortrag
ORDER BY id
EOS
result = conn.query(query)
weird_ids = []
result.each do |row|
  needs_save = false
  id = row.first
  row.collect! do |orig|
		next unless orig
		orig = CGI.escape CGI.unescape(orig)
    if !/(%[A-F0-9]{2}){3,}/.match(orig)
      unesc = CGI.unescape orig
      conv = begin
               latin1.iconv unesc
							 unesc
             rescue Exception => e
               needs_save = true
               utf8.iconv unesc
             end
=begin
      store = CGI.escape conv
      if /(%[A-F0-9]{2}){4,}/.match(store)
				puts orig.inspect
				puts orig.inspect
        puts unesc.inspect
        puts conv.inspect
				puts store.inspect
        weird_ids.push id
      end
      store
=end
      conv
    end
  end
  if needs_save
		id, title, abstract, location, target = row.collect do |field| 
			field ?  "'" << conn.escape_string(field) << "'" : 'NULL'
		end
		sql = <<-EOS
UPDATE vortrag
SET Titel=#{title}, Zusammenfassung=#{abstract}, location=#{location}, Zielpublikum=#{target}
WHERE id=#{id}
		EOS
		conn.query sql
  end
end

puts weird_ids.uniq.collect do |id| id.to_i end
