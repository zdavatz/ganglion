#!/usr/bin/env ruby
# CreateRSS2 -- davaz.com -- 27.04.2006 -- mhuggler@ywesee.com

require 'time'
require 'mysql'
require 'rss/maker'
require 'iconv'
require 'cgi'

class Vortrag
	attr_accessor :titel, :zusammenfassung, :gehalten, :location
	attr_accessor :audiofile, :zielpublikum
	attr_accessor :audiofile_size
	attr_reader :categories
	def initialize
		@categories = []
	end
end
class CreateRSS2
	DB_CONNECTION_DATA = File.expand_path('etc/db_connection_data.txt', File.dirname(__FILE__))
	def initialize
		@values = {
			:author				=>	'Frau. Dr. med. Ursula Davatz',
			:copyright		=>	'Copyright: (C) Ganglion.ch',
			:description	=>	'Vorträge von Frau Dr. med. Ursula Davatz',
			:email				=> 'udavatz@ganglion.ch',
			:explicit			=> 'no',
			:generator		=> 'ganglion.ch',
			:image_url		=> 'http://www.ganglion.ch/images/drdavatz.jpg',
			:image_title	=> 'Frau. Dr. med. Ursula Davatz',
			:subtitle			=> 'Alle Vorträge finden sich auf der Homepage',
			:summary			=> 'Zusammenfassung',
			:title				=> 'Vorträge von der Website Ganglion.ch',
			:ttl					=> '600',
			:language			=> 'DE',
			:last_build_date => Time.now.rfc2822,
			:link					=> 'http://www.ganglion.ch/html/vortraege.php',
			:web_master		=> 'mhuggler@ywesee.com',
		}
		@categories = [
			'Family',
			'Education',
			'Science',
			'International',
		]
		@connection = connect
	end
	def connect
		db_data = load_db_connection_data
		Mysql.new(db_data['host'], db_data['user'], db_data['password'], db_data['db'])
	end
	def load_db_connection_data
		hash = {}
		File.foreach(self.class::DB_CONNECTION_DATA) { |line|
			if(match = /(\w+)\s*=\s*([^\s]+)/.match(line))
				hash.store(match[1], match[2])
			end
		}
		hash
	end
	def connection
		@connection ||= connect
	end
	def read_mysql_data
		connection.query("SET NAMES 'utf8'")
		connection.query("SET CHARACTER SET 'utf8'")
		query = <<-EOS
			SELECT Titel, Zusammenfassung, gehalten, location, 
			audiofile, Zielpublikum, audiofile_size
			FROM vortrag
			WHERE audiofile != ''
			ORDER BY gehalten
		EOS
		result = connection.query(query)
		lectures = []
		result.each_hash { |row| 
			lecture = Vortrag.new	
			row.each { |key, value|
				method = "#{key.downcase}=".to_sym	
				if(lecture.respond_to?(method))
					lecture.send(method, CGI::unescape(value.to_s))
				end
				if(key=='Arbeit' && value=='1')
					lecture.categories.push('Work')
				end
				if(key=='Erziehung' && value=='1')
					lecture.categories.push('Education')
				end
				if(key=='Gesundheit' && value=='1')
					lecture.categories.push('Health')
				end
				if(key=='Familie' && value=='1')
					lecture.categories.push('Family')
				end
			}
			lectures.push(lecture)
		}
		lectures
	end
	def enc(string)
		string
	end
	def make_rss
		lectures = read_mysql_data
		@rss = RSS::Maker.make("2.0") { |maker| 
			channel = maker.channel
			channel.title = enc(@values[:title])
			channel.description = enc(@values[:description])
			channel.language = @values[:language]
			channel.link = @values[:link]
			channel.lastBuildDate = @values[:last_build_date]
			channel.generator = @values[:generator]
			channel.copyright = @values[:copyright]
			channel.ttl = @values[:ttl]
			@categories.each { |category| 
				cat = channel.categories.new_category	
				cat = category
			}

			maker.image.url = @values[:image_url]
			maker.image.title = @values[:image_title]

			category = channel.categories.new_category
			category.content = "Education"
			category = channel.categories.new_category
			category.content = "Work"
			category = channel.categories.new_category
			category.content = "Science"
			category = channel.categories.new_category
			category.content = "Family"
			category = channel.categories.new_category
			category.content = "Health"

			lectures.each { |lct| 
				path = "http://ganglion.zftp.com/#{lct.audiofile}"
				description = <<-EOS
Dieser Vortrag wurde am #{Time.parse(lct.gehalten).strftime('%d.%m.%Y')} in #{lct.location} für #{lct.zielpublikum} gehalten.
#{lct.zusammenfassung}
				EOS
				item = maker.items.new_item
				item.title = enc(lct.titel)
				item.link = @values[:link]
				item.description = enc(description)
				item.date = Time.parse(lct.gehalten).rfc2822
				item.author = @values[:email]
				item.enclosure.url = path 
				item.enclosure.type = "audio/x-m4a"
				item.enclosure.length = lct.audiofile_size
				item.guid.content = path 
				lct.categories.each { |category| 
					cat = item.categories.new_category	
					cat = category
				}
			}
		}
		file = File.new(File.expand_path("doc/feed.xml", File.dirname(__FILE__)), "w")
		file << @rss
		log = File.open(File.expand_path("log/feed_log", File.dirname(__FILE__)), "a")
		log << "New feed xml written on #{Time.now}\n"
	end
end

rss = CreateRSS2.new
rss.make_rss
